<?php

namespace App\Admin\Extensions\Htmls;

use App\Models\Base;
use App\Models\Employee;
use App\Utils\OptionUtil;
use Encore\Admin\Admin;
use Illuminate\Contracts\Support\Renderable;

class PushComeHtml implements Renderable
{
    protected $customer_success_id;
    protected $submit;
    public function __construct($customer_success_id)
    {
        $this->customer_success_id = $customer_success_id;
        $this->submit = \Encore\Admin\Facades\Admin::user();
    }

    public function script()
    {
        $employeeOption = OptionUtil::getEmployeeRoleOption([Base::EMPLOYEE_SALES_DIRECTOR,Base::EMPLOYEE_SALES_MANAGER,Base::EMPLOYEE_SALES_EXECUTIVE]);
        return <<<EOT
$('.push-come').on('click', function() {
    swal({
        title: '选择审核人',
        input: 'select',
        inputOptions: {$employeeOption},
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        inputPlaceholder: '请选择审核人',
        inputValidator: function(value)  {
            return new Promise(function(resolve) {
                if(!value){
                    resolve('审核人必须要选择！')
                }else{
                    $.ajax({
                        method: 'post',
                        url: '/admin/api/create-come-bonus',
                        dataType: "json",
                        data: {
                            _token:LA.token,
                            submit_id:{$this->submit->id},
                            customer_success_id: {$this->customer_success_id},
                            employee_id: value,
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

    public function render()
    {
        Admin::script($this->script());
        return '<div class="btn-group pull-right push-come" style="margin-right: 10px"><a href="" class="btn btn-sm btn-default"><i class="fa fa-floppy-o"></i>&nbsp;通知案场审核</a></div>';
    }
}