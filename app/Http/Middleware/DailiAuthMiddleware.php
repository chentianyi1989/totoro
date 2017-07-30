<?php

namespace App\Http\Middleware;

use Closure;

class DailiAuthMiddleware
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
        if (!$request->session()->has('daili_login_info')) {
            return redirect()->to(route('daili.login'));
        }

        return $next($request);
    }
}
