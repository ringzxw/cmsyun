<?php

namespace App\Models;

class Customer extends BaseModel
{
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


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createUser()
    {
        return $this->belongsTo(Employee::class,'create_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function detail()
    {
        return $this->hasOne(CustomerDetail::class);
    }
}
