<?php

namespace App\Admin\Extensions\Nav;

use App\Services\CustomerService;
use App\Services\EmployeeBonusService;
use App\Services\EmployeeLeaveService;
use App\Services\EmployeeService;
use App\Services\RemindService;
use App\Services\TaskService;
use App\Utils\DateUtil;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Cache;

class Links
{
    public function __toString()
    {
        $employeeAuth = EmployeeService::getEmployeeAuth(Admin::user());
        $today = DateUtil::day();
        $cacheName = 'todayMeet'.Admin::user()->id;
        $count = 0;
        if(Cache::has($cacheName)){
            $count = Cache::get($cacheName);
        }else{
            Cache::put($cacheName,$count,5);
            $count = CustomerService::todayMeet($employeeAuth,$today);
        }
        $styleRemind = '';
        if($count >= 10 && $count<100){
            $styleRemind = 'style="width: 50px;"';
        }elseif($count >= 100 && $count<1000){
            $styleRemind = 'style="width: 55px;"';
        }elseif($count >= 1000){
            $styleRemind = 'style="width: 60px;"';
        }
        $countRemindHtml = '';
        if($count > 0){
            $countRemindHtml = '<span class="label label-success">'.$count.'</span>';
        }


        $count = TaskService::count(Admin::user()->id);
        $style = '';
        if($count >= 10 && $count<100){
            $style = 'style="width: 50px;"';
        }elseif($count >= 100 && $count<1000){
            $style = 'style="width: 55px;"';
        }elseif($count >= 1000){
            $style = 'style="width: 60px;"';
        }
        $countHtml = '';
        if($count > 0){
            $countHtml = '<span class="label label-success">'.$count.'</span>';
        }

        $count = EmployeeBonusService::count(Admin::user());
        $styleBonus = '';
        if($count >= 10 && $count<100){
            $styleBonus = 'style="width: 50px;"';
        }elseif($count >= 100 && $count<1000){
            $styleBonus = 'style="width: 55px;"';
        }elseif($count >= 1000){
            $styleBonus = 'style="width: 60px;"';
        }
        $countBonusHtml = '';
        if($count > 0){
            $countBonusHtml = '<span class="label label-success">'.$count.'</span>';
        }

        $count = EmployeeLeaveService::count(Admin::user());
        $styleLeave = '';
        if($count >= 10 && $count<100){
            $styleLeave = 'style="width: 50px;"';
        }elseif($count >= 100 && $count<1000){
            $styleLeave = 'style="width: 55px;"';
        }elseif($count >= 1000){
            $styleLeave = 'style="width: 60px;"';
        }
        $countLeaveHtml = '';
        if($count > 0){
            $countLeaveHtml = '<span class="label label-success">'.$count.'</span>';
        }

        return <<<HTML
<li {$styleLeave}>
    <a href="#">
      <i class="fa fa-commenting"></i>
      {$countLeaveHtml}
    </a>
</li>
<li {$styleBonus}>
    <a href="#">
      <i class="fa fa-btc"></i>
      {$countBonusHtml}
    </a>
</li>
<li {$style}>
    <a href="#">
      <i class="fa fa-envelope-o"></i>
      {$countHtml}
    </a>
</li>

<li {$styleRemind}>
    <a href="/admin">
      <i class="fa fa-bell-o"></i>
      {$countRemindHtml}
    </a>
</li>

HTML;
    }
}