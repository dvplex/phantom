<?php

namespace dvplex\Phantom\Facades;

use Illuminate\Support\Facades\Facade;

class PhantomFacade extends Facade {
	protected static function getFacadeAccessor() {
		return 'phantom';
	}
}