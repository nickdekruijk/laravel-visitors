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

### Include Javascript
Make sure the [`resources/js/laravel-visitors.js`](https://github.com/nickdekruijk/laravel-visitors/blob/master/resources/js/laravel-visitors.js) file is loaded in each pagevisit, preferably using something like webpack/vite or my [minify](https://github.com/nickdekruijk/minify) package.

Also make sure your add the ```@trackvisit``` blade directive inside your view before loading the above javascript, a good spot might be directly after the \<head> tag in your `app.blade.php` layout file.
```html
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        @trackvisit
        <meta charset="utf-8">
```
