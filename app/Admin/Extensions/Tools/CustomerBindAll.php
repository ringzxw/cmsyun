<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class CustomerBindAll extends AbstractTool
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
                $keyword = $v?$v:'""';
                break;
            }
        }
        $channel = Request::get('channel')?Request::get('channel'):'""';
        $created_at = Request::get('created_at')?json_encode(Request::get('created_at')):'""';
        $labels = Request::get('labels')?Request::get('labels'):'""';
        $subject_id = Request::get('subject_id')?'"'.implode(",", Request::get('subject_id')).'"':'""';
        $subject_tag = Request::get('subject_tag')?'"'.implode(",", Request::get('subject_tag')).'"':'""';
        $count = $this->grid->model()->eloquent()->total();
        return <<<EOT
$('.customer-reset').on('click', function() {
    swal({
      title: "确认绑定?",
      text: "总共有{$count}个客户需要绑定", 
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
                    url: '/admin/api/bind-all',
                    dataType: "json",
                    data: {
                        _token:LA.token,
                        employee_id:{$this->employee_id},
                        keyword:{$keyword},
                        labels:{$labels},
                        subject_tag:{$subject_tag},
                        created_at:{$created_at},
                        subject_id:{$subject_id},
                        channel:{$channel},
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
        return view('admin.tools.customer-bind-all');
    }
}