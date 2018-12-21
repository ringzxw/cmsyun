<?php
/**
 * Created by PhpStorm.
 * User: zhuxiaowei
 * Date: 2017/8/8
 * Time: 下午9:40
 */

namespace App\Admin\Extensions\Details;

use Encore\Admin\Show;

class MobileImportDetail
{
    protected $show;
    //依赖注入
    public function __construct(Show $show){
        $show->title('导入标题');
        $show->employee()->name('所属员工');
        $show->projectItem()->name('主推产品');
        $this->show = $show;
    }

    public function render()
    {
        return $this->show;
    }
}
