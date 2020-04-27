<?php

namespace dvplex\Phantom\Modules\Routes\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Middleware extends Model
{
    use SoftDeletes;
    protected $fillable = [];

	public function route() {
		return $this->belongsTo(Route::class);
	}
}


