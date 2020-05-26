<?php

namespace dvplex\Phantom\Models;

use dvplex\Phantom\Traits\PhantomSearch;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {
    use PhantomSearch;
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    protected $guard_name = 'web';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function __construct(array $attributes = array()) {
        parent::__construct($attributes);
        $this->primaryKey = config('phantom.user_primary_key');
    }
}
