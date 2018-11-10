<?php

namespace App\Admin\Extensions\Column;

use App\Models\Base;
use Encore\Admin\Admin;

class CloseCustomerImportRow
{
    protected $id;
    protected $is_close;

    public function __construct($id,$is_close)
    {
        $this->id = $id;
        $this->is_close = $is_close;
    }

    protected function script()
    {
        return <<<SCRIPT
$('.grid-row-close').unbind('click').click(function() {
    var ids = [];
    var id = $(this).data('id');
    var close = $(this).data('close');
    ids.push(id);
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
                    url: '/admin/api/close-customer-import',
                    dataType: "json",
                    data: {
                        _token:LA.token,
                        ids: ids,
                        is_close:close,
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
        $name = $this->is_close==Base::CLOSE_TRUE?'关闭':'恢复';
        return "<a href='javascript:void(0);' data-id='{$this->id}' data-close='{$this->is_close}' class='grid-row-close'>{$name}</a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}