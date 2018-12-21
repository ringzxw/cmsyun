<?php

namespace App\Models;

use App\Utils\FormatUtil;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends BaseModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = [];
    /** 客户状态：待约访 */
    const STATUS_WAIT_MEET = -2;
    /** 客户状态：待分配 */
    const STATUS_WAIT_ALLOT = -1;
    /** 客户状态：约访中 */
    const STATUS_MEET = 1;
    /** 客户状态：成交 */
    const STATUS_SUCCESS = 2;
    /** 客户状态：无效 */
    const STATUS_END = 3;
    /** 客户状态：来访 */
    const STATUS_COME = 4;
    /** 客户状态：认筹 */
    const STATUS_REAL = 5;



    /** 意向等级：S */
    const LABEL_S = 10;
    /** 意向等级：A */
    const LABEL_A = 20;
    /** 意向等级：B */
    const LABEL_B = 30;
    /** 意向等级：C */
    const LABEL_C = 40;
    /** 意向等级：D */
    const LABEL_D = 50;
    /** 意向等级：E */
    const LABEL_E = 60;
    /** 意向等级：F */
    const LABEL_F = 70;
    /** 意向等级：G */
    const LABEL_G = 80;
    /** 意向等级：H */
    const LABEL_H = 90;
    /** 意向等级：I */
    const LABEL_I = 100;

    protected static function boot()
    {
        parent::boot();
        // 监听模型创建事件，在写入数据库之后触发
        static::created(function ($model) {
            // 如果模型的 no 字段为空
            if (!$model->detail) {
                $detail = new CustomerDetail();
                $detail->customer_id = $model->id;
                $detail->save();
            }
        });
    }

    /**
     * 追加到模型数组表单的访问器
     *
     * @var array
     */
    protected $appends = ['status_html','labels_html'];

    public function getStatusHtmlAttribute()
    {
        return FormatUtil::getCustomerStatusHtml($this->status);
    }

    public function getLabelsHtmlAttribute()
    {
        return FormatUtil::getLabelHtml($this->labels);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(Employee::class,'creator_id');
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
    public function scene()
    {
        return $this->belongsTo(Employee::class,'scene_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function detail()
    {
        return $this->hasOne(CustomerDetail::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function follows()
    {
        return $this->hasMany(CustomerFollow::class);
    }


}
