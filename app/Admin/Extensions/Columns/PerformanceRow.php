<?php

namespace App\Admin\Extensions\Columns;

use App\Models\Base;
use App\Models\Performance;
use Encore\Admin\Admin;

class PerformanceRow
{
    protected $id;
    protected $row;
    protected $text;
    public function __construct($id,$row)
    {
        $this->id  = $id;
        $this->row = $row;
        /** @var Performance $performance */
        $performance = $this->row;
        $this->text = '导出'.$performance->year.'/'.$performance->month.'员工的工资表';
    }

    protected function script()
    {
        return <<<SCRIPT
$('.grid-row-export').unbind('click').click(function() {
   
    var id = $(this).data('id');
    var text = $(this).data('text');
    swal({ 
      title: '确认导出？',
      text:  text, 
      type: 'warning',
      showCancelButton: true, 
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '确定', 
      cancelButtonText: '取消',
      preConfirm: function(result) {
            return new Promise(function(resolve, reject) {
                window.open('/admin/performance/export/'+id);
                swal('导出成功', '', 'success');
            });
        }, 
    }).then(function(){
      
    })
});
SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());
        if($this->row->status == Base::IMPORT_TRUE){
            return "<a href='javascript:void(0);' data-id='{$this->id}' data-text='{$this->text}' class='grid-row-export' style='margin-right: 5px;'>工资表导出</a>";
        }else{
            return "";
        }
    }

    public function __toString()
    {
        return $this->render();
    }
}