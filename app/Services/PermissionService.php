<?php
namespace App\Services;

use App\Models\Employee;
use App\Models\PermissionGroup;
use App\Utils\PermissionUtils;
use Encore\Admin\Auth\Database\Permission;

class PermissionService extends BaseService
{

    public function getPermissionGroup()
    {
        $permissionGroups = PermissionGroup::with('permissions')->get();
//
//        $permissions = Permission::all();
//        //更新个人权限
//        if($this->employee){
//            $employeePermissions = $this->employee->permissions;
//            if(count($employeePermissions) != count($permissions)){
//                //没有所有操作的权限
//                $this->employee->permissions()->detach(1);
//            }
//        }
//        $permissionGroups = array();
//        foreach ($permissions as $permission)
//        {
//            $permission->is_all = 'single';
//            $first =  explode('-',$permission->slug)[0];
//            $configs = PermissionUtils::permissionConfigs();
//
//            foreach ($configs as $k => $v)
//            {
//                if($first == $v['key']){
//                    $permissionGroups[$k]['name'] = $v['name'];
//                    $permissionGroups[$k]['list'][] = $permission;
//                    if($k === 0){
//                        $permission->is_all = 'all';
//                    }
//                }
//            }
//        }
        return $permissionGroups;
    }

    public function bindPermission($employee_id,$permission_ids)
    {
        $employee = Employee::find($employee_id);
        $employee->permissions()->detach();
        $employee->permissions()->attach($permission_ids);
    }



    public function getAllPermissionOption()
    {
        return Permission::all()->pluck('id','name');
    }

    public function check($permission)
    {
        $employee = $this->employee;
        if (is_array($permission)) {
            collect($permission)->each(function ($permission) use ($employee){
                call_user_func_array([$this, 'check'], [$employee,$permission]);
            });
            return true;
        }
        if ($employee->cannot($permission)) {
            return false;
        }
        return true;
    }
}