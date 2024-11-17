<?php

namespace App\Http\Middleware;

use App\traits\apiTraits;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Runner\Baseline\Issue;
use Symfony\Component\HttpFoundation\Response;

class CheckUserLogin
{
    // token = 36de9a5808765027a26c1aaae470259b1fe06642a3a4b9e407ad073b77e6cd5b
    use apiTraits;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next ): Response
    {
        if(Auth::guard('sanctum')->check()){
           return $this->ReturnErrorMessage('Already authenticated','407');
        }
        return $next($request);
    }
}
