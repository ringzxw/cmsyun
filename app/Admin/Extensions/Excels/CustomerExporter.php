<?php

namespace App\Admin\Extensions\Excels;

use Encore\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Facades\Excel;

class CustomerExporter extends AbstractExporter
{
    public function export()
    {
        $customerArray = $this->getData(false);
        $filePath = 'public/exports/customer.xlsx';
        Excel::load($filePath, function($excel) use($customerArray)
        {
            //读取sheet
            $excel->sheet('Sheet1',function($sheet) use($customerArray)
            {
                //修改每个单元格的内容
                $sheet->cell('A1',function($cell)
                {
                    $cell->setValue('CRM客户信息表');
                });
                foreach ($customerArray as $k=>$customer)
                {
                    $cell[0] = $k+1;
                    $cell[1] = $customer->name;
                    $cell[2] = $customer->mobile;
                    $cell[3] = $customer->keyword;
                    $cell[4] = $customer->status;
                    $cell[5] = $customer->employee->name;
                    $sheet->row($k+3,$cell);

                }
            });
        })->export('xls');
        exit;
    }
}