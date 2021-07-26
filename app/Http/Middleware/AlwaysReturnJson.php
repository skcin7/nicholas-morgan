<?php

namespace App\Http\Middleware;

use Closure;

class AlwaysReturnJson
{
    /**
     * Handle an incoming request.
     * https://medium.com/@DarkGhostHunter/laravel-convert-to-json-all-responses-automatically-c4a72b2fd3ac
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');
        return $next($request);
    }
}
