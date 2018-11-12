<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name'          => '所有权限',
                'slug'          => '*',
                'http_method'   => '',
                'http_path'     => '*',
            ],
            [
                'name'          => '员工列表',
                'slug'          => 'employee-index',
                'http_method'   => '',
                'http_path'     => '',
            ],
            [
                'name'          => '员工详情',
                'slug'          => 'employee-show',
                'http_method'   => '',
                'http_path'     => '',
            ],
            [
                'name'          => '员工新增',
                'slug'          => 'employee-create',
                'http_method'   => '',
                'http_path'     => '',
            ],
            [
                'name'          => '员工编辑',
                'slug'          => 'employee-edit',
                'http_method'   => '',
                'http_path'     => '',
            ],
            [
                'name'          => '员工删除',
                'slug'          => 'employee-delete',
                'http_method'   => '',
                'http_path'     => '',
            ],
            [
                'name'          => '员工权限设置',
                'slug'          => 'employee-permission',
                'http_method'   => '',
                'http_path'     => '',
            ],
            [
                'name'          => '项目列表',
                'slug'          => 'project-index',
                'http_method'   => '',
                'http_path'     => '',
            ],
            [
                'name'          => '项目详情',
                'slug'          => 'project-show',
                'http_method'   => '',
                'http_path'     => '',
            ],
            [
                'name'          => '项目新增',
                'slug'          => 'project-create',
                'http_method'   => '',
                'http_path'     => '',
            ],
            [
                'name'          => '项目编辑',
                'slug'          => 'project-edit',
                'http_method'   => '',
                'http_path'     => '',
            ],
            [
                'name'          => '项目删除',
                'slug'          => 'project-delete',
                'http_method'   => '',
                'http_path'     => '',
            ],
            [
                'name'          => '客户列表',
                'slug'          => 'customer-index',
                'http_method'   => '',
                'http_path'     => '',
            ],
            [
                'name'          => '客户详情',
                'slug'          => 'customer-show',
                'http_method'   => '',
                'http_path'     => '',
            ],
            [
                'name'          => '客户新增',
                'slug'          => 'customer-create',
                'http_method'   => '',
                'http_path'     => '',
            ],
            [
                'name'          => '客户编辑',
                'slug'          => 'customer-edit',
                'http_method'   => '',
                'http_path'     => '',
            ],
            [
                'name'          => '客户删除',
                'slug'          => 'customer-delete',
                'http_method'   => '',
                'http_path'     => '',
            ],
            [
                'name'          => '客户跟进',
                'slug'          => 'customer-save-log',
                'http_method'   => '',
                'http_path'     => '',
            ],
        ];

        foreach ($permissions as $key => $data) {
            $data['id'] = $key+1;
            $this->createPermission($data);
        }
    }

    protected function createPermission($data)
    {
        // 创建一个新的类目对象
        $permission = new \Encore\Admin\Auth\Database\Permission($data);
        //  保存到数据库
        $permission->save();
    }
}
