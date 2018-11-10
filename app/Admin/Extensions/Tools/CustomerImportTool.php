<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Grid\Tools\AbstractTool;

class CustomerImportTool extends AbstractTool
{
    public function render()
    {
        return view('admin.tools.import');
    }
}