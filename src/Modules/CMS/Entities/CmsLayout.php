<?php

namespace Modules\CMS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CmsLayout extends Model
{
    use SoftDeletes;
    protected $fillable = [];
}
