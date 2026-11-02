#!/bin/sh

set -eu

require_env() {
    eval "value=\${$1:-}"

    if [ -z "$value" ]; then
        echo "ERROR: $1 must be set." >&2
        exit 64
    fi
}

require_env APP_KEY
require_env APP_URL

mkdir -p \
    storage/app/private \
    storage/app/public \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs
chown -R www-data:www-data storage

export DB_CONNECTION="${DB_CONNECTION:-sqlite}"

case "$DB_CONNECTION" in
    sqlite)
        export DB_DATABASE="${DB_DATABASE:-/var/www/html/storage/app/treehunter.sqlite}"
        mkdir -p "$(dirname "$DB_DATABASE")"
        touch "$DB_DATABASE"
        chown www-data:www-data "$DB_DATABASE"
        ;;
    mysql|mariadb)
        require_env DB_HOST
        require_env DB_DATABASE
        require_env DB_USERNAME
        require_env DB_PASSWORD
        ;;
    *)
        echo "ERROR: DB_CONNECTION must be sqlite, mysql, or mariadb." >&2
        exit 64
        ;;
esac

if [ "${AUTO_MIGRATE:-true}" = "true" ]; then
    retry_limit="${DB_MIGRATION_RETRIES:-30}"
    retry_interval="${DB_MIGRATION_RETRY_INTERVAL:-2}"
    attempt=1

    until php artisan migrate --force --no-interaction; do
        if [ "$attempt" -ge "$retry_limit" ]; then
            echo "ERROR: Database migrations failed after $attempt attempts." >&2
            exit 1
        fi

        echo "Database is not ready; retrying migration ($attempt/$retry_limit)..." >&2
        attempt=$((attempt + 1))
        sleep "$retry_interval"
    done
fi

exec "$@"
