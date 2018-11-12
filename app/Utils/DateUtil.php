<?php
/**
 * Created by PhpStorm.
 * User: zhuxiaowei
 * Date: 2017/8/8
 * Time: 下午9:40
 */

namespace App\Utils;

use Carbon\Carbon;

class DateUtil
{
    /**
     * 选择年
     * @return mixed
     */
    public static function yearArray()
    {
        $array = array();
        $array[2018] = 2018;
        $array[2019] = 2019;
        $array[2020] = 2020;
        $array[2021] = 2021;
        $array[2022] = 2022;
        return $array;
    }

    /**
     * 选择月
     * @return mixed
     */
    public static function monthArray()
    {
        $array = array();
        $array[1] = '01';
        $array[2] = '02';
        $array[3] = '03';
        $array[4] = '04';
        $array[5] = '05';
        $array[6] = '06';
        $array[7] = '07';
        $array[8] = '08';
        $array[9] = '09';
        $array[10] = '10';
        $array[11] = '11';
        $array[12] = '12';
        return $array;
    }

    /**
     * 昨日
     * @return mixed
     */
    public static function yesterday()
    {
        $timeStart = Carbon::yesterday();
        $timeEnd = Carbon::today()->subSecond(1);
        $time['timeStart'] = $timeStart;
        $time['timeEnd'] = $timeEnd;
        return $time;
    }

    /**
     * 本日
     * @return mixed
     */
    public static function day()
    {
        $timeStart = Carbon::today();
        $timeEnd = Carbon::tomorrow()->subSecond(1);
        $time['timeStart'] = $timeStart;
        $time['timeEnd'] = $timeEnd;
        return $time;
    }

    /**
     * 本周
     * @return mixed
     */
    public static function week()
    {
        $timeStart = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d") - date("w") + 1, date("Y")));
        $timeEnd = date("Y-m-d H:i:s", mktime(23, 59, 59, date("m"), date("d") - date("w") + 7, date("Y")));
        $time['timeStart'] = $timeStart;
        $time['timeEnd'] = $timeEnd;
        return $time;
    }

    /**
     * 本月
     * @return mixed
     */
    public static function month()
    {
        $timeStart = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), 1, date("Y")));
        $timeEnd = date("Y-m-d H:i:s", mktime(23, 59, 59, date("m"), date("t"), date("Y")));
        $time['timeStart'] = $timeStart;
        $time['timeEnd'] = $timeEnd;
        return $time;
    }


    /**
     * 日期格式化
     * @param $date
     * @return string
     */
    public static function dateFormat($date)
    {
        if(empty($date)){
            return '';
        }
        $carbon = Carbon::parse($date);
        return $carbon->toDateString();
    }

    /**
     * 时间格式化
     * @param $date
     * @return string
     */
    public static function datetimeFormat($date)
    {
        if(empty($date)){
            return '';
        }
        $carbon = Carbon::parse($date);
        return $carbon->toDateTimeString();
    }

    /**
     * 指定时间开始
     * @param $date
     * @return string
     */
    public static function startOfDay($date)
    {
        if(empty($date)){
            return '';
        }
        if(strtotime($date)){
            return Carbon::parse($date)->startOfDay()->toDateTimeString();
        }else{
            return Carbon::createFromTimestamp($date)->startOfDay()->toDateTimeString();
        }
    }

    /**
     * 指定时间开始
     * @param $date
     * @return string
     */
    public static function endOfDay($date)
    {
        if(empty($date)){
            return '';
        }
        if(strtotime($date)){
            return Carbon::parse($date)->endOfDay()->toDateTimeString();
        }else{
            return Carbon::createFromTimestamp($date)->endOfDay()->toDateTimeString();
        }
    }


    /**
     * 本地化时间，优化阅读
     * @param $date
     * @return string
     */
    public static function diffForHumans($date)
    {
        if(empty($date)){
            return '';
        }
        Carbon::setLocale('zh');
        return Carbon::parse($date)->diffForHumans();
    }

    /**
     * 时间格式化
     * @param $date
     * @return mixed
     */
    public static function dayFormat($date)
    {
        $date = explode('-',$date);
        if(count($date)!=3){
            return null;
        }
        $y = $date[0];
        $m = $date[1];
        $d = $date[2];
        return Carbon::createFromDate($y, $m, $d)->startOfDay()->toDateTimeString();
    }

}