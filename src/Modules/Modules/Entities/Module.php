<?php

namespace dvplex\Phantom\Modules\Modules\Entities;

use dvplex\Phantom\Traits\PhantomSearch;
use Illuminate\Database\Eloquent\Model;
use dvplex\Phantom\Modules\Routes\Entities\Route;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model {
    use SoftDeletes;
	use PhantomSearch;
	protected $fillable = ['module_name', 'module_description'];

	public function routes() {
		return $this->hasMany(Route::class);
	}

}

