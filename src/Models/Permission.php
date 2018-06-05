<?php

namespace dvplex\Phantom\Models;
use App\Traits\PhantomSearch;

class Permission extends \Spatie\Permission\Models\Permission {
	use PhantomSearch;
	function __construct() {
	}
}