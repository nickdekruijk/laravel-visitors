<?php

return [

    /*
    |--------------------------------------------------------------------------
    | db_connection
    |--------------------------------------------------------------------------
    |
    | The database connection that should be used to store visitor data.
    | By default, the package will use the default database connection.
    |
    */
    'db_connection' => env('VISITORS_DB_CONNECTION', config('database.default')),

    /*
    |--------------------------------------------------------------------------
    | migrations
    |--------------------------------------------------------------------------
    |
    | Enable or disable the migrations included in the package.
    |
    */
    'migrations' => true,

    /*
    |--------------------------------------------------------------------------
    | table_prefix
    |--------------------------------------------------------------------------
    |
    | The package includes migrations to create tables. The created table names
    | will use this prefix.
    |
    */
    'table_prefix' => 'visitors_',

    /*
    |--------------------------------------------------------------------------
    | route_prefix
    |--------------------------------------------------------------------------
    |
    | To track visitors we need to be able to do some XHR requests. Each 
    | page will do a POST to this route to track visitors. The default route
    | will be fine for most sites but you can change it here in case it
    | conflicts with another route or when some adblocker blocks it.
    |
    */
    'route_prefix' => env('VISITORS_ROUTE_PREFIX', '/visitors/api'),

];
