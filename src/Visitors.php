<?php

namespace NickDeKruijk\LaravelVisitors;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Collection;
use NickDeKruijk\LaravelVisitors\Models\Visitor;

class Visitors
{
    /**
     * Anonymizes the given IP address by applying a bitmask to it.
     *
     * @param string $ip The IP address to be anonymized.
     * @return string The anonymized IP address.
     */
    public static function anonymize_ip(string $ip): string
    {
        return inet_ntop(inet_pton($ip) & inet_pton("255.255.255.0"));
    }

    public static function firstVisitor()
    {
        return Visitor::orderBy('created_at', 'desc')->first();
    }

    /**
     * Retrieves the driver of the current database connection.
     *
     * @return string The driver of the current database connection.
     */
    public static function databaseDriver(): string
    {
        return config('database.connections.' . config('visitors.db_connection') . '.driver');
    }

    /**
     * Retrieves the monthly visitors from the Visitor model.
     *
     * This function groups the visitors by month and year, using different methods for SQLite and MySQL.
     *
     * @return \Illuminate\Database\Eloquent\Collection The monthly visitors.
     */
    public static function monthlyVisitors(): Collection
    {
        // Group by month and year, different methods for sqlite and mysql
        if (self::databaseDriver() == 'sqlite') {
            return Visitor::valid()
                ->selectRaw('created_at, count(id) as visitors, strftime("%Y", created_at) as year, strftime("%m", created_at) as month')
                ->groupBy('year', 'month')
                ->get();
        } else {
            return Visitor::valid()
                ->selectRaw('min(created_at) as created_at, count(id) as visitors, year(created_at) as year, monthname(created_at) as month')
                ->groupBy('year', 'month')
                ->get();
        }
    }
}
