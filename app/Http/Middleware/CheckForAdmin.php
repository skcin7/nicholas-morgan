<?php

namespace App\Http\Middleware;

use Closure;

class CheckForAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user() && $request->user()->isAdmin()) {
            return $next($request);
        }

        return redirect()->route('welcome')
            ->with('flash_message', [
                'message' => 'Only admins can access that page!',
                'type' => 'danger',
            ]);
    }
}
