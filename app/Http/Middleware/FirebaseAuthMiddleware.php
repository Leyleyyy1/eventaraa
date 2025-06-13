<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class FirebaseAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('firebase_uid')) {
            return redirect()->route('user.login')->withErrors(['message' => 'Silakan login terlebih dahulu']);
        }

        return $next($request);
    }
}
