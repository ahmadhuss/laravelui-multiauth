<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {

            // Check if the user is authenticated with the `admin` guard
            if (Auth::guard('admin')->check()) {
                return redirect()->route('dashboard');
            }

            else if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }
        // If there is not any guard present in the request. please open the route.
        // if (Auth::guard($guard)->check()) returns true then it means the user is
        // authenticated with the guard, then $next($request) will not work.
        return $next($request);
    }
}
