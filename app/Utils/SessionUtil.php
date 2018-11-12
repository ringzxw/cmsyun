<?php
/**
 * Created by PhpStorm.
 * User: zhuxiaowei
 * Date: 2017/8/8
 * Time: 下午9:40
 */

namespace App\Utils;

class SessionUtil
{
    public static function cleanOrderSession()
    {
        session()->forget('customer_id');
        session()->forget('goodIdArray');
        session()->forget('orderAction');
        session()->forget('search');
        session()->forget('page');
        session()->forget('active');
    }
}