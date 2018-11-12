<?php
namespace App\Services;

use App\Models\Employee;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Cache;

class ModelService
{

    public function getEmployeeListQuery()
    {
        $employee = Admin::user();
        $query = Employee::query();
        $requests = Cache::get('EmployeeExporter_'.$employee->id);
        if($requests){
            foreach ($requests as $k=>$v)
            {
                if(is_md5($k)){
                    if($v){
                        $query->where(function ($q) use ($v) {
                            $q->where('name', 'like', '%'.$v.'%')
                                ->orWhere('mobile', 'like', '%' . $v . '%')
                                ->orWhere('username', 'like', '%' . $v . '%');
                        });
                    }
                    continue;
                }
            }
        }
        return $query;
    }
}