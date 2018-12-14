<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    protected $guarded = [];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
