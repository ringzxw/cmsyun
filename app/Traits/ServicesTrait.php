<?php

namespace App\Traits;

use App\Services\PermissionService;

trait ServicesTrait
{
    public $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

}