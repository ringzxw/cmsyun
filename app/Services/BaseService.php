<?php
namespace App\Services;

use App\Models\Customer;
use App\Models\Employee;
use App\Traits\ServicesTrait;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BaseService
{
    use ServicesTrait;
    /** @var Employee $employee */
    protected $employee;

    public function init(Employee $employee = null)
    {
        $this->employee = $employee;
    }
}