<?php

namespace dvplex\Phantom\Modules\Routes\Entities;

use Illuminate\Database\Eloquent\Model;

class Middleware extends Model
{
    protected $fillable = [];

	public function route() {
		return $this->belongsTo(Route::class);
	}
}


