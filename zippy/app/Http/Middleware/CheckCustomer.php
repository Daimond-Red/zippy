<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckCustomer
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
        
        if(! ( isset(\auth()->user()->role) && in_array(\auth()->user()->role, [ \App\User::CUSTOMER ]) ) ) {
            Auth::logout();
            return redirect('signin');
        }

        return $next($request);
    }
}
