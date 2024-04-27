<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user() && Auth::user()->is_admin == 1) {
            // User is authenticated and has admin flag set to 1
            return $next($request); // Allow the request to proceed
        }

        return redirect('/login'); // Redirect to home page if not admin

        // The line below is no longer needed with the return statement above
        // return redirect('/');
    }
}
