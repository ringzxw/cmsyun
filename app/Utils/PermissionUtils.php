<?php
/**
 * Created by PhpStorm.
 * User: zhuxiaowei
 * Date: 2018/11/9
 * Time: 2:07 PM
 */

namespace App\Utils;


class PermissionUtils
{
    /**
     * @return array
     */
    public static function permissionConfigs(){
        $configs = array();

        $configs[0]['key'] = '*';
        $configs[0]['name'] = '超级管理员';

        $configs[1]['key'] = 'employee';
        $configs[1]['name'] = '员工管理';

        $configs[2]['key'] = 'team';
        $configs[2]['name'] = '团队管理';

        $configs[3]['key'] = 'project';
        $configs[3]['name'] = '项目管理';

        $configs[4]['key'] = 'customer';
        $configs[4]['name'] = '客户管理';

        $configs[5]['key'] = 'view';
        $configs[5]['name'] = '客户查看权限管理';
        return $configs;
    }

}