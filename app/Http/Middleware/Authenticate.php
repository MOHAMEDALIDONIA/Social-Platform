<?php

namespace App\Http\Middleware;

use App\traits\apiTraits;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    use apiTraits;
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    { 
        return $request->expectsJson() ? null : route('login');
    }
}
