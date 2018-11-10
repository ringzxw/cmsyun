<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Grid\Tools\BatchAction;

class RemoveTeamPost extends BatchAction
{
    protected $team_id;
    public function __construct($team_id)
    {
        $this->team_id = $team_id;
    }

    public function script()
    {
        return <<<EOT
$('{$this->getElementClass()}').on('click', function() {
    swal({
      title: "确认移除?",
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
                    url: '/admin/api/remove-team',
                    dataType: "json",
                    data: {
                        _token:LA.token,
                        ids: selectedRows(),
                        team_id: '{$this->team_id}',
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