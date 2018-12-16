<?php

namespace App\Admin\Extensions\Templates;

use Encore\Admin\Grid\Tools\AbstractTool;

class MobileImportTemplate extends AbstractTool
{
    public function render()
    {
        return <<<EOT
        <div class="btn-group pull-right" style="margin-right: 10px">
            <a class="btn btn-sm btn-openid"><i class="fa fa-download"></i> 下载模板</a>
            <button type="button" class="btn btn-sm btn-openid dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="/templates/mobile.xlsx" download="号码导入模板.xlsx" target="_blank">号码导入模板</a></li>
            </ul>
        </div>
EOT;
    }
}