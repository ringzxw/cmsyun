<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerFollow extends BaseModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(Employee::class,'creator_id');
    }


}
