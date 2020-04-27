<?php

namespace dvplex\Phantom\Facades;

use Illuminate\Support\Facades\Facade;

class Phantom extends Facade {
	protected static function getFacadeAccessor() {
		return 'Phantom';
	}
}
