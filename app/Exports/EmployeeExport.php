<?php

namespace App\Exports;

use App\Models\Employee;
use App\Services\Traits\ServicesTrait;
use Encore\Admin\Facades\Admin;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeeExport implements FromView
{
    use ServicesTrait;

    public function view(): View
    {
        /** @var Employee $employee */
        $employee = Admin::user();
        return view('admin.employee.list', [
            'employees' => $this->getQueryService($employee)->getEmployeeListExportQuery()
        ]);
    }
}
