<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Http\Request;

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
        // Jika request tidak mengharapkan JSON
        if (! $request->expectsJson()) {
            // Jika user mencoba mengakses admin panel
            if ($request->is('panel') || $request->is('panel/*')) {
                return route('loginadmin'); // redirect ke login admin
            }

            // Selain admin panel → redirect ke login user biasa
            return route('login'); 
        }
    }
}
