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
        $permissionGroups = [
            [
                'name'          => '超级管理员',
                'title'         => '',
                'permission'    => [
                    [
                        'name'          => '全部',
                        'slug'          => '*',
                        'http_method'   => '',
                        'http_path'     => '*',
                    ],
                ]
            ],

            [
                'name'          => '员工管理',
                'title'         => '',
                'permission'    => [
                    [
                        'name'          => '列表',
                        'slug'          => 'employee-index',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                    [
                        'name'          => '详情',
                        'slug'          => 'employee-show',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                    [
                        'name'          => '新增',
                        'slug'          => 'employee-create',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                    [
                        'name'          => '编辑',
                        'slug'          => 'employee-edit',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                    [
                        'name'          => '删除',
                        'slug'          => 'employee-delete',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                    [
                        'name'          => '权限设置',
                        'slug'          => 'employee-permission',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                    [
                        'name'          => '团队设置',
                        'slug'          => 'employee-team',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                ]
            ],

            [
                'name'          => '团队管理',
                'title'         => '',
                'permission'    => [
                    [
                        'name'          => '列表',
                        'slug'          => 'team-index',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                    [
                        'name'          => '详情',
                        'slug'          => 'team-show',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                    [
                        'name'          => '新增',
                        'slug'          => 'team-create',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                    [
                        'name'          => '编辑',
                        'slug'          => 'team-edit',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                    [
                        'name'          => '删除',
                        'slug'          => 'team-delete',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                ]
            ],

            [
                'name'          => '项目管理',
                'title'         => '',
                'permission'    => [
                    [
                        'name'          => '列表',
                        'slug'          => 'project-index',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                    [
                        'name'          => '详情',
                        'slug'          => 'project-show',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                    [
                        'name'          => '新增',
                        'slug'          => 'project-create',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                    [
                        'name'          => '编辑',
                        'slug'          => 'project-edit',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                    [
                        'name'          => '删除',
                        'slug'          => 'project-delete',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                ]
            ],

            [
                'name'          => '客户管理',
                'title'         => '',
                'permission'    => [
                    [
                        'name'          => '列表',
                        'slug'          => 'customer-index',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                    [
                        'name'          => '详情',
                        'slug'          => 'customer-show',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                    [
                        'name'          => '新增',
                        'slug'          => 'customer-create',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                    [
                        'name'          => '编辑',
                        'slug'          => 'customer-edit',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                    [
                        'name'          => '删除',
                        'slug'          => 'customer-delete',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                    [
                        'name'          => '分配',
                        'slug'          => 'customer-allot',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                    [
                        'name'          => '跟进',
                        'slug'          => 'customer-follow',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                ]
            ],

            [
                'name'          => '客户权限管理',
                'title'         => '所有>下属>自己，系统自动选择最大的权限！',
                'permission'    => [
                    [
                        'name'          => '查看所有',
                        'slug'          => 'view-customer-all',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                    [
                        'name'          => '查看下属',
                        'slug'          => 'view-customer-team',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                    [
                        'name'          => '查看自己',
                        'slug'          => 'view-customer-me',
                        'http_method'   => '',
                        'http_path'     => '',
                    ],
                ]
            ],
        ];

        \App\Models\PermissionGroup::destroy(\App\Models\PermissionGroup::all()->pluck('id')->toArray());
        \App\Models\Permission::destroy(\App\Models\Permission::all()->pluck('id')->toArray());
        $int = 1;
        foreach ($permissionGroups as $k => $permissionGroup) {
            $itemG['id']     = $k+1;
            $itemG['name']   = $permissionGroup['name'];
            $itemG['title']  = $permissionGroup['title'];
            $this->createPermissionGroup($itemG);
            foreach ($permissionGroup['permission'] as $j => $permission) {
                $item['id']                     = $int;
                $item['permission_group_id']    = $itemG['id'];
                $item['name']                   = $permission['name'];
                $item['slug']                   = $permission['slug'];
                $this->createPermission($item);
                $int++;
            }
        }
    }

    protected function createPermissionGroup($item)
    {
        // 创建一个新的类目对象
        $permissionGroup = new \App\Models\PermissionGroup($item);
        //  保存到数据库
        $permissionGroup->save();
    }

    protected function createPermission($item)
    {
        // 创建一个新的类目对象
        $permission = new \App\Models\Permission($item);
        //  保存到数据库
        $permission->save();
    }
}
