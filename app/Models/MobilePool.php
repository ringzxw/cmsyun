<?php

namespace App\Models;

use App\Utils\FormatUtil;

class MobilePool extends BaseModel
{
    protected $guarded = [];
    /** 号码池状态：待使用 */
    const STATUS_WAIT_USER  = 10;
    /** 号码池状态：待重置 */
    const STATUS_WAIT_RESET = 20;
    /** 号码池状态：有意向 */
    const STATUS_HAVE       = 30;
    /** 号码池状态：无意向 */
    const STATUS_NOT_HAVE   = 40;
    /** 号码池状态：已关闭 */
    const STATUS_CLOSE      = 88;
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(Employee::class,'user_id');
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
    public function customer()
    {
        return $this->belongsTo(Customer::class,'mobile', 'mobile');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function import()
    {
        return $this->belongsTo(MobileImport::class, 'mobile_import_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo(MobileRegion::class, 'mobile', 'mobile');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(MobileCompany::class, 'mobile', 'mobile');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function detail()
    {
        return $this->belongsTo(MobileDetail::class, 'mobile', 'mobile');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(MobileRegion::class, 'mobile', 'mobile');
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
        return FormatUtil::getLabelHtml($this->import->labels);
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
            self::STATUS_WAIT_USER     =>  '待使用',
            self::STATUS_WAIT_RESET    =>  '待重置',
            self::STATUS_HAVE          =>  '有意向',
            self::STATUS_NOT_HAVE      =>  '无意向',
            self::STATUS_CLOSE         =>  '已关闭',
        ];
        if (array_key_exists($val,$isMapping)) {
            return $isMapping[$val];
        }
        return $default;
    }
}
