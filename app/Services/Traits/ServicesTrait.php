<?php

namespace App\Services\Traits;

use App\Models\Employee;
use App\Services\EmployeeService;
use App\Services\MessageService;
use App\Services\MobileService;
use App\Services\PermissionService;
use App\Services\QueryService;

trait ServicesTrait
{


    /**
     * @param Employee|null $employee
     * @return PermissionService
     */
    public function getPermissionService(Employee $employee = null)
    {
        /** @var PermissionService $service */
        $service = app('permissionService');
        $service->init($employee);
        return $service;
    }


    /**
     * @param Employee|null $employee
     * @return \Illuminate\Foundation\Application|mixed|queryService
     */
    public function getQueryService(Employee $employee = null)
    {
        /** @var QueryService $service */
        $service = app('queryService');
        $service->init($employee);
        return $service;
    }

    /**
     * @param Employee|null $employee
     * @return \Illuminate\Foundation\Application|mixed|employeeService
     */
    public function getEmployeeService(Employee $employee = null)
    {
        /** @var EmployeeService $service */
        $service = app('employeeService');
        $service->init($employee);
        return $service;
    }

    /**
     * @param Employee|null $employee
     * @return \Illuminate\Foundation\Application|mixed|messageService
     */
    public function getMessageService(Employee $employee = null)
    {
        /** @var MessageService $service */
        $service = app('messageService');
        $service->init($employee);
        return $service;
    }

    /**
     * @param Employee|null $employee
     * @return \Illuminate\Foundation\Application|mixed|mobileService
     */
    public function getMobileService(Employee $employee = null)
    {
        /** @var MobileService $service */
        $service = app('mobileService');
        $service->init($employee);
        return $service;
    }
}