<?php

namespace dvplex\Phantom\Models;
use dvplex\Phantom\Traits\PhantomSearch;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends \Spatie\Permission\Models\Role {
	use PhantomSearch;
	protected $fillable = [
		'name',
	];

	function __construct() {
	}
}
