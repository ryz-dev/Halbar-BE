<?php

namespace App\Http\Middleware;

use DB, Redirect, Closure;

class Maintenance
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
      $dataSettings = DB::table('setting')->first();
  		if ($dataSettings->maintenance == '1') {
        return Redirect::to('/503');
  		} else {
  			$this->setting = $dataSettings;
  		}
      return $next($request);
    }
}
