<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class EmployeeExport implements FromCollection, WithTitle, WithEvents, WithStrictNullComparison
{
    public $data;
    public $excel_name;

    public function __construct(array $data, $excel_name)
    {
        $this->data         = $data;
        $this->excel_name   = $excel_name;
    }

    /**
     * registerEvents    freeze the first row with headings
     * @return array
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2018/11/1  11:19
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // 合并单元格
                $event->sheet->getDelegate()->setMergeCells(['A1:C1']);
                // 冻结窗格
                $event->sheet->getDelegate()->freezePane('A3');
                // 设置单元格内容居中
                $event->sheet->getDelegate()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                // 定义列宽度
                $widths = ['A' => 10, 'B' => 25, 'C' => 25];
                foreach ($widths as $k => $v) {
                    // 设置列宽度
                    $event->sheet->getDelegate()->getColumnDimension($k)->setWidth($v);
                }
//                $event->sheet->getDelegate()->getStyle('A1:C1')->applyFromArray([
//                    'borders' => [
//                        'outline' => [
//                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
//                            'color' => ['argb' => 'FFFF0000'],
//                        ],
//                        'fill' => array (
//                            'type'       => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR ,
//                            'rotation'   => 90,
//                            'color' => array (
//                                'argb' => 'FFFF0000'
//                            )
//                        )
//                    ]
//                ]);
            },
        ];
    }

    /**
     * 需要导出的数据统一在这个方法里面处理 这个方法里面也可以直接用 Model取数据
     * 我这里的数据是 Controller 传过来的，至于怎么传的看下面给出的 Controller 里面的代码就知道了
     * 里面数据处理太长了，多余的我都用 ... 表示，大家明白就行
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if (!empty($this->data)) {
            foreach ($this->data as $key => $vo) {
                $data[$key]['id']       = $vo['id'];
                $data[$key]['name']     = $vo['name'];
                $data[$key]['username'] = $vo['username'];
            }
            $title = [$this->title()];
            $headings = ['ID','姓名','账号'];
            array_unshift($data, $title, $headings);
            // 此处数据需要数组转集合
            return collect($data);
        }
    }

    public function title(): string
    {
        // 设置工作䈬的名称
        return $this->excel_name . '员工明细';
    }

}
