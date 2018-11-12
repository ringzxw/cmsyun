<?php

namespace App\Exports;

use App\Traits\ServicesTrait;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeeExport implements FromView
{
    use ServicesTrait;

    public function view(): View
    {
        return view('admin.employee.list', [
            'employees' => $this->getModelService()->getEmployeeListQuery()
        ]);
    }
}
