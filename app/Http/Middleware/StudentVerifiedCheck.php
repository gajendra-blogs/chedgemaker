<?php

namespace Vanguard\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StudentVerifiedCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->email_verified_at)
        {
            return redirect('/');
        }
        return $next($request);
    }
}
