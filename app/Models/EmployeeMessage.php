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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|null
     */
    public function biz()
    {
        switch ($this->biz_type)
        {
            case ConstUtils::BIZ_TYPE_EMPLOYEE:
                return $this->belongsTo(Employee::class,'biz_id');
            case ConstUtils::BIZ_TYPE_PROJECT:
                return $this->belongsTo(Project::class,'biz_id');
            case ConstUtils::BIZ_TYPE_CUSTOMER:
                return $this->belongsTo(Customer::class,'biz_id');
            case ConstUtils::BIZ_TYPE_MOBILE_IMPORT:
                return $this->belongsTo(MobileImport::class,'biz_id');
        }
        return null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(Employee::class,'creator_id');
    }
}
