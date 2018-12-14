<?php

namespace App\Admin\Extensions\Columns;

use Encore\Admin\Admin;

class DeleteRow
{
    protected $id;
    protected $table;
    protected $name;

    public function __construct($id,$table,$name = null)
    {
        $this->id = $id;
        $this->table = $table;
        if($name){
            $this->name = $name;
        }else{
            $this->name = '删除';
        }

    }

    protected function script()
    {
        return <<<SCRIPT

$('.grid-row-delete').unbind('click').click(function() {

    var id = $(this).data('id');
    var table = $(this).data('table');
    swal({ 
      title: '确认此操作？',
      text:"从列表中移除，点确定后删除！", 
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
                    url: '/admin/api/del-model',
                    dataType: "json",
                    data: {
                        _token:LA.token,
                        id: id,
                        table: table,
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

        return "<a href='javascript:void(0);' data-id='{$this->id}' data-table='{$this->table}' class='grid-row-delete' style='margin-right: 5px;'>{$this->name}</a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}