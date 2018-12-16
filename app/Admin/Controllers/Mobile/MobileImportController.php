<?php

namespace App\Admin\Controllers\Mobile;

use App\Admin\Extensions\Templates\MobileImportTemplate;
use App\Models\MobileImport;
use App\Http\Controllers\Controller;
use App\Services\Traits\ServicesTrait;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Redis;

class MobileImportController extends Controller
{
    use HasResourceActions;
    use ServicesTrait;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
//        $key = 'pools:mobile';
//        $nums = Redis::sunion($key);
//        $nums = Redis::sismember($key,'18130066204');
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
        $grid = new Grid(new MobileImport);
        $grid->id('ID')->sortable();
        $grid->title('Title');
        $grid->employee()->name('所属员工');
        $grid->projectItem()->name('主推产品');
        $grid->labels_html('导入意向')->display(function ($labels_html){
            return $labels_html;
        });
        $grid->status_html('池中状态')->display(function ($status_html){
            return $status_html;
        });
        $grid->import_status('Import status');
        $grid->file('File');
        $grid->status('Status');
        $grid->tools(function (Grid\Tools $tools) {
            $tools->append(new MobileImportTemplate());
        });
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
        $show = new Show(MobileImport::findOrFail($id));

        $show->id('Id');
        $show->type('Type');
        $show->employee_id('Employee id');
        $show->project_item_id('Project item id');
        $show->labels('Labels');
        $show->title('Title');
        $show->file('File');
        $show->success('Success');
        $show->import_status('Import status');
        $show->status('Status');
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
        $form = new Form(new MobileImport);
        $form->text('title', 'Title');
        $folder_name = "files/mobile/import/" . date("Ym", time()) . '/'.date("d", time());
        $filename = time() . '_' . str_random(10) . '.xlsx';
        $form->file('file', 'File')->move($folder_name, $filename);
        $form->saving(function ($form) {
            if(!$form->model()->id){
                $form->model()->creator_id = Admin::user()->id;
            }
        });
        return $form;
    }
}