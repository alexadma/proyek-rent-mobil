<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
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
