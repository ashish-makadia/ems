<?php
namespace App\Http\Middleware;

use Closure;
use Session;
use App;
use Config;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //dd(Session::all());die();
        if (session()->has('locale')) {
            $locale = Session::get('locale');
        }else {
            $locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 27, 2);
            if ($locale != 'it' && $locale != 'en') {
                $locale = 'en';
            }
        }
        App::setLocale($locale);
        return $next($request);
    }
}