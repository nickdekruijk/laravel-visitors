<?php

use NickDeKruijk\Leap\Livewire\Dashboard;
use NickDeKruijk\Leap\Livewire\Profile;
use NickDeKruijk\Leap\Navigation\Divider;
use NickDeKruijk\Leap\Navigation\Logout;
use NickDeKruijk\Leap\Navigation\Organizations;

return [

    /*
    |--------------------------------------------------------------------------
    | db_connection
    |--------------------------------------------------------------------------
    |
    | The package inclused migrations to create tables. The created tables name
    | will use this prefix, e.g. 'leap_' for leap_roles and leap_role_user.
    |
    */
    'db_connection' => env('VISITORS_DB_CONNECTION', config('database.default')),

    /*
    |--------------------------------------------------------------------------
    | migrations
    |--------------------------------------------------------------------------
    |
    | The package includes several migrations to create tables.
    | This setting enables/disables these migrations.
    |
    */
    'migrations' => true,

    /*
    |--------------------------------------------------------------------------
    | table_prefix
    |--------------------------------------------------------------------------
    |
    | The package inclused migrations to create tables. The created tables name
    | will use this prefix, e.g. 'leap_' for leap_roles and leap_role_user.
    |
    */
    'table_prefix' => 'visitors_',

];
