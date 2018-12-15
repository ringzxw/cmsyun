<?php

namespace App\Admin\Controllers\Customer;

use App\Admin\Extensions\Columns\CustomerDetailRow;
use App\Admin\Extensions\Columns\DeleteRow;
use App\Admin\Extensions\Columns\UrlRow;
use App\Admin\Extensions\Htmls\CustomerDetailHtml;
use App\Helpers\Api\ApiResponse;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Utils\FormatUtil;
use App\Utils\OptionUtil;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;

class CustomerController extends Controller
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
        Permission::check('customer-'.__FUNCTION__);
        return $content
            ->header('客户列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id)
    {
        Permission::check('customer-'.__FUNCTION__);
        return Admin::content(function (Content $content) use ($id){
            $html = new CustomerDetailHtml($id);
            $content->body($html);
        });
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
        Permission::check('customer-'.__FUNCTION__);
        return $content
            ->header('客户编辑')
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
        Permission::check('customer-'.__FUNCTION__);
        return $content
            ->header('客户新建')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Customer);
        $grid->model()->withOnly('creator', ['name']);
        $grid->id('ID');
        $grid->name('姓名');
        $grid->mobile('手机号');
        $grid->labels_html('意向')->display(function ($labels_html){
            return $labels_html;
        });
        $grid->status_html('状态')->display(function ($status_html){
            return $status_html;
        });
        $grid->column('创建人')->display(function (){
            return $this->creator?$this->creator['name']:'';
        });
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
            // 添加操作
            if (Admin::user()->can('customer-show')) {
                $actions->append(new CustomerDetailRow($actions->getKey()));//详情
            }
            if (Admin::user()->can('customer-edit')) {
                $actions->append(new UrlRow(url('admin/customer/'.$actions->getKey().'/edit'),'编辑'));
            }
            if (Admin::user()->can('customer-follow')) {
            }
            if (Admin::user()->can('customer-delete')) {
                $actions->append(new DeleteRow($actions->getKey(),'customers'));//删除
            }
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
        $show = new Show(Customer::findOrFail($id));
        $show->id('ID');
        $show->name('姓名');
        $show->mobile('手机号');
        $show->labels('意向')->display(function ($labels){
            return FormatUtil::getLabelHtml($labels);
        });
        $show->status('客户状态')->display(function ($status){
            return FormatUtil::getCustomerStatusHtml($status);
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
        $form = new Form(new Customer);
        $form->text('name', '姓名');
        $form->mobile('mobile', '手机号')->rules(function($form) {
            // 如果 $form->model()->id 不为空，代表是编辑操作
            if ($id = $form->model()->id) {
                return 'required|unique:customers,mobile,'.$id.',id';
            } else {
                return 'required|unique:customers';
            }
        });
        $form->select('channel','客户来源')->options(OptionUtil::getChannelOption())->rules('required');
        if (Admin::user()->can('customer-allot')) {
            $form->select('employee_id', '所属员工')->options(function ($id) {
                $employee = Employee::find($id);
                if ($employee) {
                    return [$employee->id => $employee->full_name];
                }
            })->ajax('/admin/api/employee');
        }else{
            $form->hidden('employee_id')->default(Admin::user()->id);
        }
        //保存前回调
        $form->saving(function (Form $form) {
            if(!$form->model()->create_user_id){
                $form->model()->create_user_id = Admin::user()->id;
            }
        });
        return $form;
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function apiDetail(Request $request)
    {
        try{
            $id = $request->get('id');
            $customer = Customer::findOrFail($id);
            $customer->html = clearHtml(response(view('admin.customer.detail-pop',compact('customer')))->getContent());
            if($customer){
                return $this->success($customer);
            }
            return $this->message('客户错误','error');
        }catch (\Exception $e){
            return $this->message($e->getMessage(),'error');
        }
    }
}
