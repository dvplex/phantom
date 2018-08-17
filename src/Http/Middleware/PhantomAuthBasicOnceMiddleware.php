<?php

namespace dvplex\Phantom\Http\Middleware;

use http\Exception;
use Illuminate\Http\Request;

class PhantomAuthBasicOnceMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle(Request $request, \Closure $next) {
		$response = $next($request);
		$exception = $response;
		return \Illuminate\Support\Facades\Auth::onceBasic('username') ?: $next($request);
	}
}