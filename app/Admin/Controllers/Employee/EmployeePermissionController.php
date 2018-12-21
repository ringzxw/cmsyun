<?php

namespace App\Admin\Controllers\Employee;

use App\Admin\Controllers\Controller;
use App\Models\Employee;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;

class EmployeePermissionController extends Controller
{
    /**
     * Index interface.
     *
     * @return Content
     */
    public function index($id,Content $content)
    {
        $employee = Employee::find($id);
        $permissionGroups = $this->getPermissionService($employee)->getPermissionGroup();
        $employee = Employee::find($id);
        return $content
            ->header('权限列表')
            ->body(view('admin.employee.permission',compact('permissionGroups','employee')));
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function apiSetting(Request $request)
    {
        $employee_id = $request->get('employee_id');
        $ids = $request->get('ids');
        try{
            $this->getPermissionService()->bindPermission($employee_id,$ids);
            return $this->message('设置成功');
        }catch (\Exception $e){
            return $this->message($e->getMessage(),'error');
        }
    }
}
