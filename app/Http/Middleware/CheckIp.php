<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AccessIps;

class CheckIp
{
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,...$white)
    {
        
        $ip = AccessIps::select('type',\DB::raw('group_concat(ip) as ips'))->wherestatus('Active')->wheretype('White')->groupBy('type')->first();
        $ip1 = AccessIps::select('type',\DB::raw('group_concat(ip) as ips'))->wherestatus('Active')->wheretype('Black')->groupBy('type')->first();
        $white = explode(",",$ip['ips'] ?? "");
        $black = explode(",",$ip1['ips'] ?? "");
        if(!in_array($request->ip(),$black) && in_array($request->ip(),$white))
        {
            return $next($request);
        }
        abort(403);
    }
}
