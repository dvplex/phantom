<?php

namespace dvplex\Phantom\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Factory as Auth;

class PhantomMiddleware {
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

		$this->auth->authenticate();

		\Session::put('phantom.modules.current', $request->route()->getName());

		\Session::put('phantom.modules.main', 'admin');
		$lang = explode('-', $request->server('HTTP_ACCEPT_LANGUAGE'));
		if (in_array($lang[0], config('app.locales'))) {
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
			if (in_array($request->lang, config('app.locales'))) {
				$lang = $request->lang;
				\Session::put('locale', $lang);;
				\App::setLocale($lang);
			}
			else
				return redirect('/' . config('app.locales')[0] . '/' . \Session::get('phantom.modules.main'));
		}

		return $next($request);
	}
}
