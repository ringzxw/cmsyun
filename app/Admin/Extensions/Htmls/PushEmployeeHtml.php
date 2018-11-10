<?php

namespace App\Admin\Extensions\Htmls;

use App\Models\Employee;
use Encore\Admin\Admin;
use Illuminate\Contracts\Support\Renderable;

class PushEmployeeHtml implements Renderable
{
    protected $employee;
    protected $submit;
    protected $customer_success_id;
    public function __construct($employee_id,$customer_success_id)
    {
        if($employee_id){
            $this->employee = Employee::find($employee_id);
        }
        $this->submit = \Encore\Admin\Facades\Admin::user();
        $this->customer_success_id = $customer_success_id;
    }

    public function script()
    {
        return <<<EOT
$('.push-employee').on('click', function() {
    swal({
      title: "员工：{$this->employee->name}，通知审核提成信息！",
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
                    url: '/admin/api/create-employee-bonus',
                    dataType: "json",
                    data: {
                        _token:LA.token,
                        submit_id:{$this->submit->id},
                        employee_id:{$this->employee->id},
                        customer_success_id:{$this->customer_success_id},
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

    public function render()
    {
        Admin::script($this->script());
        return '<div class="btn-group pull-right push-employee" style="margin-right: 10px"><a href="" class="btn btn-sm btn-default"><i class="fa fa-floppy-o"></i>&nbsp;通知员工审核</a></div>';
    }
}