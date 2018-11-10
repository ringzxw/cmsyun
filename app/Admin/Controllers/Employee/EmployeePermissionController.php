<?php

namespace App\Admin\Controllers\Employee;

use App\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Services\PermissionService;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;

class EmployeePermissionController extends Controller
{
    use ApiResponse;
    /**
     * Index interface.
     *
     * @return Content
     */
    public function index($id,Content $content,PermissionService $permissionService)
    {
       $employee = Employee::find($id);
       $permissionGroups = $permissionService->getPermissionGroup();
        return $content
            ->header('权限列表')
            ->body(view('admin.employee.permission',compact('permissionGroups','employee')));
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function apiSetting(Request $request,PermissionService $permissionService)
    {
        $employee_id = $request->get('employee_id');
        $ids = $request->get('ids');
        try{
            $permissionService->bindPermission($employee_id,$ids);
            return $this->message('设置成功');
        }catch (\Exception $e){
            return $this->message($e->getMessage(),'error');
        }
    }
}
