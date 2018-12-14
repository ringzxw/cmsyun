<?php

namespace App\Admin\Extensions\Importers;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class EmployeeImporter extends AbstractTool
{
    public function render()
    {
        return view('admin.employee.import');
    }
}