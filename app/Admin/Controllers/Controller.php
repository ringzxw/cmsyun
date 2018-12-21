<?php

namespace App\Admin\Controllers;

use App\Helpers\Api\ApiResponse;
use App\Services\Traits\ServicesTrait;
use Encore\Admin\Controllers\HasResourceActions;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use HasResourceActions;
    use ApiResponse;
    use ServicesTrait;
}
