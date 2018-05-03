<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Request;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(Request::is('administrator*') && Auth::guard('administrator')->check()) {
            return redirect()->route('administrator.home');
        }
        if(Request::is('siteadmin*') && Auth::guard('admin')->check()) {
            return redirect()->route('admin.home');
        }
        if(Request::is('merchant*') && Auth::guard('merchant')->check()) {
            return redirect()->route('merchant.home');
        }

        return $next($request);
    }
}
