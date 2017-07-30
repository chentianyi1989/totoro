<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Route;
class MemberAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                $active_route = Route::currentRouteName();
                if (str_contains($active_route, 'member.'))
                {
                    return redirect()->guest('login');
                } elseif (str_contains($active_route, 'wap.') || str_contains($request->url(), 'm.')) {
                    return redirect()->guest('m/login');
                }
            }
        }
        return $next($request);
    }
}
