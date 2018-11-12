<?php
/**
 * Created by PhpStorm.
 * User: zhuxiaowei
 * Date: 2017/8/8
 * Time: 下午9:40
 */

namespace App\Utils;

use Illuminate\Support\Facades\File;

class PathUtil
{

    /**
     * @param $url
     * @return string
     */
    public static function downloadFile($url)
    {
        $fileName = self::getUrlFileName($url);
        $file = file_get_contents($url);
        $path = storage_path().'/excel';
        if(!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
        $savePath = $path.'/'.$fileName;
        file_put_contents($savePath,$file);
        return $savePath;
    }

    /**
     * @param $url
     * @return string
     */
    public static function getUrlFileName($url)
    {
        $ary = parse_url($url);
        $file = basename($ary['path']);
        return $file;
    }
}