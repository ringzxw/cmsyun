<?php

namespace App\Admin\Extensions\Columns;

use Encore\Admin\Admin;

class AddTeamManagerRow
{
    protected $id;
    protected $team_id;

    public function __construct($id,$team_id)
    {
        $this->id = $id;
        $this->team_id = $team_id;
    }

    protected function script()
    {
        return <<<SCRIPT
$('.grid-row-add-manager').unbind('click').click(function() {
    var id = $(this).data('id');
    swal({ 
      title: '确认设置操作？',
      text:"设置此员工为团队管理员，团队中只会有一个管理员！", 
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
                    url: '/admin/api/employee-team-manager-setting',
                    dataType: "json",
                    data: {
                        _token:LA.token,
                        employee_id: id,
                        employee_team_id: '{$this->team_id}',
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

        return "<a href='javascript:void(0);' data-id='{$this->id}' class='grid-row-add-manager'>设置管理员</a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}