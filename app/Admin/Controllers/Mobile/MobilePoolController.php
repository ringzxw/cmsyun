<?php

namespace App\Admin\Controllers\Mobile;

use App\Admin\Extensions\Importers\MobileImporter;
use App\Models\MobilePool;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class MobilePoolController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        Permission::check('mobile-'.__FUNCTION__);
        return $content
            ->header('号码池')
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MobilePool);
        $grid->model()->withOnly('creator', ['name']);
        $grid->model()->with('import');
        $grid->id('ID');
        $grid->mobile('手机号');
        $grid->name('姓名');
        $grid->labels_html('导入意向')->display(function ($labels_html){
            return $labels_html;
        });
        $grid->status_html('池中状态')->display(function ($status_html){
            return $status_html;
        });
        $grid->column('提供人')->display(function (){
            return $this->creator?$this->creator['name']:'';
        });
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
        });
        $grid->tools(function (Grid\Tools $tools) {
            if (Admin::user()->can('mobile-create')) {
                $tools->append(new MobileImporter());
            }
        });
        $grid->disableExport();
        $grid->disableRowSelector();
        $grid->disableCreateButton();
        return $grid;
    }
}
