<?php
namespace App\Services;

use App\Exceptions\PermissionException;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\EmployeeTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EmployeeService extends BaseService
{
    /**
     * 下属员工ID集合
     */
    public function getIds()
    {
        $cacheName = __CLASS__.__FUNCTION__.$this->employee->id;
        if(Cache::has($cacheName)){
            return Cache::get($cacheName);
        }
        //管理员
        if($this->employee->isAdministrator()){
            $employee_ids = Employee::all()->pluck('id')->toArray();
            Cache::put($cacheName,$employee_ids,1);
            return $employee_ids;
        }
        //找到自己的团队
        $employeeTeam = $this->employee->employeeTeam;
        if($employeeTeam instanceof EmployeeTeam){
            //判断是否是团队管理员
            if($employeeTeam->manager_id == $this->employee->id){
                $employee_ids = $employeeTeam->employees->pluck('id');
            }
        }
        //下属只有自己一个人
        $employee_ids[] = $this->employee->id;
        Cache::put($cacheName,$employee_ids,1);
        return $employee_ids;
    }
}