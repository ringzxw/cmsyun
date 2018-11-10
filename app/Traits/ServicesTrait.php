<?php

namespace App\Traits;

use App\Services\PermissionService;

trait ServicesTrait
{
    public $permissionService;

    public function __construct()
    {

    }

    public function getPermissionService(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
        return $this->permissionService;
    }

}