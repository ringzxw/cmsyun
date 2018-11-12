<?php
namespace App\Services;

use App\Models\Employee;
use App\Utils\PermissionUtils;
use Encore\Admin\Auth\Database\Permission;

class PermissionService
{

    public function getPermissionGroup(Employee $employee = null)
    {
        $permissions = Permission::all();
        //更新个人权限
        if($employee){
            $employeePermissions = $employee->permissions;
            if(count($employeePermissions) != count($permissions)){
                //没有所有操作的权限
                $employee->permissions()->detach(1);
            }
        }
        $permissionGroups = array();
        foreach ($permissions as $permission)
        {
            $permission->is_all = 'single';
            $first =  explode('-',$permission->slug)[0];
            $configs = PermissionUtils::permissionConfigs();

            foreach ($configs as $k => $v)
            {
                if($first == $v['key']){
                    $permissionGroups[$k]['name'] = $v['name'];
                    $permissionGroups[$k]['list'][] = $permission;
                    if($k === 0){
                        $permission->is_all = 'all';
                    }
                }
            }
        }
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
}