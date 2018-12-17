<?php

namespace App\Admin\Extensions\Columns;

use App\Models\MobileImport;
use Encore\Admin\Admin;

class CloseMobileImportRow
{
    protected $id;
    protected $status;

    public function __construct($id,$status)
    {
        $this->id = $id;
        $this->status = $status;
    }

    protected function script()
    {
        return <<<SCRIPT
$('.grid-row-close').unbind('click').click(function() {
    var id = $(this).data('id');
    swal({ 
      title: '确认关闭？', 
      type: 'warning',
      showCancelButton: true, 
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '确定', 
      cancelButtonText: '取消',
      preConfirm: function(result) {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    method: 'post',
                    url: '/admin/api/mobile-close',
                    dataType: "json",
                    data: {
                        _token:LA.token,
                        id: id
                    },
                    success: function (json) {
                        $.pjax.reload('#pjax-container');
                        if(json.status == 'success'){
                            swal(json.message, '', 'success');
                        }else{
                            swal(json.message, '', 'error');
                        }
                    }
                });
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
        $name = '';
        switch ($this->status)
        {
            case MobileImport::STATUS_FINISH;
                $name = '关闭';
                break;
            case MobileImport::STATUS_CLOSE;
                $name = '恢复';
                break;
        }
        return "<a href='javascript:void(0);' data-id='{$this->id}' class='grid-row-close'>{$name}</a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}