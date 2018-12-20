<?php

namespace App\Admin\Controllers\Employee;

use App\Helpers\Api\ApiResponse;
use App\Models\EmployeeMessage;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;

class EmployeeMessageController extends Controller
{
    use HasResourceActions;
    use ApiResponse;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
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
        $grid = new Grid(new EmployeeMessage);

        $grid->id('Id');
        $grid->employee_id('Employee id');
        $grid->biz_type('Biz type');
        $grid->biz_action('Biz action');
        $grid->biz_id('Biz id');
        $grid->title('Title');
        $grid->content('Content');
        $grid->creator_id('Creator id');
        $grid->is_read('Is read');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');
        $grid->deleted_at('Deleted at');

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
        $show = new Show(EmployeeMessage::findOrFail($id));

        $show->id('Id');
        $show->employee_id('Employee id');
        $show->biz_type('Biz type');
        $show->biz_action('Biz action');
        $show->biz_id('Biz id');
        $show->title('Title');
        $show->content('Content');
        $show->creator_id('Creator id');
        $show->is_read('Is read');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        $show->deleted_at('Deleted at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new EmployeeMessage);

        $form->number('employee_id', 'Employee id');
        $form->number('biz_type', 'Biz type');
        $form->number('biz_action', 'Biz action');
        $form->number('biz_id', 'Biz id');
        $form->text('title', 'Title');
        $form->text('content', 'Content');
        $form->number('creator_id', 'Creator id');
        $form->switch('is_read', 'Is read');

        return $form;
    }

    public function apiCount(Request $request)
    {
        $count = EmployeeMessage::where('employee_id',Admin::user()->id)->count();
        $result['count'] = $count;
        $list = EmployeeMessage::where('employee_id',Admin::user()->id)->where('is_read',EmployeeMessage::i);


        return $this->success($result);
    }
}
