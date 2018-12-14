<?php

namespace App\Admin\Extensions\Columns;

class UrlRow
{
    protected $url;
    protected $name;

    public function __construct($url,$name)
    {
        $this->url  = $url;
        $this->name = $name;
    }

    protected function render()
    {
        return "<a href='{$this->url}' style='margin-right: 5px;'>{$this->name}</a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}