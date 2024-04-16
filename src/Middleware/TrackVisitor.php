<?php

namespace NickDeKruijk\LaravelVisitors\Middleware;

use Closure;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use NickDeKruijk\LaravelVisitors\Models\Visitor;
use Symfony\Component\HttpFoundation\Response;
use Torann\GeoIP\Facades\GeoIP;

class TrackVisitor
{
    /**
     * Handle an incoming request and determine if the user has a required role for the app or requested organization and abort if not authorized.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if visitor is already tracked by looking for visits_uuid in session
        if (!session('visits_uuid')) {

            // New visitor, create a new UUID
            $new_uuid = uuid_create();

            // Anonymize IP address
            $ip = inet_ntop(inet_pton($request->ip()) & inet_pton("255.255.255.0"));

            // Get GeoIP data
            $geo = GeoIP::getLocation($ip);

            // Handle user agent
            $agent = new Agent();

            // Store visitor in database
            Visitor::create([
                'uuid' => $new_uuid,
                'ip' => $ip,
                'user_agent' => $request->userAgent(),
                'accept_language' => $request->header('Accept-Language'),
                // GeoIP data
                'country_iso' => $geo['iso_code'],
                'country' => $geo['country'],
                'city' => $geo['city'],
                'state' => $geo['state'],
                'state_name' => $geo['state_name'],
                'postal_code' => $geo['postal_code'],
                'lat' => $geo['lat'],
                'lon' => $geo['lon'],
                'timezone' => $geo['timezone'],
                'continent' => $geo['continent'],
                'currency' => $geo['currency'],
                // User Agent parsing
                'languages' => implode(',', $agent->languages()),
                'device' => $agent->device(),
                'platform' => $agent->platform(),
                'platform_version' => $agent->version($agent->platform()),
                'browser' => $agent->browser(),
                'browser_version' => $agent->version($agent->browser()),
                'desktop' => $agent->isDesktop(),
                'phone' => $agent->isPhone(),
                'robot' => $agent->robot() ?: null,
            ]);

            // Store UUID in session
            session(['visits_uuid' =>  $new_uuid]);
        }

        return $next($request);
    }
}
