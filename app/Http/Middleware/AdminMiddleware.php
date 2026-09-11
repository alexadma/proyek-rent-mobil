<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Check if the current guard is 'admin' and user is authenticated as admin
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // If not authenticated as admin, redirect to unauthorized or home page
        return redirect()->route('login'); // Ganti dengan rute yang sesuai
    }
}
