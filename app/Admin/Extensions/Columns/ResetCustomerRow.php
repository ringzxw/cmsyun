<?php

namespace App\Admin\Extensions\Columns;

use Encore\Admin\Admin;

class ResetCustomerRow
{
    protected $id;
    protected $field;

    public function __construct($id,$field)
    {
        $this->id = $id;
        $this->field = $field;
    }

    protected function script()
    {
        return <<<SCRIPT
$('.grid-row-reset').unbind('click').click(function() {
    var ids = [];
    var id = $(this).data('id');
    ids.push(id);
    swal({ 
      title: '确认重置？',
      text:"重置后进入客户池，客户列表中的客户不做任何改动！", 
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
                    url: '/admin/api/reset-customer',
                    dataType: "json",
                    data: {
                        _token:LA.token,
                        ids: ids,
                        field:'{$this->field}',
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
        return "<a href='javascript:void(0);' data-id='{$this->id}' class='grid-row-reset' style='margin-right: 5px;'>重置</a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}