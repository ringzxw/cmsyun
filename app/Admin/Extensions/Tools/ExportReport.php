<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Grid\Tools\BatchAction;

class ExportReport extends BatchAction
{
    public function __construct()
    {
    }

    public function script()
    {
        return <<<EOT
$('{$this->getElementClass()}').on('click', function() {
    swal({
      title: "确认此操作?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      confirmButtonText: "确认",
      closeOnConfirm: false,
      cancelButtonText: "取消",
      preConfirm: function(result) {
            return new Promise(function(resolve, reject) {
                window.open('/admin/report/customer-success/export-report/'+ selectedRows());
                swal('导出成功', '', 'success');
            });
      }, 
    }).then(function(){
      
    })
});
EOT;
    }
}