<?php

namespace Cata\Prohibition\Middleware;

use Cata\Prohibition\Facades\Prohibition;
use Closure;
use Illuminate\Http\Request;

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
