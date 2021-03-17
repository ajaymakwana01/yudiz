<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        //If route file is has admin then redirect to admin login
        if (! $request->expectsJson()) {
            if (Route::is('admin.*')) {
                return route('admin.login');
            }
            return route('login');
        }
    }
}
