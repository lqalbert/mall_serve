<?php

namespace App\Http\Middleware;

use Closure;

class MobileDetected
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
        //return $next($request);
        
        //         $response = 
        //         $response->header('Access-Control-Allow-Origin', '*');
        redirect('http://ws.pulata.com.cn');
        return $next($request);
        
    }
}
