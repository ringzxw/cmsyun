<?php

namespace App\Admin\Controllers\Employee;

use App\Admin\Extensions\Column\AddTeamManagerRow;
use App\Admin\Extensions\Column\AddTeamRow;
use App\Admin\Extensions\Column\DeleteRow;
use App\Admin\Extensions\Column\RemoveTeamRow;
use App\Admin\Extensions\Column\UrlRow;
use App\Helpers\Api\ApiResponse;
use App\Models\Employee;
use App\Models\EmployeeTeam;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;

class EmployeeTeamController extends CommonEmployeeController
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
        Permission::check('team-'.__FUNCTION__);
        return $content
            ->header('团队列表')
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
        Permission::check('team-'.__FUNCTION__);
        return $content
            ->header('团队详情')
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
        Permission::check('team-'.__FUNCTION__);
        return $content
            ->header('团队编辑')
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
        Permission::check('team-'.__FUNCTION__);
        return $content
            ->header('团队创建')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new EmployeeTeam);
        $grid->id('Id');
        $grid->name('团队名称');
        $grid->employees('团队成员')->display(function ($employees){
            $count = count($employees);
            if($count > 0){
                $url = url('admin/team/'.$this->id.'/employee-list');
                return '<a style="margin-left: 10px;" href="'.$url.'">'.$count.'人</a>';
            }
            return '';
        });
        $grid->manager()->name('负责人');
        $grid->created_at('创建时间');
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
            // 添加操作
            if (Admin::user()->can('team-show')) {
                $actions->append(new UrlRow(url('admin/team/'.$actions->getKey().'/employee-list'),'详情'));
            }
            if (Admin::user()->can('team-edit')) {
                $actions->append(new UrlRow(url('admin/team/'.$actions->getKey().'/edit'),'编辑'));
            }
            if (Admin::user()->can('team-delete')) {
                $actions->append(new DeleteRow($actions->getKey(),'employee_teams'));//删除
            }
        });
        $grid->disableExport();
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
        $show = new Show(EmployeeTeam::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
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
        $form = new Form(new EmployeeTeam);
        $form->text('name', '团队名称')->rules(function($form) {
            // 如果 $form->model()->id 不为空，代表是编辑操作
            if ($id = $form->model()->id) {
                return 'required|unique:employee_teams,name,'.$id.',id';
            } else {
                return 'required|unique:employee_teams';
            }
        });
        return $form;
    }

    /**
     * Index interface.
     *
     * @return Content
     */
    public function employeeList($team_id)
    {
        $employeeTeam = EmployeeTeam::query()->findOrFail($team_id);
        return Admin::content(function (Content $content) use($employeeTeam){
            $content->header($employeeTeam->name.'--'.'成员列表');
            $content->body($this->employeeListGrid($employeeTeam->id));
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function employeeListGrid($id)
    {
        return Admin::grid(Employee::class, function (Grid $grid) use($id){
            $grid->model()->where('employee_team_id',$id);
            $this->defaultGrid($grid);
            $grid->employeeTeam()->manager_id('管理员')->display(function ($manager_id){
                if($manager_id == $this->id){
                    return '是';
                }
                return '否';
            });
            $grid->disableCreateButton();
            $grid->actions(function (Grid\Displayers\Actions $actions) use($id){
                $actions->disableDelete();
                $actions->disableEdit();
                $actions->disableView();
                /** @var Employee $employee */
                $employee = $actions->row;
                if ($employee->employee_team_id == null && Admin::user()->can('employee-team')) {
                    $actions->append(new AddTeamRow($actions->getKey()));
                }
                // 添加操作
                if ($employee->employee_team_id == $id && Admin::user()->can('team-edit')) {
                    $actions->append(new AddTeamManagerRow($actions->getKey(),$id));
                }

                if ($employee->employee_team_id == $id && Admin::user()->can('employee-team')) {
                    $actions->append(new RemoveTeamRow($actions->getKey(),$id));
                }
            });
        });
    }

    /**
     * 设置团队管理员
     * @param Request $request
     * @return mixed
     */
    public function apiSetting(Request $request)
    {
        try{
            $employee_id = $request->get('employee_id');
            $employee_team_id = $request->get('employee_team_id');
            $employeeTeam = EmployeeTeam::query()->findOrFail($employee_team_id);
            if(!$employeeTeam){
                return $this->message('团队未找到','error');
            }
            $employeeTeam->manager_id = $employee_id;
            $employeeTeam->save();
            return $this->message('设置成功');
        }catch (\Exception $e){
            return $this->message('系统错误','error');
        }
    }


    /**
     * 根据ID从团队移除
     * @param Request $request
     * @return mixed
     */
    public function apiRemove(Request $request)
    {
        try{
            $employee_ids = $request->get('employee_ids');
            $employee_team_id = $request->get('employee_team_id');
            $row = Employee::query()->whereIn('id',$employee_ids)->where('employee_team_id',$employee_team_id)->update(['employee_team_id'=>null]);
            if($row > 0){
                $employeeTeam = EmployeeTeam::query()->find($employee_team_id);
                if($employeeTeam){
                    if(in_array($employeeTeam->manager_id,$employee_ids)){
                        $employeeTeam->manager_id = null;
                        $employeeTeam->save();
                    }
                }
                return $this->message('移除成功');
            }
            return $this->message('移除失败','error');
        }catch (\Exception $e){
            return $this->message('系统错误','error');
        }
    }
}
