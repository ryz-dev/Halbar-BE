<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
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
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response([
                'diagnostic' => [
                  'status'=>'Token is Invalid',
                  'code'=>401
                  ]
                ], 401);
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response([
                'diagnostic' => [
                  'status'=>'Token is Expired',
                  'code'=>401
                  ]
                ], 401);
            } else {
                return response([
                'diagnostic' => [
                  'status'=>'Unauthorized Error',
                  'code'=>401
                  ]
                ], 401);
            }
        }
        return $next($request);
    }
}
