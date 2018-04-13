<?php

namespace dvplex\Phantom\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Factory as Auth;

class PhantomApiMiddleware {
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



		return $next($request);
	}
}
