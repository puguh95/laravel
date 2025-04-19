# laravel

composer create-project laravel/laravel project-name
cd prject-name
composer require jeroennoten/laravel-adminlte
php artisan adminlte:install
composer require laravel/ui
php artisan ui bootstrap --auth
php artisan adminlte:install --only=auth_views
