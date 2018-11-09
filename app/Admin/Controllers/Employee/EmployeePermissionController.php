<?php

namespace App\Admin\Controllers\Employee;

use App\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Traits\ServicesTrait;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;

class EmployeePermissionController extends Controller
{
    use ServicesTrait;
    use ApiResponse;
    /**
     * Index interface.
     *
     * @return Content
     */
    public function index($id,Content $content)
    {
       $permissionGroups = $this->permissionService->getPermissionGroup();
        return $content
            ->header('权限列表')
            ->body(view('admin.employee.permission',compact('permissionGroups','id')));
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
            $this->permissionService->bindPermission($employee_id,$ids);
            return $this->message('设置成功');
        }catch (\Exception $e){
            return $this->message($e->getMessage(),'error');
        }
    }
}
