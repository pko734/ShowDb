<?php

namespace ShowDb\Http\Middleware;

use Auth;
use Closure;

class UsernameExists
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
        if (Auth::check() && Auth::user()->username != '') {
            return $next($request);
        }

        return redirect('/settings');
    }
}
