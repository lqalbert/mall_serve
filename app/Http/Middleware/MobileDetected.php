<?php

namespace App\Http\Middleware;

use Closure;
use Jenssegers\Agent\Agent as Agent;

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
        
        
        $agent=new Agent();
        logger("[mobiledetected]", [$agent->isMobile()]);
        if($agent->isMobile()){
            return redirect('http://ws.pulata.com.cn');
        }
        
        return $next($request);
        
    }
}
