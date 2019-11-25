<?php

namespace dvplex\Phantom\Modules\Modules\Entities;

use dvplex\Phantom\Traits\PhantomSearch;
use Illuminate\Database\Eloquent\Model;
use dvplex\Phantom\Modules\Routes\Entities\Route;

class Module extends Model {
	use PhantomSearch;
	protected $fillable = ['module_name', 'module_description'];

	public function routes() {
		return $this->hasMany(Route::class);
	}

}

