#!/bin/sh

set -e

echo "Starting application..."

# Wait for database connection (with timeout)
echo "Waiting for database connection..."
timeout=30
counter=0
until php artisan db:show --quiet 2>/dev/null || [ $counter -ge $timeout ]; do
    echo "Database is unavailable - sleeping ($counter/$timeout)"
    sleep 1
    counter=$((counter + 1))
done

if [ $counter -ge $timeout ]; then
    echo "Database connection timeout, continuing anyway..."
else
    echo "Database is up - executing migrations..."
    # Run migrations
    php artisan migrate --force || echo "Migration failed, continuing..."
fi

# Clear and cache config (skip if fails)
php artisan config:clear || true
php artisan config:cache || true

# Clear and cache routes (skip if fails)
php artisan route:clear || true
php artisan route:cache || true

# Clear and cache views (skip if fails)
php artisan view:clear || true
php artisan view:cache || true

# Optimize (skip if fails)
php artisan optimize || true

echo "Application is ready!"

exec "$@"

