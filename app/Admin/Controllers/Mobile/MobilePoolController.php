<?php

namespace App\Admin\Controllers\Mobile;

use App\Admin\Extensions\Importers\MobileImporter;
use App\Models\MobilePool;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

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
        return $content
            ->header('号码池')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
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
            if (Admin::user()->can('employee-index')) {
                $tools->append(new MobileImporter());
            }
            if (Admin::user()->can('employee-create')) {
            }
        });
        $grid->disableExport();
        $grid->disableRowSelector();
        $grid->disableCreateButton();
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(MobilePool::findOrFail($id));



        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new MobilePool);



        return $form;
    }
}
