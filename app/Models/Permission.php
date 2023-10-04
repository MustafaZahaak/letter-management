<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiPermission;

class Permission extends SpatiPermission
{
    public $timestamps = false;
    protected $casts =['description'=>'json'];
    protected $fillable = ['name', 'guard_name','module_name', 'description'];
}
