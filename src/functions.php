<?php
function make_helper($function, $args = false) {
	$phantom = \dvplex\Phantom\Facades\Phantom::class;
	if (!function_exists($function)) {
		$ar = $lar = $v = '';
		if (is_array($args)) {
			foreach ($args as $a => $val) {
				$la = $a;
				if ($val && !is_numeric($a))
					if ($val != '[]' && $val != 'false' && !is_numeric($val))
						$v = ' = "' . $val . '"';
					else
						$v = ' = ' . $val;
				else {
					$v = '';
				}
				if (is_numeric($a))
					$la = $val;
				$ar != "" && $ar .= ',';
				$ar .= '$' . $la . $v;
				$lar != "" && $lar .= ',';
				$lar .= '$' . $la;
			}

		}
		eval("function {$function} ({$ar}) {
				return {$phantom}::{$function} ({$lar});
				}");
	}

}

make_helper('bark');

make_helper('get_fa_icons', ['select' => 'false']);

make_helper('phantom_slovom', ['int', 'currency' => 'false']);

make_helper('phantom_link', ['path' => '', 'args' => '[]']);

make_helper('phantom_view', ['id', 'view', 'data']);

make_helper('phantom_search', ['id', 'action']);

make_helper('phantom_module_path', ['module']);

make_helper('phantom_get_routes');

make_helper('phantom_route', ['loc']);
make_helper('phantom_prefs', ['user' => 'false']);
make_helper('phantom_event_fire', ['event', 'args' => 'false']);

if (!function_exists('phantom')) {
	function phantom() {
		return new \dvplex\Phantom\Classes\Phantom();
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
function get_string_between($string, $start, $end) {
	$string = ' ' . $string;
	$ini = strpos($string, $start);
	if ($ini == 0)
		return '';
	$ini += strlen($start);
	$len = strpos($string, $end, $ini) - $ini;

	return substr($string, $ini, $len);
}
