<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;

class EmployeeImport implements ToArray
{
    public function Array(Array $tables)
    {
        return $tables;
    }
}
