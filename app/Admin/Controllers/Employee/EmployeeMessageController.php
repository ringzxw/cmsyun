<?php

namespace App\Admin\Controllers\Employee;

use App\Admin\Controllers\Controller;
use App\Admin\Controllers\Mobile\MobileImportController;
use App\Admin\Extensions\Details\MobileImportDetail;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\EmployeeMessage;
use App\Models\MobileImport;
use App\Models\Project;
use App\Utils\ConstUtils;
use App\Utils\FormatUtil;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;

class EmployeeMessageController extends Controller
{
    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('个人消息')
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
        //点击详情后变为已读
        $this->getMessageService()->read($id);
        return $content
            ->header('消息详情')
            ->body($this->detail($id));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new EmployeeMessage);
        $grid->model()->where('employee_id',Admin::user()->id);
        $grid->title('标题');
        $grid->content('内容');
        $grid->biz_type('模块');
        $grid->biz_action('操作');
        $grid->creator()->name('发送者')->display(function ($name){
            return $name?:'系统';
        });
        $grid->created_at('接收时间');
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
        $show->title('标题');
        $show->content('内容');
        $show->biz_action('操作');
        $show->creator()->name('发送者')->unescape()->as(function ($name) {
            $name = $name?:'系统';
            return "{$name}";
        });;
        $show->created_at('接收时间');
        $show->biz('业务', function (Show $biz) {
            $model = $biz->getModel();
            if ($model instanceof Employee) {
            }
            if ($model instanceof Project) {
            }
            if ($model instanceof Customer) {
            }
            if ($model instanceof MobileImport) {
                $biz->setResource('/admin/mobile-import');
                $detail = new MobileImportDetail($biz);
                $biz = $detail->render();
            }
            $biz->panel()->tools(function (Show\Tools $tools) {
                $tools->disableEdit();
                $tools->disableDelete();
                $tools->disableList();
            });
        });

        $show->panel()->tools(function (Show\Tools $tools) {
            $tools->disableEdit();
            $tools->disableDelete();
        });
        return $show;
    }

    public function apiIndex(Request $request)
    {
        $employeeMessages = EmployeeMessage::where('employee_id',Admin::user()->id)->where('is_read',ConstUtils::READ_FALSE)->limit(5)->get();
        $list = array();
        foreach ($employeeMessages as $employeeMessage)
        {
            $list[] = $this->transform($employeeMessage);
        }
        $result['list'] = $list;
        $total = EmployeeMessage::where('employee_id',Admin::user()->id)->where('is_read',ConstUtils::READ_FALSE)->count();
        $result['total'] = $total?:'';
        $width = 43;
        if($total >= 10 && $total < 100){
            $width = 50;
        }elseif($total >= 100 && $total < 1000){
            $width = 56;
        }elseif($total >= 1000){
            $width = 62;
        }
        $result['width'] = $width;
        return $this->success($result);
    }

    private function transform(EmployeeMessage $employeeMessage)
    {
        $from = $employeeMessage->creator?$employeeMessage->creator->name:'系统';
        $biz_action_icon = FormatUtil::getBizActionIcon($employeeMessage->biz_action);
        $url = url('admin/employee-message/'.$employeeMessage->id);
        $html = "<li><a href='".$url."'><i class='fa ".$biz_action_icon."'></i>".$from.'：'.$employeeMessage->content."</a></li>";
        return [
            'id'            => $employeeMessage->id,
            'html'          => $html,
        ];
    }
}
