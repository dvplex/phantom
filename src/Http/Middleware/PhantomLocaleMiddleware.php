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
	protected $auth;

	public function __construct(Auth $auth) {
		$this->auth = $auth;
	}

	public function handle(Request $request, Closure $next) {
		if ($request->lang) {
			if (in_array($request->lang, config('app.locales'))) {
				$lang = $request->lang;
				\Session::put('locale', $lang);;
				\App::setLocale($lang);
				Carbon::setLocale($lang);
			}
			else
				return redirect(config('app.locales.0') . '/' . preg_replace('/^\/[a-z]{1,}\//', '', request()->getRequestUri()));
		}


		return $next($request);
	}
}
