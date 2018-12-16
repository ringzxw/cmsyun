<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;

class MobilePoolImport implements ToArray
{
    public function Array(Array $tables)
    {
        return $tables;
    }
}
