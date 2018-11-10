<?php

namespace App\Admin\Extensions\Tools;

use App\Models\Employee;
use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class EmployeeOptions extends AbstractTool
{
    public function script()
    {
        $url = Request::fullUrlWithQuery(['gender' => '_gender_']);

        return <<<EOT

$('input:radio.user-gender').change(function () {

    var url = "$url".replace('_gender_', $(this).val());

    $.pjax({container:'#pjax-container', url: url });

});

EOT;
    }

    public function render()
    {
        Admin::script($this->script());
        $options = Employee::all()->pluck('name', 'id');
        return view('admin.tools.employee', compact('options'));
    }
}