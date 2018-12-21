<?php
/**
 * Created by PhpStorm.
 * User: zhuxiaowei
 * Date: 2017/8/8
 * Time: 下午9:40
 */

namespace App\Admin\Extensions\Htmls;

use App\Models\Customer;
use Illuminate\Contracts\Support\Renderable;

class CustomerDetailHtml implements Renderable
{
    protected $id;
    //依赖注入
    public function __construct($id){
        $this->id = $id;
    }

    public function render()
    {
        if($this->id){
            $customer = Customer::findOrFail($this->id);
            return view('admin.customer.detail',compact('customer'));
        }
        return '';
    }
}
