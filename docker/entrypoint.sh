#!/bin/bash

if [ ! -f "vendor/autoload.php" ]; then
    composer install --ignore-platform-req=ext-bcmath
fi

if [ ! -d "node_modules" ]; then
    npm install --global cross-env
    npm install
    npm update
    npm run build
fi

php artisan key:generate
php artisan config:cache
php artisan migrate --seed
php artisan cache:clear
php artisan config:clear
php artisan route:clear

php artisan serve --host=0.0.0.0 --env=.env
exec docker-php-entrypoint "$@"
