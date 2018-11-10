<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class CustomerReset extends AbstractTool
{
    public function script()
    {

        $requests = Request::all();
        Cache::put('CustomerReset',$requests,60);
        $count = $this->grid->model()->eloquent()->total();
        return <<<EOT
$('.customer-reset').on('click', function() {
    swal({
      title: "确认重置?",
      text: "总共有{$count}个客户需要重置", 
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
                    url: '/admin/api/reset',
                    dataType: "json",
                    data: {
                        _token:LA.token,
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
        return view('admin.tools.customer-reset');
    }
}