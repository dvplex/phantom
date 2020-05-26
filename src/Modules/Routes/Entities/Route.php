<?php

namespace dvplex\Phantom\Modules\Routes\Entities;

use dvplex\Phantom\Traits\PhantomSearch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use dvplex\Phantom\Modules\Modules\Entities\Module;

class Route extends Model {
    use SoftDeletes;
	use hasRoles;
	use PhantomSearch;
	protected $fillable = ['request', 'method', 'route'];
	protected $guard_name = 'web';

	public function middlewares() {
		return $this->hasMany(Middleware::class);
	}

	public function http_methods() {
		return $this->hasMany(httpMethod::class);
	}
	public function module() {
		return $this->belongsTo(Module::class);
	}

}
