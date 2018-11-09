<?php
namespace App\Services;

use App\Models\Employee;
use App\Utils\PermissionUtils;
use Encore\Admin\Auth\Database\Permission;

class PermissionService
{

    public function getPermissionGroup()
    {
        $permissions = Permission::all();
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
//
//
//
//
//            switch ($first)
//            {
//                case '*':
//                    $permissionGroups[0]['name'] = '全部';
//                    $permissionGroups[0]['list'][] = $permission;
//                    $permission->is_all = 'all';
//                    break;
//                case 'employee':
//                    $permissionGroups[1]['name'] = '员工管理';
//                    $permissionGroups[1]['list'][] = $permission;
//                    break;
//                case 'project':
//                    $permissionGroups[2]['name'] = '项目管理';
//                    $permissionGroups[2]['list'][] = $permission;
//                    break;
//            }
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