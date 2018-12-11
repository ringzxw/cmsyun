<?php

namespace App\Http\Controllers\Api;

use App\Models\Base;
use App\Models\Customer;
use App\Models\CustomerLog;
use App\Models\Employee;
use App\Models\EmployeeBonus;
use App\Models\EmployeeInvoice;
use App\Models\EmployeeLeave;
use App\Models\EmployeeRemind;
use App\Models\EmployeeTask;
use App\Services\CustomerService;
use App\Services\EmployeeService;
use App\Transformers\EmployeeBonusDetailTransformer;
use App\Transformers\EmployeeBonusTransformer;
use App\Transformers\EmployeeInvoiceDetailTransformer;
use App\Transformers\EmployeeInvoiceTransformer;
use App\Transformers\EmployeeLeaveDetailTransformer;
use App\Transformers\EmployeeLeaveTransformer;
use App\Transformers\EmployeeRemindTransformer;
use App\Transformers\EmployeeTaskDetailTransformer;
use App\Transformers\EmployeeTaskTransformer;
use App\Transformers\EmployeeTransformer;
use App\Utils\CustomerUtil;
use App\Utils\DateUtil;
use App\Utils\OptionUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    /**
     * 获取个人信息
     */
    public function show()
    {
        return $this->response->item($this->user(), new EmployeeTransformer())
            ->setMeta([
                'access_token' => \Auth::guard('api')->fromUser($this->user()),
                'token_type' => 'Bearer',
                'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
            ]);
    }

    /**
     * 修改个人信息
     */
    public function update(Request $request)
    {
        return $this->response->error('输入有误');
    }

    /**
     * 修改登录密码
     */
    public function changePassword(Request $request)
    {
        if($request->password && $request->password == $request->password_confirmation){
            $this->user()->password = bcrypt($request->password);
            $this->user()->save();
            return $this->response->item($this->user(), new EmployeeTransformer())->setStatusCode(201);
        }
        return $this->response->error('密码输入有误');
    }
}
