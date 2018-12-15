<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileImport extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function pools()
    {
        return $this->hasMany(MobilePool::class);
    }
}
