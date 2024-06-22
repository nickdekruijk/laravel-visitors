# Laravel Visitors

A simple, privacy friendly visitor tracking for Laravel applications.

## Installation

Begin by installing this package with composer.

`composer require nickdekruijk/laravel-visitors`

### Configuration
Publish the config file if the defaults doesn't suite your needs:

```php artisan vendor:publish --provider="NickDeKruijk\LaravelVisitors\ServiceProvider"```

### Separate databases
You might want to separate the visitors database from the main application database for performance or to avoid conflicts. Add a new connection in your `config/database.php` connections array for example:

```php
        'visitors' => [
            'driver' => 'sqlite',
            'database' => database_path('visitors.sqlite'),
        ],
```
And change db_connection configuration in the `config/visitors.php` file or add VISITORS_DB_CONNECTION in your .env file.

### Include tracker
Add ```@include('laravel-visitors::track')``` inside your view, a good spot might be directly after the \<head> tag in your `app.blade.php` layout file, for example:
```html
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        @include('laravel-visitors::track')
        <meta charset="utf-8">
```
