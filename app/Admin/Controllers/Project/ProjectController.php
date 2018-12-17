<?php

namespace App\Admin\Controllers\Project;

use App\Admin\Extensions\Columns\DeleteRow;
use App\Admin\Extensions\Columns\UrlRow;
use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Models\ProjectItem;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;

class ProjectController extends Controller
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
        Permission::check('project-'.__FUNCTION__);
        return $content
            ->header('项目列表')
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
        Permission::check('project-'.__FUNCTION__);
        return $content
            ->header('项目详情')
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
        Permission::check('project-'.__FUNCTION__);
        return $content
            ->header('项目编辑')
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
        Permission::check('project-'.__FUNCTION__);
        return $content
            ->header('项目新增')
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
        $grid = new Grid(new Project);
        $grid->id('Id');
        $grid->name('名称');
        $grid->sort('排序')->sortable();
        $grid->address('地址');
        $grid->items('产品数')->display(function ($items) {
            $count = count($items);
            return "<span class='label label-warning'>{$count}</span>";
        });
        $grid->created_at('创建时间')->sortable();
        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->column(1/4, function ($filter) {
                $filter->where(function ($query) {
                    $query->where('name', 'like', "%{$this->input}%")
                        ->orWhere('address', 'like', "%{$this->input}%");
                },'关键词','名称/地址');
            });
        });
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
            // 添加操作
            if (Admin::user()->can('project-show')) {
                $actions->append(new UrlRow(url('admin/project/'.$actions->getKey()),'详情'));
            }
            if (Admin::user()->can('project-edit')) {
                $actions->append(new UrlRow(url('admin/project/'.$actions->getKey().'/edit'),'编辑'));
            }
            if (Admin::user()->can('project-delete')) {
                $actions->append(new DeleteRow($actions->getKey(),'projects'));//删除
            }
        });
        $grid->disableRowSelector();
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
        $show = new Show(Project::findOrFail($id));
        $show->id('Id');
        $show->name('名称');
        $show->sort('排序');
        $show->address('地址');
        $show->panel()
            ->tools(function ($tools) {
                if (!Admin::user()->can('project-edit')) {
                    $tools->disableEdit();
                }
                if (!Admin::user()->can('project-delete')) {
                    $tools->disableDelete();
                }
            });
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Project);
        $form->checkbox('dd','测试')->options([1 => 'foo', 2 => 'bar', 'val' => 'Option name']);
        $form->text('name', '项目名称')->rules('required');
        $form->text('address', '项目地址');
        $form->hasMany('items', '产品列表', function (Form\NestedForm $form) {
            $form->text('name', '产品名称')->rules('required');
        });
        return $form;
    }

    /**
     * @param Request $request
     * @param ProjectItem $projectItem
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function apiIndex(Request $request, ProjectItem $projectItem)
    {
        $search = $request->input('q');
        $query = $projectItem::query();
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%'.$search.'%')
                ->orWhereHas('project', function ($q) use ($search){
                    $q->where('name', 'like', '%'.$search.'%');
                });
        });
        $result = $query->paginate();
        // 把查询出来的结果重新组装成 Laravel-Admin 需要的格式
        $result->setCollection($result->getCollection()->map(function (ProjectItem $projectItem) {
            return ['id' => $projectItem->id, 'text' => $projectItem->full_name];
        }));
        return $result;
    }
}
