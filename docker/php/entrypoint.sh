#!/bin/bash

chown -R www-data:www-data *

if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction
fi

if [ ! -f ".env" ]; then
    echo "Creating env file for env $APP_ENV"
    cp .env.example .env
else
    echo "env file exists."
fi

php artisan key:generate
# php artisan storage:link
php artisan couchbase:setup
# php artisan migrate
# php artisan db:seed
php artisan cache:clear
php artisan config:clear
php artisan route:clear

exec "$@"