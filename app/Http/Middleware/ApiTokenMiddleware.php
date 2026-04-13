<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // If X-API-Token header exists but no Authorization header
        if ($request->header('X-API-Token') && !$request->header('Authorization')) {
            $request->headers->set('Authorization', 'Bearer ' . $request->header('X-API-Token'));
        }

        return $next($request);
    }
}
