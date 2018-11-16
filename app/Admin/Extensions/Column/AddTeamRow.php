<?php

namespace App\Admin\Extensions\Column;

use App\Models\EmployeeTeam;
use App\Utils\OptionUtil;
use Encore\Admin\Admin;

class AddTeamRow
{
    protected $id;
    protected $teamOption;

    public function __construct($id)
    {
        $this->id = $id;
        $this->teamOption = OptionUtil::getEmployeeTeamOption();
    }

    public function script()
    {

        return <<<EOT
$('.grid-row-add-team').on('click', function() {
    var id = $(this).data('id');
    swal({
        title: '选择要加入的团队',
        input: 'select',
        inputOptions: {$this->teamOption},
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        inputPlaceholder: '请选择团队',
        inputValidator: function(value)  {
            return new Promise(function(resolve) {
                if(!value){
                    resolve('团队必须要选择！')
                }else{
                    $.ajax({
                        method: 'post',
                        url: '/admin/api/employee-add-team',
                        dataType: "json",
                        data: {
                            _token:LA.token,
                            id:id,
                            employee_team_id: value,
                        },
                        success: function (json) {
                            $.pjax.reload('#pjax-container');
                            if(json.status === 'success'){
                                swal(json.message, '', 'success');
                            }else{
                                swal(json.message, '', 'error');
                            }
                        }
                    });
                }
            })
        },
    })
});
EOT;
    }

    protected function render()
    {
        Admin::script($this->script());

        return "<a href='javascript:void(0);' data-id='{$this->id}' class='grid-row-add-team' style='margin-right: 5px;'>设置团队</a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}