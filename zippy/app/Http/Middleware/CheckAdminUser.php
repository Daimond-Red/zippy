<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdminUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {

        if(! ( isset(\auth()->user()->role) && in_array(\auth()->user()->role, [ \App\User::SUPERADMIN ]) ) ) {
            Auth::logout();
            return redirect('login');
        }

        return $next($request);
    }
}
