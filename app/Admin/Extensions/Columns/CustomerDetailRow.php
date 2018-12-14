<?php

namespace App\Admin\Extensions\Columns;

use Encore\Admin\Admin;

class CustomerDetailRow
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    protected function script()
    {
        return <<<SCRIPT

$('.grid-row-detail').on('click').click(function () {
        var id = $(this).data('id');
        $.ajax({
            method: 'post',
            url: '/admin/api/customer-detail',
            dataType: "json",
            data: {
                _token: LA.token,
                id: id,
            },
            success: function (json) {
                if (json.status === 'success') {
                    swal({
                        title: json.data.html,
                        showCancelButton: true,
                        focusConfirm: false,
                        width:'800px',
                        confirmButtonText:'详情',
                        cancelButtonText: '取消',
                        preConfirm: function (result) {
                            return new Promise(function (resolve, reject) {
                                if(json.data.btn){
                                   swal('您没有权限查看此房源', '', 'error');
                                }else {
                                    swal('您没有权限查看此房源', '', 'error');
                                }
                            });
                        },
                    }).then(function () {
                          
                    })
                } else {
                    swal(json.message, '', 'error');
                }
            }
        });
});


SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());
        return "<a href='javascript:void(0);' data-id='{$this->id}' class='grid-row-detail' style='margin-right: 5px;'>详情</a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}