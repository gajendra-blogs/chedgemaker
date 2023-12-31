<?php

namespace Vanguard\Http\Middleware;

use Vanguard\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if(auth()->user()->role_id != 3)
                {
                    return request()->has('to')
                    ? redirect(request()->get('to'))
                    : redirect(RouteServiceProvider::HOME);
                }
                else
                {
                    return  redirect('/');
                }
            }
        }

        return $next($request);
    }
}
