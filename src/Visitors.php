<?php

namespace NickDeKruijk\LaravelVisitors;

use Carbon\Carbon;
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

    /**
     * Retrieve the latest visitors from the Visitor model.
     *
     * @param int|Carbon $take The number of visitors to take, or a specific date/time to filter by.
     * @return \Illuminate\Database\Eloquent\Collection The latest visitors.
     */
    public function latestVisitors(int|Carbon $take = null): \Illuminate\Database\Eloquent\Collection
    {
        // Start query for visitors
        $visitors = Visitor::valid()->orderByDesc('id');

        // If an integer is provided, take the specified number of visitors
        if (is_int($take)) {
            $visitors->filtered()->take($take);
        }
        // Otherwise, filter by the provided date/time
        else {
            $visitors->where('created_at', '>=', $take);
        }

        // Return the latest visitors
        return $visitors->get();
    }


    /**
     * Updates the visitors screen information and sets the 'visitors.javascript' session variable to true to avoid running it again.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException if the visitor with the given ID is not found
     */
    public function xhr()
    {
        $visitor = Visitor::findOrFail(session('visitors.id'));
        $visitor->javascript = true;
        $visitor->screen_width = request()->w;
        $visitor->screen_height = request()->h;
        $visitor->screen_color_depth = request()->c;
        $visitor->screen_pixel_ratio = request()->p;
        $visitor->viewport_width = request()->vw;
        $visitor->viewport_height = request()->vh;
        $visitor->save();
        session(['visitors.javascript' => true]);
    }

    public function pixel()
    {
        $visitor = Visitor::findOrFail(session('visitors.id'));
        $visitor->pixel = true;
        $visitor->save();
        $raw_image_string = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=');
        session(['visitors.pixel' => true]);
        return response($raw_image_string)->header('Content-Type', 'image/png');
    }
}
