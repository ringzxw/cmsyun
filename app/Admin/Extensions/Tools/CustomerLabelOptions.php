<?php

namespace App\Admin\Extensions\Tools;

use App\Models\Employee;
use App\Utils\OptionUtil;
use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class CustomerLabelOptions extends AbstractTool
{
    public function script()
    {
        $url = Request::fullUrlWithQuery(['labels' => '_labels_']);

        return <<<EOT

$('input:radio.customer-label').change(function () {

    var url = "$url".replace('_labels_', $(this).val());

    $.pjax({container:'#pjax-container', url: url });

});

EOT;
    }

    public function render()
    {
        Admin::script($this->script());
        $options = OptionUtil::getLabelOption(true);
        return view('admin.tools.customer-label', compact('options'));
    }
}