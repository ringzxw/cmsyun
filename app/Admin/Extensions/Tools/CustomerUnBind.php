<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class CustomerUnBind extends AbstractTool
{

    protected $employee_id;

    public function __construct($employee_id)
    {
        $this->employee_id = $employee_id;
    }

    public function script()
    {
        $requests = Request::all();
        $keyword = '""';
        foreach ($requests as $k=>$v)
        {
            if(is_md5($k)){
                $keyword = $v?:'""';
                break;
            }
        }
        $status = Request::get('status')?Request::get('status'):'""';
        $labels = Request::get('labels')?Request::get('labels'):'""';
        $subject_tag = Request::get('subject_tag')?'"'.implode(",", Request::get('subject_tag')).'"':'""';
        $customer_tag = Request::get('customer_tag')?'"'.implode(",", Request::get('customer_tag')).'"':'""';
        $count = $this->grid->model()->eloquent()->total();
        return <<<EOT
$('.customer-un-bind').on('click', function() {
    swal({
      title: "确认解除绑定?",
      text: "总共有{$count}个客户需要解绑", 
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
                    url: '/admin/api/un-bind-all',
                    dataType: "json",
                    data: {
                        _token:LA.token,
                        employee_id:{$this->employee_id},
                        keyword:{$keyword},
                        status:{$status},
                        labels:{$labels},
                        subject_tag:{$subject_tag},
                        customer_tag:{$customer_tag},
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
        return view('admin.tools.customer-unbind');
    }
}