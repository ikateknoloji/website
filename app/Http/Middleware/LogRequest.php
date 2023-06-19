<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ApiRequest;

class LogRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        ApiRequest::create([
            'ip_address' => $request->ip(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'parameters' => json_encode($request->all()),
        ]);

        return $next($request);
    }
}
