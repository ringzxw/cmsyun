<?php

namespace App\Admin\Extensions\Column;

use Encore\Admin\Admin;

class SaveLogRow
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    protected function script($html)
    {
        return <<<SCRIPT

$('.grid-row-save-log').unbind('click').click(function() {
      swal({
          text: '参与众筹',
          html: '{$html}',
          buttons: ['取消', '确定']
      }).then(function (ret) {
          
      });
});


SCRIPT;
    }

    protected function render()
    {

        $html = response(view('admin.customer.save-log'))->getContent();
        Admin::script($this->script($html));
        return "<a href='javascript:void(0);' data-id='{$this->id}' class='grid-row-save-log' style='margin-right: 5px;'>跟进</a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}