<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        //return $request->expectsJson() ? null : route('login');
        if (!$request->expectsJson()) {
            if ($request->routeIs('admin.*') && !Auth::guard('admin')->check()) {
                session()->flash('fail', 'Kamu harus Login terlebih dahulu');
                return route('login');
            } elseif ($request->routeIs('customer.*') && !Auth::guard('web')->check()) {
                session()->flash('fail', 'Kamu harus Login terlebih dahulu');
                return route('login');
            } 
        }
        return null;
    }
}