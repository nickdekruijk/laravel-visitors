<?php

namespace NickDeKruijk\LaravelVisitors\Middleware;

use Closure;
use Illuminate\Http\Request;
use NickDeKruijk\LaravelVisitors\Models\Visitor;
use NickDeKruijk\LaravelVisitors\Visitors;
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

            // Store visitor in database
            $visitor = Visitor::create([
                'ip' => Visitors::anonymize_ip($request->ip()),
                'user_agent' => $request->userAgent(),
                'accept_language' => $request->header('Accept-Language'),
            ]);

            // Store visitor id in session
            session(['visitors_id' =>  $visitor->id]);
        }

        return $next($request);
    }
}
