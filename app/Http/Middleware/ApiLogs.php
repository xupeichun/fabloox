<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;

class ApiLogs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        return $next($request);
    }
}
