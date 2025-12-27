#!/bin/sh

set -e

echo "Waiting for database connection..."
until php artisan db:show --quiet 2>/dev/null; do
    echo "Database is unavailable - sleeping"
    sleep 1
done

echo "Database is up - executing migrations..."

# Run migrations
php artisan migrate --force

# Clear and cache config
php artisan config:clear
php artisan config:cache

# Clear and cache routes
php artisan route:clear
php artisan route:cache

# Clear and cache views
php artisan view:clear
php artisan view:cache

# Optimize
php artisan optimize

echo "Application is ready!"

exec "$@"

