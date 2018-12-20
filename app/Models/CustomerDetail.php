<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerDetail extends BaseModel
{
    use SoftDeletes;
    protected $guarded = [];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
