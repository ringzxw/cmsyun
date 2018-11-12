<?php

namespace App\Traits;

use App\Services\ModelService;
use App\Services\PermissionService;

trait ServicesTrait
{

    /**
     * @return \Illuminate\Foundation\Application|mixed|permissionService
     */
    public function getPermissionService()
    {
        /** @var PermissionService $permissionService */
        $permissionService = app('permissionService');
        return $permissionService;
    }


    /**
     * @return \Illuminate\Foundation\Application|mixed|modelService
     */
    public function getModelService()
    {
        /** @var ModelService $modelService */
        $modelService = app('modelService');
        return $modelService;
    }
}