<?php

namespace dvplex\Phantom\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Factory as Auth;

class PhantomLocaleMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */

	public function __construct(Auth $auth) {
	}

	public function handle(Request $request, Closure $next) {
		if ($request->route('lang')) {
			if (in_array($request->route('lang'), config('app.locales'))) {
				$lang = $request->route('lang');
				\Session::put('locale', $lang);;
				app()->setLocale($lang);
				Carbon::setLocale($lang);
			}
			else {
				if (session('locale'))
					$lang = session('locale');
				else
					$lang = config('app.locales.0');
				$request->route()->setParameter('lang', $lang);
				if (preg_match('/^\/([a-z]){2}\//', $request->getRequestUri()))
					return redirect($lang . '/' . preg_replace('/^\/([a-z]){2}\//', '', $request->getRequestUri()));
				else
					return redirect($lang . $request->getRequestUri());
			}
		}
		else {
			if (session('locale'))
				$lang = session('locale');
			else {
				$lang = preg_split('/-|,/', $request->server('HTTP_ACCEPT_LANGUAGE'));
				$lang = $lang[0];
			}
			if (!in_array($lang, config('app.locales')))
				$lang = config('app.locales.0');
			\Session::put('locale', $lang);;
			app()->setLocale($lang);
			Carbon::setLocale($lang);
			$request->route()->setParameter('lang', $lang);
			if ($request->getRequestUri() == '/')
				return redirect($lang . '/' . $request->getRequestUri());
		}


		return $next($request);
	}
}
