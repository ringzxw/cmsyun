<?php
/**
 * Created by PhpStorm.
 * User: zhuxiaowei
 * Date: 2017/8/8
 * Time: 下午9:40
 */

namespace App\Admin\Extensions\Tools;

use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Contracts\Support\Renderable;

class LogHtml implements Renderable
{
    protected $id;
    //依赖注入
    public function __construct($id){
        $this->id = $id;
    }

    public function render()
    {
        if($this->id){
            $customer = Customer::with('customerLogs')->with('employee')->find($this->id);
            $customerLogs = CustomerService::apiCustomerLogs($customer);
            return view('admin.tools.customer-log',compact('customerLogs'));
        }
        return '';
    }
}
