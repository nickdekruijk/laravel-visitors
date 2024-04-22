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

];
