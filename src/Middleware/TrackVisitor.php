<?php

namespace NickDeKruijk\LaravelVisitors\Middleware;

use Closure;
use Illuminate\Http\Request;
use NickDeKruijk\LaravelVisitors\Models\Visitor;
use Symfony\Component\HttpFoundation\Response;

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
        // Check if visitor is already tracked by looking for visitors_id in session
        if (!session('visitors_id')) {
            // New visitior has not been tracked

            // Anonymize IP address
            $ip = inet_ntop(inet_pton($request->ip()) & inet_pton("255.255.255.0"));

            // Store visitor in database
            $visitor = Visitor::create([
                'ip' => $ip,
                'user_agent' => $request->userAgent(),
                'accept_language' => $request->header('Accept-Language'),
            ]);

            // Store visitor id in session
            session(['visitors_id' =>  $visitor->id]);
        }

        return $next($request);
    }
}
