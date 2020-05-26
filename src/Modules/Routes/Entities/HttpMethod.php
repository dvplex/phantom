<?php

namespace dvplex\Phantom\Modules\Routes\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HttpMethod extends Model
{
    use SoftDeletes;
    protected $fillable = [];
}
