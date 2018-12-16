<?php

namespace App\Models;

use App\Utils\FormatUtil;
use Illuminate\Database\Eloquent\Model;

class MobileImport extends Model
{
    protected $guarded = [];
    /** 导入状态：导入中 */
    const STATUS_WAIT       = 10;
    /** 导入状态：已导入 */
    const STATUS_FINISH     = 20;
    /** 导入状态：已关闭 */
    const STATUS_CLOSE      = 88;

    /**
     * Detach models from the relationship.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->status = static::STATUS_WAIT;
        });
    }

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
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function projectItem()
    {
        return $this->belongsTo(ProjectItem::class);
    }

    /**
     * 追加到模型数组表单的访问器
     *
     * @var array
     */
    protected $appends = ['status_html','labels_html'];

    public function getStatusHtmlAttribute()
    {
        return $this->getStatusHtml($this->status);
    }

    public function getLabelsHtmlAttribute()
    {
        return FormatUtil::getLabelHtml($this->labels);
    }

    /**
     * 获取客户意向等级样式
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    private static function getStatusHtml($val, $default = '')
    {
        $isMapping = [
            self::STATUS_WAIT     =>  '导入中',
            self::STATUS_FINISH   =>  '已导入',
            self::STATUS_CLOSE    =>  '已关闭',
        ];
        if (array_key_exists($val,$isMapping)) {
            return $isMapping[$val];
        }
        return $default;
    }
}
