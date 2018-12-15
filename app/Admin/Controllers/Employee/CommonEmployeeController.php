<?php
/**
 * Created by PhpStorm.
 * User: zhuxiaowei
 * Date: 2018/11/19
 * Time: 4:52 PM
 */

namespace App\Admin\Controllers\Employee;

use App\Http\Controllers\Controller;
use Encore\Admin\Grid;

class CommonEmployeeController extends Controller
{
    protected function defaultGrid(Grid $grid)
    {
        $grid->id('ID')->sortable();
        $grid->username(trans('admin.username'));
        $grid->name(trans('admin.name'));
        $grid->mobile('联系方式');
        $grid->email('邮箱');
        $grid->team()->name('所属团队')->label('primary');
        $grid->roles(trans('admin.roles'))->pluck('name')->label();
        $grid->disableExport();
        $grid->disableRowSelector();
        return $grid;
    }
}