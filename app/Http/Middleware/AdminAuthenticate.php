<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AdminAuthenticate extends Middleware
{
    /**
     * Get the path the admin should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // exprectsJson(): Determine if the current request probably expects a JSON response.
        // It will return true or false.
        if (! $request->expectsJson()) {
            return route('admin.login');
        }
    }
}
