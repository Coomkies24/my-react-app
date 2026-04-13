<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is logged in AND is an admin using our helper method
        if (auth()->check() && auth()->user()->isAdmin()) {
            return $next($request); // Allow them to proceed
        }

        // If not an admin, deny access with a 403 Forbidden error
        abort(403, 'Unauthorized action. Admins only.');
    }
}