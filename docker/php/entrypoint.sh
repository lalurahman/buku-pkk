#!/bin/sh
set -e

cd /var/www/html

if [ ! -f .env ]; then
    cp .env.example .env
fi

if [ ! -f vendor/autoload.php ]; then
    composer install --no-interaction --optimize-autoloader
fi

if ! grep -q "^APP_KEY=base64" .env; then
    php artisan key:generate --force
fi

# Wait for MySQL to accept connections before migrating
if [ "$1" = "php-fpm" ]; then
    until php artisan db:show > /dev/null 2>&1; do
        echo "Waiting for database connection..."
        sleep 2
    done

    php artisan migrate --force

    chown -R www-data:www-data storage bootstrap/cache
fi

exec "$@"
