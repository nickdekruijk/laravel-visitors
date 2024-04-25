<?php

namespace NickDeKruijk\LaravelVisitors\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Jenssegers\Agent\Agent;
use NickDeKruijk\LaravelVisitors\Models\Visitor;

class VisitorController extends Controller
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
            return Visitor::filtered()
                ->selectRaw('created_at, count(id) as visitors, strftime("%Y", created_at) as year')
                ->groupBy('year')
                ->get();
        } else {
            return Visitor::filtered()
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
            return Visitor::filtered()
                ->selectRaw('created_at, count(id) as visitors, strftime("%Y", created_at) as year, strftime("%m", created_at) as month')
                ->groupBy('year', 'month')
                ->get();
        } else {
            return Visitor::filtered()
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
            return Visitor::filtered()
                ->selectRaw('created_at, count(id) as visitors, strftime("%Y", created_at) as year, strftime("%m", created_at) as month, strftime("%d", created_at) as day')
                ->groupBy('year', 'month', 'day')
                ->get();
        } else {
            return Visitor::filtered()
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
    public static function latestVisitors(int|Carbon $take = null): \Illuminate\Database\Eloquent\Collection
    {
        // Start query for visitors
        $visitors = Visitor::filtered()->orderByDesc('id');

        // If an integer is provided, take the specified number of visitors
        if (is_int($take)) {
            $visitors->take($take);
        }
        // Otherwise, filter by the provided date/time
        else {
            $visitors->where('created_at', '>=', $take);
        }

        // Return the latest visitors
        return $visitors->get();
    }

    /**
     * Track visitor if not already tracked.
     */
    public function xhr()
    {
        // Check if visitor is already tracked by looking for visitors_id in session
        if (!session('visitors.id')) {
            // New visitior has not been tracked

            // Parse User Agent
            $agent = new Agent();

            // Check if visitor is a robot, store visitor in database if not
            if (!$agent->isRobot()) {
                // Store visitor in database
                $visitor = Visitor::create([
                    'ip' => self::anonymizeIp(request()->ip()),
                    'user_agent' => request()->userAgent(),
                    'accept_language' => request()->header('Accept-Language'),
                    'languages' => implode(',', $agent->languages()),
                    'device' => $agent->device(),
                    'platform' => $agent->platform(),
                    'platform_version' => $agent->version($agent->platform()),
                    'browser' => $agent->browser(),
                    'browser_version' => $agent->version($agent->browser()),
                    'desktop' => $agent->isDesktop(),
                    'phone' => $agent->isPhone(),
                    'tablet' => $agent->isTablet(),
                    'javascript' => true,
                    'screen_width' => request()->w,
                    'screen_height' => request()->h,
                    'screen_color_depth' => request()->c,
                    'screen_pixel_ratio' => request()->p,
                    'viewport_width' => request()->vw,
                    'viewport_height' => request()->vh,
                    'touch' => request()->touch,
                ]);

                // Store visitor id in session_abort
                session(['visitors' => ['id' => $visitor->id]]);
            }
        }
        return 'Ok';
    }
}
