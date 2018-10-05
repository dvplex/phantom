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

	public function __construct(Auth $auth) {
	}

	public function handle(Request $request, Closure $next) {
		config(['phantom.modules.current' => preg_replace(['/phantom\.modules\./','/\@\S+/'], '', $request->route()->getName())]);

		return $next($request);
	}
}
