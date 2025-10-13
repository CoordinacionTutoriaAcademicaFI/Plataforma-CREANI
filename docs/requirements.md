# Requerimientos / Stack reproducible — Plataforma Precalculo

Este documento deja por escrito **qué necesitas** y **cómo reproducir** el entorno de desarrollo con Docker tal como corre en este repo.

---

## 1) Prerrequisitos

- **Git**
- **Docker Desktop** 24+ y **Docker Compose v2+**
- CPU 2+ cores, **RAM 4 GB** (8 GB recomendado si corres Vite en dev)
- Puertos libres: **8080** (app), **5432** (DB), **5050** (pgAdmin), **5173** (Vite), **8025/1025** (Mailpit)

---

## 2) Servicios (docker-compose)

| Servicio | Imagen:tag                  | Contenedor           | Puertos                               | Descripción |
|---------|------------------------------|----------------------|---------------------------------------|-------------|
| app     | `plataforma-creani-app:latest` | `precalculo_app`     | `8080:80`                             | PHP 8.2 + Apache (Laravel) |
| db      | `postgres:14`                | `precalculo_db`      | `5432:5432`                           | PostgreSQL 14 |
| pgadmin | `dpage/pgadmin4:latest`      | `precalculo_pgadmin` | `5050:80`                             | GUI DB |
| node    | `node:20`                    | `precalculo_node`    | `5173:5173`                           | Vite / npm |
| mailpit | `axllent/mailpit:latest`     | `precalculo_mailpit` | `8025:8025` (UI), `1025:1025` (SMTP)  | Correo de pruebas |

**Volúmenes:** `plataforma-creani_vendor`, `plataforma-creani_node_modules`, `plataforma-creani_node_modules_node`, `plataforma-creani_db-data`  
**Código montado:** `./src → /var/www/html` (app), `./src → /app` (node)

---

## 3) Versiones exactas (detectadas)

**Backend**
- PHP: **8.2.29**
- Laravel: **12.33.0**
- Apache: **2.4.65 (Debian)**
- Composer: **2.8.12**
- Extensiones PHP clave: `pdo_pgsql`, `mbstring`, `intl`, `gd`, `zip`, `bcmath` (ver `php -m`)

**Frontend**
- Node: **v20.19.5**
- npm: **10.8.2**

**Base de datos**
- PostgreSQL/psql: **14.19**

> Listados de paquetes bloqueados:
> - PHP: `docs/php-packages.lock.json` (generado con `composer show --locked --format=json`)
> - JS: `docs/npm-packages.lock.json` (generado con `npm ls --depth=0 --json`)

---

## 4) Variables de entorno (plantilla para `src/.env.example`)

> **No** publiques tu `APP_KEY` real ni subas `src/.env`. Usa este ejemplo:

```env
APP_NAME="Plataforma Precalculo"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8080

APP_LOCALE=es
APP_FALLBACK_LOCALE=es
APP_FAKER_LOCALE=es_MX

APP_MAINTENANCE_DRIVER=file
PHP_CLI_SERVER_WORKERS=4

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

# ---- DB: Postgres (contenedor "db") ----
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=precalculo
DB_USERNAME=precalculo
DB_PASSWORD=precalculo

# ---- Sesiones / Caché / Cola (simple para dev) ----
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
CACHE_STORE=file
QUEUE_CONNECTION=sync
BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local

# ---- Redis/Memcached (no usado en dev) ----
MEMCACHED_HOST=127.0.0.1
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# ---- Correo (Mailpit) ----
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="no-reply@precalculo.test"
MAIL_FROM_NAME="Plataforma Precálculo"

VITE_APP_NAME="${APP_NAME}"
