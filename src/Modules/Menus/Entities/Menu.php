<?php

namespace dvplex\Phantom\Modules\Menus\Entities;

use dvplex\Phantom\Traits\PhantomSearch;
use Illuminate\Database\Eloquent\Model;
use dvplex\Phantom\Modules\MenuNodes\Entities\MenuNode;
use Spatie\Permission\Traits\HasRoles;

class Menu extends Model {

	use HasRoles;
	use PhantomSearch;
	protected $fillable = ['name', 'description'];
	protected $guard_name = 'web';

	public function nodes() {
		return $this->hasMany(MenuNode::class);
	}
}
