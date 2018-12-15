<?php
namespace App\Services;

use App\Models\Employee;
use App\Models\Permission;
use App\Models\PermissionGroup;
class PermissionService extends BaseService
{

    public function getPermissionGroup()
    {
        $permissionGroups = PermissionGroup::with('permissions')->get();
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
        $permissions = Permission::with('group')->orderBy('sort')->get();
        $permissionArray = array();
        foreach ($permissions as $k => $permission)
        {
            $permissionArray[$permission->slug] = $permission->full_name;
        }
        return $permissionArray;
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