<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Grid\Tools\BatchAction;

class DeleteRemindPost extends BatchAction
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
                $.ajax({
                    method: 'post',
                    url: '/admin/api/delete-remind',
                    dataType: "json",
                    data: {
                        _token:LA.token,
                        ids: selectedRows(),
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
EOT;
    }
}