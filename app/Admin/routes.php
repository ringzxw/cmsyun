<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'App\Admin\Controllers\HomeController@index');

    $router->resource('employee', \App\Admin\Controllers\Employee\EmployeeController::class);
    $router->get('api/employee', 'App\Admin\Controllers\Employee\EmployeeController@apiIndex');
    $router->get('api/employee-export', 'App\Admin\Controllers\Employee\EmployeeController@apiEmployeeExport');
    $router->post('api/employee-add-team', 'App\Admin\Controllers\Employee\EmployeeController@apiAddTeam');
    $router->get('employee/{id}/permission', 'App\Admin\Controllers\Employee\EmployeePermissionController@index');
    $router->post('api/employee-permission-setting', 'App\Admin\Controllers\Employee\EmployeePermissionController@apiSetting');

    $router->resource('team', \App\Admin\Controllers\Employee\EmployeeTeamController::class);
    $router->get('team/{id}/employee-list', 'App\Admin\Controllers\Employee\EmployeeTeamController@employeeList');
    $router->post('api/employee-team-manager-setting', 'App\Admin\Controllers\Employee\EmployeeTeamController@apiSetting');
    $router->post('api/employee-team-remove', 'App\Admin\Controllers\Employee\EmployeeTeamController@apiRemove');

    $router->resource('project', \App\Admin\Controllers\Project\ProjectController::class);

    $router->resource('customer', \App\Admin\Controllers\Customer\CustomerController::class);
    $router->post('api/customer-detail', 'App\Admin\Controllers\Customer\CustomerController@apiDetail');
});
