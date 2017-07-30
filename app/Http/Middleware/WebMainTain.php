<?php

namespace App\Http\Middleware;

use App\Models\SystemConfig;
use Closure;

class WebMainTain
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
        $sys = SystemConfig::findOrFail(1);
        if ($sys->is_maintain == 1)
            return redirect()->to(route('web.maintain'));
        return $next($request);
    }
}
