php artisan migrate:refresh
php artisan migrate --package cartalyst/sentry
php artisan migrate --bench bluebanner/core
php artisan db:seed --class="Bluebanner\Core\DatabaseSeeder"
