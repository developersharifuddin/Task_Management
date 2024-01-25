<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Check if the user is authenticated and has the role of "admin"
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }
        // Redirect to home or any other route if the user is not an admin
        return redirect()->route('home')->with('error', 'You do not have permission to access this resource.');





        // if (auth()->check() && (!auth()->user()->role === 'admin')) {
        //     abort(403, 'Unauthorized action && You do not have permission to access this page.');
        // }
        // return $next($request);
    }
}
