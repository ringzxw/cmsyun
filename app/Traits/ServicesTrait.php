<?php

namespace App\Traits;

use App\Models\Employee;
use App\Services\PermissionService;
use App\Services\QueryService;

trait ServicesTrait
{

    /**
     * @return \Illuminate\Foundation\Application|mixed|permissionService
     */
    public function getPermissionService(Employee $employee = null)
    {
        /** @var PermissionService $service */
        $service = app('permissionService');
        $service->init($employee);
        return $service;
    }


    /**
     * @return \Illuminate\Foundation\Application|mixed|queryService
     */
    public function getQueryService(Employee $employee = null)
    {
        /** @var QueryService $service */
        $service = app('queryService');
        $service->init($employee);
        return $service;
    }
}