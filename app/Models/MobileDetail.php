<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileDetail extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function pools()
    {
        return $this->hasMany(MobilePool::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'mobile', 'mobile');
    }
}
