<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Cek path nya, kalo /admin/* arahkan ke admin.login
        if ($request->is('admin') || $request->is('admin/*')) {
            return route('admin.login');
        }

        // Cek kalau /user/* arahkan ke user.login
        if ($request->is('user') || $request->is('user/*')) {
            return route('user.login');
        }

        // fallback, bisa ke user.login
        return route('user.login');
    }
}
