<?php

namespace Joodek\Prohibition\Middleware;

use Closure;
use Illuminate\Http\Request;
use Joodek\Prohibition\Facades\Prohibition;

class ProhibitionMiddleware
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
        Prohibition::authorize($request);

        return $next($request);
    }
}
