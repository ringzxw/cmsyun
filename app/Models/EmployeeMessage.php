<?php

namespace App\Models;

use App\Models\Traits\BizTrait;
use App\Utils\ConstUtils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeMessage extends Model
{
    use BizTrait;
    use SoftDeletes;
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    /**
     * Detach models from the relationship.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->is_read = ConstUtils::READ_FALSE;
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
