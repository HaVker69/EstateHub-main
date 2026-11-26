#!/bin/sh
set -e

php artisan migrate --force
php artisan db:seed --class=ProductionSeeder --force

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

exec "$@"
