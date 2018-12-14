<?php

namespace App\Models;

use App\Models\Traits\BizTrait;
use App\Utils\ConstUtils;
use Illuminate\Database\Eloquent\Model;

class EmployeeMessage extends Model
{
    use BizTrait;
    protected $guarded = [];
    /**
     * Detach models from the relationship.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->is_read = ConstUtils::IS_READ_FALSE;
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
