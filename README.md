# TreeHunter

Licensed under the [MIT License](LICENSE).

TreeHunter is a mobile-friendly Laravel application for recording and managing forest trees. This repository is a production-focused source package: it includes the Docker image definition and a complete standalone Docker Compose setup, but excludes development-only files, tests, caches, and dependency directories.

## Quick start

Requirements: Docker Engine with Docker Compose v2 and a free local port `8080`.

```bash
cp .env.example .env
docker compose build app
docker compose run --rm --entrypoint php app artisan key:generate --show
```

Copy the generated `base64:...` value into `APP_KEY` in `.env`. Then start the application:

```bash
docker compose up -d
```

Open [http://localhost:8080](http://localhost:8080) and register the initial user. The standalone setup uses a persistent SQLite database and applies its migrations automatically on startup.

View service logs with `docker compose logs -f`, and stop the stack with `docker compose down`. Database data remains in the `treehunter-storage` Docker volume. To intentionally remove all local data, run `docker compose down --volumes`.

## Configuration

Copy `.env.example` to `.env`; do not commit `.env` or pass it into the image build.

| Variable | Required | Purpose |
| --- | --- | --- |
| `APP_KEY` | Yes | Persistent Laravel encryption key. Generate it once; changing it invalidates encrypted data and sessions. |
| `APP_URL` | Yes | Public application URL. Use an HTTPS URL for a deployed service. |
| `DB_CONNECTION` | No | Defaults to `sqlite`. Set to `mysql` or `mariadb` for an external database. |
| `DB_DATABASE` | No for SQLite; yes for MySQL/MariaDB | SQLite uses the persistent default path when empty. For an external database, set its database name. |
| `DB_HOST`, `DB_PORT`, `DB_USERNAME`, `DB_PASSWORD` | Required for MySQL/MariaDB | External database connection details. `DB_PORT` defaults to `3306`. |
| `APP_PORT` | No | Host port mapped to the application; defaults to `8080`. |
| `APP_NAME` | No | User-facing application name; defaults to `TreeHunter`. |
| `REGISTRATION_ENABLED` | No | Defaults to `true`. Set to `false` after onboarding to close public sign-up. |
| `SESSION_SECURE_COOKIE` | Recommended | Set to `true` behind HTTPS. Keep `false` for local HTTP. |
| `AUTO_MIGRATE` | No | Defaults to `true`; runs outstanding migrations at startup. |
| `MAIL_*` | No | SMTP settings for email verification and password reset. The default `MAIL_MAILER=log` writes mail to container logs. |

For SMTP delivery, set `MAIL_MAILER=smtp` along with `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_SCHEME` (`smtp` or `smtps`), `MAIL_FROM_ADDRESS`, and `MAIL_FROM_NAME`.

## Deployment notes

Set `APP_URL` to the externally reachable HTTPS URL and `SESSION_SECURE_COOKIE=true`. Put a TLS reverse proxy in front of the `app` service; the container itself listens on HTTP port 80. Back up the `treehunter-storage` volume and use a secret manager or protected deployment environment for production values.

The image supports an external MySQL or MariaDB instance as well. In that case, set `DB_CONNECTION=mysql` (or `mariadb`) plus `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in `.env`; the Compose stack will then use that external database.

## Image tags

Images built from `main` receive `main`, `latest`, and an immutable `sha-<12-character-source-SHA>` tag. Prefer the SHA tag for a deployment that must remain pinned to one exact source revision. The GitHub mirror carries the corresponding `source-<same-SHA>` Git tag.
