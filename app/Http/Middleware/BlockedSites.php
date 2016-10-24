<?php

namespace App\Http\Middleware;

use Closure;

class BlockedSites
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
        $server_name = strtolower(trim($request->server("SERVER_NAME")));
        if($server_name == env("APP_HOST")){
            return $next($request);
        }else{
            //TODO : not the best way to do it
            return \App::make(\App\Http\Controllers\HomeController::class)->warningPage();
        }
    }
}
