<?php

namespace App\Http\Middleware;

use App\Models\Guest;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to identify guest users without them needing to be registered.
 */
class IdentifyGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $token = $request->cookie('poelaris_guest');
        $guest = $token ? Guest::where('token', $token)->first() : null;

        if (! $guest) {
            $token = (string) Str::uuid();
            $guest = Guest::create(['token' => $token, 'last_seen_at' => now()]);
        } else {
            $guest->update(['last_seen_at' => now()]);
        }

        // Make the guest available throughout the request
        $request->attributes->set('_guest', $guest);

        $response = $next($request);

        // Refresh the cookie with 1 year expiry that resets on each request.
        $response->headers->setCookie(
            cookie('poelaris_guest', $token, 60 * 24 * 365, '/', null, true, true)
        );

        return $response;
    }
}
