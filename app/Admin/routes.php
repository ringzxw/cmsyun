<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'App\Admin\Controllers\HomeController@index');

    $router->resource('employee', \App\Admin\Controllers\Employee\EmployeeController::class);
    $router->get('api/employee-export', 'App\Admin\Controllers\Employee\EmployeeController@apiEmployeeExport');
    $router->get('employee/{id}/permission', 'App\Admin\Controllers\Employee\EmployeePermissionController@index');
    $router->post('api/employee-permission-setting', 'App\Admin\Controllers\Employee\EmployeePermissionController@apiSetting');

    $router->resource('project', \App\Admin\Controllers\Project\ProjectController::class);


});
