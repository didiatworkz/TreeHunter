# syntax=docker/dockerfile:1

FROM node:22-bookworm-slim AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY resources ./resources
COPY public ./public
COPY vite.config.js ./
RUN npm run build


FROM composer:2 AS dependencies

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader


FROM php:8.4-apache-bookworm AS extensions

RUN apt-get update \
    && apt-get install --no-install-recommends -y libonig-dev libsqlite3-dev \
    && docker-php-ext-install -j"$(nproc)" mbstring pdo_mysql pdo_sqlite \
    && rm -rf /var/lib/apt/lists/*


FROM php:8.4-apache-bookworm AS application

WORKDIR /var/www/html

ENV APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr \
    APP_NAME=TreeHunter \
    REGISTRATION_ENABLED=true \
    AUTO_MIGRATE=true

RUN apt-get update \
    && apt-get install --no-install-recommends -y libonig5 libsqlite3-0 \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf
COPY docker/entrypoint.sh /usr/local/bin/treehunter-entrypoint
COPY --from=extensions /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=extensions /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/
COPY --from=dependencies /app/vendor ./vendor
COPY artisan ./
COPY app ./app
COPY bootstrap/app.php bootstrap/providers.php ./bootstrap/
COPY config ./config
COPY database/migrations ./database/migrations
COPY --from=frontend /app/public/build ./public/build
COPY public ./public
COPY resources/views ./resources/views
COPY routes ./routes

RUN mkdir -p \
        bootstrap/cache \
        storage/app/private \
        storage/app/public \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod +x /usr/local/bin/treehunter-entrypoint

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/treehunter-entrypoint"]
CMD ["apache2-foreground"]
