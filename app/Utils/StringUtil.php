<?php
/**
 * Created by PhpStorm.
 * User: zhuxiaowei
 * Date: 2017/8/8
 * Time: 下午9:40
 */

namespace App\Utils;

class StringUtil
{
    public static function subtext($text, $length)
    {
        if(mb_strlen($text, 'utf8') > $length)
            return mb_substr($text, 0, $length, 'utf8').'...';
        return $text;
    }

    public static function customerRandomText($str)
    {
        $textArray['name'] = '';
        $textArray['labels'] = '';
        $textArray['log_content'] = '';
        $texts = explode('};',$str);
        foreach ($texts as $text)
        {
            if($text){
                if(strpos($text,'姓名{')!== false){
                    $textArray['name'] = mb_str_replace("姓名{","",$text);
                }
                if(strpos($text,'意向等级{')!== false){
                    $textArray['labels'] = FormatUtil::getLabels(strtoupper(mb_str_replace("意向等级{","",$text)));
                }
                if(strpos($text,'跟进内容{')!== false){
                    $textArray['log_content'] = mb_str_replace("跟进内容{","",$text);
                }
            }
        }
        return $textArray;
    }

    public static function numColor($num)
    {
        return $num?"<span class='label label-success'>".$num."</span>":"<span class='label label-danger'>0</span>";;
    }

    public static function textStyle()
    {
        return "<span style='color: white'>占位</span>";
    }
}