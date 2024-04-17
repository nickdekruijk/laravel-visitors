<?php

namespace NickDeKruijk\LaravelVisitors;

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
    public static function anonymizeIp(string $ip): string
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
     * Retrieves the yearly visitors from the Visitor model.
     *
     * This function groups the visitors by year, using different methods for SQLite and MySQL.
     *
     * @return \Illuminate\Database\Eloquent\Collection The monthly visitors.
     */
    public static function yearlyVisitors(): Collection
    {
        // Group by year, different methods for sqlite and mysql
        if (self::databaseDriver() == 'sqlite') {
            return Visitor::valid()
                ->selectRaw('created_at, count(id) as visitors, strftime("%Y", created_at) as year')
                ->groupBy('year')
                ->get();
        } else {
            return Visitor::valid()
                ->selectRaw('min(created_at) as created_at, count(id) as visitors, year(created_at) as year')
                ->groupBy('year')
                ->get();
        }
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
                ->selectRaw('min(created_at) as created_at, count(id) as visitors, year(created_at) as year, month(created_at) as month')
                ->groupBy('year', 'month')
                ->get();
        }
    }
    /**
     * Retrieves the monthly visitors from the Visitor model.
     *
     * This function groups the visitors by month and year, using different methods for SQLite and MySQL.
     *
     * @return \Illuminate\Database\Eloquent\Collection The monthly visitors.
     */
    public static function dailyVisitors(): Collection
    {
        // Group by month and year, different methods for sqlite and mysql
        if (self::databaseDriver() == 'sqlite') {
            return Visitor::valid()
                ->selectRaw('created_at, count(id) as visitors, strftime("%Y", created_at) as year, strftime("%m", created_at) as month, strftime("%d", created_at) as day')
                ->groupBy('year', 'month', 'day')
                ->get();
        } else {
            return Visitor::valid()
                ->selectRaw('min(created_at) as created_at, count(id) as visitors, year(created_at) as year, month(created_at) as month, day(created_at) as day')
                ->groupBy('year', 'month', 'day')
                ->get();
        }
    }

    public function latestVisitors(int $take = null)
    {
        return Visitor::valid()->take($take)->get();
    }
}
