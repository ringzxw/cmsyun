<?php

namespace App\Admin\Extensions\Importers;

use Encore\Admin\Grid\Tools\AbstractTool;

class MobileImporter extends AbstractTool
{
    public function render()
    {
        return view('admin.mobile.import');
    }
}