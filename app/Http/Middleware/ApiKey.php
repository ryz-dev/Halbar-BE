<?php

namespace App\Http\Middleware;

use DB;
use Redirect;
use Closure;

class ApiKey
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
        $token = $request->header('dtcmskey');
        $dataSettings = DB::table('setting')->first();
        if ($dataSettings->key_token !== $token) {
            return response([
            'diagnostic' => [
              'status'=>'Unauthorized Error',
              'code'=>401
              ]
            ], 401);
        }
        return $next($request);
    }
}
