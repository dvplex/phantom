<?php

namespace dvplex\Phantom\Models;
use dvplex\Phantom\Traits\PhantomSearch;

class Permission extends \Spatie\Permission\Models\Permission {
	use PhantomSearch;
	function __construct() {
	}
}
