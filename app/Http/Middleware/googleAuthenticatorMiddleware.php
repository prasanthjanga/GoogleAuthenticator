<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Routing\Middleware;
use App\Http\Controllers\GoogleAuthenticatorController;

use Session;
use App\User;

class googleAuthenticatorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $check_count = null;

        if (!empty(Auth::id()) && session('google_auth_flag') != true) {
            return redirect('google_auth_first');
        }

        return $next($request);
    }
}
