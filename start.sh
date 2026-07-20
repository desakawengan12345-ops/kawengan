#!/bin/sh

echo "=== Running migrations ==="
php /app/artisan migrate --force

echo "=== Seeding ==="
php /app/artisan db:seed --class=SiteSettingSeeder --force || echo "Seeder skipped or already run"

echo "=== Starting server on port 8000 ==="
exec php /app/artisan serve --host=0.0.0.0 --port=8000