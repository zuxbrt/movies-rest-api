<?php

namespace App\Http\Middleware;

use App\Services\JWTService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class APIAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorization_header = $request->header('Authorization');

        if(!$authorization_header){
            return response()->json('Unauthorized.', 401);
        } else {
            
            // only passes - Bearer (string)
            if (! preg_match('/Bearer\s(\S+)/', $authorization_header, $matches)) {
                return response()->json('Bad request.', 400);
            }

            $token = $matches[1];
            $token_valid = JWTService::validateToken($token);
            if(!$token_valid) return response()->json('Unauthorized.', 401);
        }
       
        return $next($request);
    }
}
