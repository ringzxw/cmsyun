<?php
/**
 * Created by PhpStorm.
 * User: zhuxiaowei
 * Date: 2018/9/28
 * Time: 4:05 PM
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model{
    public function scopeWithOnly($query, $relation, Array $columns)
    {
        return $query->with([$relation => function ($query) use ($columns){
            $query->select(array_merge(['id'], $columns));
        }]);
    }
}