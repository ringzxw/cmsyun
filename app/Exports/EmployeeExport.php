<?php

namespace App\Exports;

use App\Models\Employee;
use App\Services\ModelService;
use App\Services\PermissionService;
use App\Traits\ServicesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeeExport implements FromView
{
    public $modelService;
    public function __construct(ModelService $modelService)
    {
        $this->modelService = $modelService;
    }


    public function view(): View
    {
        return view('admin.employee.list', [
            'employees' => $this->modelService->getEmployeeListQuery()
        ]);
    }
}
