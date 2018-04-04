<?php
if (!function_exists('bark')) {
	function bark() {
		$phantom = app('phantom');

		return $phantom::bark();

	}

}

if (!function_exists('phantom')) {
	function phantom() {
		$phantom = app('phantom');

		return new \dvplex\Phantom\Classes\Phantom();

	}

}

if (!function_exists('route_translated')) {

	function phantom_route($loc) {
		$phantom = app('phantom');

		return $phantom::phantom_route($loc);

	}

}

if (!function_exists('mb_ucfirst')) {
	function mb_ucfirst($string, $encoding = 'UTF-8') {
		$strlen = mb_strlen($string, $encoding);
		$firstChar = mb_substr($string, 0, 1, $encoding);
		$then = mb_substr($string, 1, $strlen - 1, $encoding);

		return mb_strtoupper($firstChar, $encoding) . $then;
	}

}

