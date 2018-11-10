<?php

namespace App\Admin\Extensions\Tools;

use App\Models\Base;
use App\Models\Employee;
use App\Utils\OptionUtil;
use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class CustomerRandom extends AbstractTool
{
    public function script()
    {
        $tend_true = Base::TEND_STATUS_TRUE;
        $tend_false = Base::TEND_STATUS_FALSE;
        $tend_real = Base::TEND_STATUS_REAL;
        return <<<EOT
$('.customer-random').on('click', function() {
    $.ajax({
        method: 'post',
        url: '/admin/api/get-customer-random',
        dataType: "json",
        async: false,
        data: {
            _token:LA.token,
        },
        success: function (json) {
            if(json.status == 'error'){
                swal(json.message, '', 'error');
            }else{
                var customer = json.data;
                var title = customer.name + '：'+customer.mobile;
                var text = customer.message;
                swal({ 
                  title: title,
                  html: text,  
                  type: 'warning',
                  showCancelButton: true, 
                  confirmButtonColor: '#00a65a',
                  cancelButtonColor: '#d33',
                  confirmButtonText: '已接听', 
                  cancelButtonText: '无人接'
                }).then((result) => {
                      if (result.value) {
                            swal({ 
                                  title: "客户意向确认",
                                  text: "点击有意向跳入到跟进页面！", 
                                  type: 'warning',
                                  showCancelButton: true, 
                                  confirmButtonColor: '#00a65a',
                                  cancelButtonColor: '#d33',
                                  confirmButtonText: '有意向', 
                                  cancelButtonText: '无意向'
                            }).then((result) => {
                                  if (result.value) {
                                        tend = {$tend_true} 
                                        $.ajax({
                                            method: 'post',
                                            url: '/admin/api/update-tend-status',
                                            dataType: "json",
                                            data: {
                                                _token:LA.token,
                                                id:customer.id,
                                                tend:tend,
                                            },
                                            success: function (json) {
                                                if(json.status == 'success'){
                                                    window.location.replace("customer-list/"+json.data.customer_id+"/edit");
                                                }else{
                                                    swal(json.message, '', 'error');
                                                }
                                            }
                                        });
                                  } else if (result.dismiss === swal.DismissReason.cancel) {
                                        tend = {$tend_false}
                                        $.ajax({
                                            method: 'post',
                                            url: '/admin/api/update-tend-status',
                                            dataType: "json",
                                            data: {
                                                _token:LA.token,
                                                id:customer.id,
                                                tend:tend,
                                            },
                                            success: function (json) {
                                                if(json.status == 'success'){
                                                    swal('设置成功', '', 'success');
                                                }else{
                                                    swal('设置失败', '', 'error');
                                                }
                                            }
                                        });
                                  }
                            })      
                      } else if (result.dismiss === swal.DismissReason.cancel) {
                            tend = {$tend_real} 
                            $.ajax({
                                method: 'post',
                                url: '/admin/api/update-tend-status',
                                dataType: "json",
                                data: {
                                    _token:LA.token,
                                    id:customer.id,
                                    tend:tend,
                                },
                                success: function (json) {
                                    if(json.status == 'success'){
                                        swal('取消后客户重新回到客户池', '', 'success');
                                    }else{
                                        swal(json.message, '', 'error');
                                    }
                                }
                            }); 
                      }
                })          
            }
        }
    });
});

EOT;
    }

    public function render()
    {
        Admin::script($this->script());
        return view('admin.tools.customer-random');
    }
}