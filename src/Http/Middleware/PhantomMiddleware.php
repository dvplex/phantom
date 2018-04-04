<?php

namespace dvplex\Phantom\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PhantomMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
	    \Session::put('phantom.modules.current',$request->route()->getName());

	    \Session::put('phantom.modules.main','admin');
	    $lang=explode('-',$request->server('HTTP_ACCEPT_LANGUAGE'));
	    if (in_array($lang[0],config('app.locales'))) {
		    \App::setLocale($lang[0]);
		    Carbon::setLocale($lang[0]);
		    \Session::forget('locale');;
	    }
	    else if (\Session::has('locale')) {
		    \App::setLocale(\Session::get('locale'));
		    Carbon::setLocale(\Session::get('locale'));
		    \Session::put('locale', $request->lang);;
	    }
	    if ($request->lang) {
		    \Session::put('locale', $request->lang);;
		    \App::setLocale($request->lang);
	    }
        return $next($request);
    }
}
