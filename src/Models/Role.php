<?php

namespace dvplex\Phantom\Models;
class Role extends \Spatie\Permission\Models\Role {
	use \App\Traits\PhantomSearch;
	protected $fillable = [
		'name',
	];

	function __construct() {
	}
}