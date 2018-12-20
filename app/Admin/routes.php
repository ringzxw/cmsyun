<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->resource('auth/menu', 'App\Admin\Controllers\MenuController', ['except' => ['create']]);
    $router->get('/', 'App\Admin\Controllers\HomeController@index');

    //员工管理
    $router->resource('employee', \App\Admin\Controllers\Employee\EmployeeController::class);
    //员工索引
    $router->get('api/employee', 'App\Admin\Controllers\Employee\EmployeeController@apiIndex');
    //员工导出
    $router->get('api/employee-export', 'App\Admin\Controllers\Employee\EmployeeController@apiEmployeeExport');
    //员工导入页面
    $router->get('employee-import', 'App\Admin\Controllers\Employee\EmployeeController@importCreate');
    //员工导入执行
    $router->post('employee-import', 'App\Admin\Controllers\Employee\EmployeeController@importStore');
    //员工加入团队
    $router->post('api/employee-add-team', 'App\Admin\Controllers\Employee\EmployeeController@apiAddTeam');
    //员工权限
    $router->get('employee/{id}/permission', 'App\Admin\Controllers\Employee\EmployeePermissionController@index');
    //员工权限设置
    $router->post('api/employee-permission-setting', 'App\Admin\Controllers\Employee\EmployeePermissionController@apiSetting');
    //员工消息
    $router->resource('employee-message', \App\Admin\Controllers\Employee\EmployeeMessageController::class);
    //员工消息提示列表
    $router->get('api/message', 'App\Admin\Controllers\Employee\EmployeeMessageController@apiIndex');
    //团队管理
    $router->resource('team', \App\Admin\Controllers\Employee\EmployeeTeamController::class);
    //团队成员列表
    $router->get('team/{id}/employee-list', 'App\Admin\Controllers\Employee\EmployeeTeamController@employeeList');
    //设置团队管理员
    $router->post('api/employee-team-manager-setting', 'App\Admin\Controllers\Employee\EmployeeTeamController@apiSetting');
    //移除团队
    $router->post('api/employee-team-remove', 'App\Admin\Controllers\Employee\EmployeeTeamController@apiRemove');
    //项目管理
    $router->resource('project', \App\Admin\Controllers\Project\ProjectController::class);
    //产品索引
    $router->get('api/project-item', 'App\Admin\Controllers\Project\ProjectController@apiIndex');
    //客户管理
    $router->resource('customer', \App\Admin\Controllers\Customer\CustomerController::class);
    //客户详情接口
    $router->post('api/customer-detail', 'App\Admin\Controllers\Customer\CustomerController@apiDetail');
    //号码池管理
    $router->resource('mobile', \App\Admin\Controllers\Mobile\MobilePoolController::class);
    //号码池导入管理
    $router->resource('mobile-import', \App\Admin\Controllers\Mobile\MobileImportController::class);
    //号码池导入批次关闭和恢复
    $router->post('api/mobile-close', 'App\Admin\Controllers\Mobile\MobileImportController@apiMobileClose');
});
