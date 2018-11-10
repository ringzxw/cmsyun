<?php

namespace App\Admin\Extensions\Tools;

use App\Utils\OptionUtil;
use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class CustomerStatusOptions extends AbstractTool
{
    public function script()
    {
        $url = Request::fullUrlWithQuery(['status' => '_status_']);

        return <<<EOT

$('input:radio.customer-status').change(function () {

    var url = "$url".replace('_status_', $(this).val());

    $.pjax({container:'#pjax-container', url: url });

});

EOT;
    }

    public function render()
    {
        Admin::script($this->script());
        $employee = \Encore\Admin\Facades\Admin::user();
        $options = OptionUtil::getCustomerStatusOption($employee);
        return view('admin.tools.customer-status', compact('options'));
    }
}