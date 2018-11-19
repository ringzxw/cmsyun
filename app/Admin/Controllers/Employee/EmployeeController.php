<?php

namespace App\Admin\Controllers\Employee;

use App\Admin\Extensions\Column\AddTeamRow;
use App\Admin\Extensions\Column\DeleteRow;
use App\Admin\Extensions\Column\UrlRow;
use App\Admin\Extensions\Expoters\EmployeeExporter;
use App\Exports\EmployeeExport;
use App\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends CommonEmployeeController
{
    use HasResourceActions;
    use ApiResponse;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        Permission::check('employee-'.__FUNCTION__);
        return $content
            ->header('员工列表')
            ->body($this->grid()->render());
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     *
     * @return Content
     */
    public function show($id, Content $content)
    {
        Permission::check('employee-'.__FUNCTION__);
        return $content
            ->header('员工详情')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param $id
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        Permission::check('employee-'.__FUNCTION__);
        return $content
            ->header('员工编辑')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create(Content $content)
    {
        Permission::check('employee-'.__FUNCTION__);
        return $content
            ->header('员工新建')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $userModel = config('admin.database.users_model');
        $grid = new Grid(new $userModel());
        $this->defaultGrid($grid);
        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->column(1/3, function ($filter) {
                $filter->where(function ($query) {
                    $query->where('name', 'like', "%{$this->input}%")
                        ->orWhere('mobile', 'like', "%{$this->input}%")
                        ->orWhere('username', 'like', "%{$this->input}%");
                },'关键词')->placeholder('用户名/姓名/手机号');
            });
        });
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
            // 添加操作
            if (Admin::user()->can('employee-edit')) {
                $actions->append(new UrlRow(url('admin/employee/'.$actions->getKey().'/edit'),'编辑'));
            }
            if (Admin::user()->can('employee-team')) {
                $actions->append(new AddTeamRow($actions->getKey()));
            }
            if (Admin::user()->can('employee-permission')) {
                $actions->append(new UrlRow(url('admin/employee/'.$actions->getKey().'/permission'),'权限'));
            }
            if (Admin::user()->can('employee-delete')) {
                $actions->append(new DeleteRow($actions->getKey(),'employees'));//删除
            }
        });
        $grid->tools(function (Grid\Tools $tools) {
            $tools->append(new EmployeeExporter());
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        $userModel = config('admin.database.users_model');

        $show = new Show($userModel::findOrFail($id));

        $show->id('ID');
        $show->username(trans('admin.username'));
        $show->name(trans('admin.name'));
        $show->roles(trans('admin.roles'))->as(function ($roles) {
            return $roles->pluck('name');
        })->label();
        $show->permissions(trans('admin.permissions'))->as(function ($permission) {
            return $permission->pluck('name');
        })->label();
        $show->created_at(trans('admin.created_at'));
        $show->updated_at(trans('admin.updated_at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        $userModel = config('admin.database.users_model');
        $permissionModel = config('admin.database.permissions_model');
        $roleModel = config('admin.database.roles_model');

        $form = new Form(new $userModel());

        $form->display('id', 'ID');




        $form->text('username', '账号')->rules(function($form) {
            // 如果 $form->model()->id 不为空，代表是编辑操作
            if ($id = $form->model()->id) {
                return 'required|unique:employees,username,'.$id.',id';
            } else {
                return 'required|unique:employees';
            }
        });

        $form->text('name', '姓名')->rules(function($form) {
            // 如果 $form->model()->id 不为空，代表是编辑操作
            if ($id = $form->model()->id) {
                return 'required|unique:employees,name,'.$id.',id';
            } else {
                return 'required|unique:employees';
            }
        });

        $form->mobile('mobile', '联系方式')->rules(function($form) {
            // 如果 $form->model()->id 不为空，代表是编辑操作
            if ($id = $form->model()->id) {
                return 'required|unique:employees,mobile,'.$id.',id';
            } else {
                return 'required|unique:employees';
            }
        });

        $form->email('email', '邮箱')->rules(function($form) {
            // 如果 $form->model()->id 不为空，代表是编辑操作
            if ($id = $form->model()->id) {
                return 'required|unique:employees,email,'.$id.',id';
            } else {
                return 'required|unique:employees';
            }
        });

        $form->image('avatar', trans('admin.avatar'));
        $form->password('password', trans('admin.password'))->rules('required|confirmed');
        $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
            ->default(function ($form) {
                return $form->model()->password;
            });

        $form->ignore(['password_confirmation']);

        $form->multipleSelect('roles', trans('admin.roles'))->options($roleModel::all()->pluck('name', 'id'));
        $form->multipleSelect('permissions', trans('admin.permissions'))->options($permissionModel::all()->pluck('name', 'id'));

        $form->display('created_at', trans('admin.created_at'));
        $form->display('updated_at', trans('admin.updated_at'));

        $form->saving(function (Form $form) {
            if ($form->password && $form->model()->password != $form->password) {
                $form->password = bcrypt($form->password);
            }
        });

        return $form;
    }


    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function apiEmployeeExport()
    {
        return Excel::download(new EmployeeExport(), 'employee.xlsx');
    }


    /**
     * @param Request $request
     * @param Employee $employee
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function apiIndex(Request $request, Employee $employee)
    {
        $search = $request->input('q');
        $query = $employee::query();
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%'.$search.'%')
                ->orWhere('mobile', 'like', '%' . $search . '%')
                ->orWhere('username', 'like', '%' . $search . '%')
                ->orWhereHas('roles', function ($q) use ($search){
                    $q->where('name', 'like', '%'.$search.'%');
                });
        });
        $result = $query->paginate();
        // 把查询出来的结果重新组装成 Laravel-Admin 需要的格式
        $result->setCollection($result->getCollection()->map(function (Employee $employee) {
            return ['id' => $employee->id, 'text' => $employee->full_name];
        }));
        return $result;
    }

    /**
     * @param Request $request
     * @param Employee $employee
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function apiAddTeam(Request $request)
    {
        try{
            $id = $request->input('id');
            $employee_team_id = $request->input('employee_team_id');
            $employee = Employee::findOrFail($id);
            $employee->employee_team_id  = $employee_team_id;
            $employee->save();
            return $this->success($employee);
        }catch (\Exception $e){
            return $this->message($e->getMessage(),'error');
        }
    }
}
