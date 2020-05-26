<?php
namespace dvplex\Phantom\Classes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PhantomValidator {
	public function __construct() {

	}

	public static function boot() {
		Validator::extend('without_spaces', function ($attr, $value) {
			return preg_match('/^\S*$/u', $value);
		});

		Validator::extend('validate_bot', function ($attr, $value) {
			$tlgrm = json_decode(@file_get_contents("https://api.telegram.org/bot{$value}/getMe"));

			return is_object($tlgrm);
		});
		Validator::extend('unique_multiple', function ($attribute, $value, $parameters, $validator) {
			$table = $parameters[0];
			unset($parameters[0]);
			$count = DB::table($table);
			$count->where($attribute,$value);
			foreach ($parameters as $param) {
				$p = explode('::',$param);
				if ($p[1]== 'NULL')
    				$count->whereNull($p[0]);
				else
                    $count->where($p[0],$p[1]);
			}
			return $count->count() === 0;
		});

	}
}
