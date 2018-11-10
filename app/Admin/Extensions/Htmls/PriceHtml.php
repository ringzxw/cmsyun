<?php
/**
 * Created by PhpStorm.
 * User: zhuxiaowei
 * Date: 2017/8/8
 * Time: 下午9:40
 */

namespace App\Admin\Extensions\Htmls;

use App\Models\Customer;
use App\Models\CustomerSuccessPrice;
use App\Services\CustomerService;
use Illuminate\Contracts\Support\Renderable;

class PriceHtml implements Renderable
{
    protected $id;
    protected $type;
    //依赖注入
    public function __construct($id,$type){
        $this->id = $id;
        $this->type = $type;
    }

    public function render()
    {
        if($this->id){
            $prices = CustomerSuccessPrice::with(['employee'])->where('customer_success_id',$this->id)->where('type',$this->type)->get();
            return view('admin.success.prices',compact('prices'));
        }
        return '';
    }
}
