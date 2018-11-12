<?php

namespace App\Admin\Controllers\Customer;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Utils\FormatUtil;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CustomerController extends Controller
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
    public function show($id, Content $content)
    {
        Permission::check('customer-'.__FUNCTION__);
        return $content
            ->header('客户详情')
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
        $grid->id('ID');
        $grid->name('姓名');
        $grid->mobile('手机号');
        $grid->labels('意向')->display(function ($labels){
            return FormatUtil::getLabelHtml($labels);
        });
        $grid->status('客户状态')->display(function ($status){
            return FormatUtil::getCustomerStatusHtml($status);
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
        //保存前回调
        $form->saving(function (Form $form) {
            if(!$form->model()->create_user_id){
                $form->model()->create_user_id = Admin::user()->id;
            }
        });
        return $form;
    }
}
