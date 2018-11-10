<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class ProjectSalesAnalyzeExportButton extends AbstractTool
{
    public function script()
    {
        $projectId = Request::get('project_id') ?: 'false';
        $startTime = Request::get('start_time');
        $startTimeStart = 'false';
        $startTimeEnd = 'false';
        if($startTime){
            $startTimeStart = $startTime['start']?strtotime($startTime['start']):'false';
            $startTimeEnd = $startTime['end']?strtotime($startTime['end']):'false';
        }
        $count = $this->grid->model()->eloquent()->total();
        $title = '确认导出?';
        if($count>5000){
            $title = '数据量过大，有可能会失败！';
        }
        return <<<EOT
$('.export-button').on('click', function() {
    swal({
      title: "{$title}",
      text: "总共有{$count}条记录需要导出", 
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      confirmButtonText: "确认",
      closeOnConfirm: false,
      cancelButtonText: "取消",
      preConfirm: function(result) {
            return new Promise(function(resolve, reject) {
                window.open('/admin/report/project-sales-analyze/export-report/'+$projectId+'/'+$startTimeStart+'/'+$startTimeEnd);
                swal('导出成功', '', 'success');
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
        return view('admin.tools.export-button');
    }
}