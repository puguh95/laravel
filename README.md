# laravel

composer create-project laravel/laravel project-name
cd project-name
composer require jeroennoten/laravel-adminlte
php artisan adminlte:install
composer require laravel/ui
php artisan ui bootstrap --auth
php artisan adminlte:install --only=auth_views
add to package json "vite": "^3.0.4"

php artisan make:model Order -m
