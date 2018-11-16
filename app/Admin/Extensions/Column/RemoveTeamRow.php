<?php

namespace App\Admin\Extensions\Column;

use Encore\Admin\Admin;

class RemoveTeamRow
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
$('.grid-row-remove').unbind('click').click(function() {
    var ids = [];
    var id = $(this).data('id');
    ids.push(id);
    swal({ 
      title: "确认移除操作?",
      text:"从团队中移除，请先确认后再执行！",
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
                    url: '/admin/api/employee-team-remove',
                    dataType: "json",
                    data: {
                        _token:LA.token,
                        employee_ids: ids,
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

        return "<a href='javascript:void(0);' data-id='{$this->id}' class='grid-row-remove' style='margin-left: 10px;'>移除</a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}