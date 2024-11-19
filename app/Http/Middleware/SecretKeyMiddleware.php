<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecretKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $secretKey = $request->query("api_key",0);
        
        if ($secretKey !== env('API_SECRET_KEY')) {
            return response()->json(['message' => 'Invalid API Secret Key'], 401);
        }

        return $next($request);
    }
}
