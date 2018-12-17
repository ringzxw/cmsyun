<?php

namespace App\Admin\Controllers\Mobile;

use App\Admin\Extensions\Templates\MobileImportTemplate;
use App\Models\Employee;
use App\Models\MobileImport;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\ProjectItem;
use App\Services\Traits\ServicesTrait;
use App\Utils\OptionUtil;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;

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
        Permission::check('mobile-'.__FUNCTION__);
        return $content
            ->header('号码导入日志')
            ->body($this->grid());
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        Permission::check('mobile-'.__FUNCTION__);
        return $content
            ->header('号码导入')
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
        $grid->title('导入标题');
        $grid->employee()->name('所属员工');
        $grid->projectItem()->name('主推产品');
        $grid->labels_html('导入意向')->display(function ($labels_html){
            return $labels_html;
        });
        $grid->status_html('当前状态')->display(function ($status_html){
            return $status_html;
        });
        $grid->error('错误文件')->display(function ($file){
            return $file?'<a href="/upload/'.$file.'" target="_blank">链接</a>':'无';
        });
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
            if (Admin::user()->can('mobile-close')) {
                $actions->append(new CloseCustomerImportRow($actions->getKey(),$is_close));
            }
        });
        $grid->tools(function (Grid\Tools $tools) {
            $tools->append(new MobileImportTemplate());
        });
        $grid->disableExport();
        $grid->disableFilter();
        $grid->disableRowSelector();
        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new MobileImport);
        $form->text('title', '导入标题');
        $folder_name = "files/mobile/import/" . date("Ym", time()) . '/'.date("d", time());
        $filename = time() . '_' . str_random(10) . '.xlsx';
        $form->file('file', '导入文件')->move($folder_name, $filename);
        $form->select('broker_id', '提供者')->options(function ($id) {
            if($id){
                $employee = Employee::find($id);
                if ($employee) {
                    return [$employee->id => $employee->full_name];
                }
            }
        })->ajax('/admin/api/employee');
        $form->select('employee_id', '所属员工')->options(function ($id) {
            if($id){
                $employee = Employee::find($id);
                if ($employee) {
                    return [$employee->id => $employee->full_name];
                }
            }
        })->ajax('/admin/api/employee');
        $form->select('project_item_id', '主推产品')->options(function ($id) {
            if($id){
                $projectItem = ProjectItem::find($id);
                if ($projectItem) {
                    return [$projectItem->id => $projectItem->full_name];
                }
            }
        })->ajax('/admin/api/project-item');
        $form->select('labels', '导入等级')->options(OptionUtil::getLabelOption());
        $form->saving(function ($form) {
            if(!$form->model()->id){
                $form->model()->creator_id = Admin::user()->id;
            }
        });
        return $form;
    }

    /**
     * 关闭该导入批次的客户池客户
     * @param Request $request
     * @return mixed
     */
    public function apiMobileClose(Request $request)
    {
        try{
            $id = $request->get('id');
            if($this->getMobileService(Admin::user())->close($id)){
                return $this->message('操作成功');
            }
            return $this->message('操作失败','error');
        }catch (\Exception $e){
            return $this->message('操作失败','error');
        }
    }
}
