<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\PermissionException;
use App\Traits\ServicesTrait;
use App\Transformers\CustomerListTransformer;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    use ServicesTrait;

    /**
     * 客户列表
     * @param Request $request
     * @return \Dingo\Api\Http\Response|void
     */
    public function list(Request $request)
    {
        try{
            $query = $this->getQueryService($this->user())->getCustomerListQuery($request);
            $customers = $query->paginate(20);
        }catch (PermissionException $e){
            return $this->response->errorUnauthorized($e->getMessage());
        }
        return $this->response->paginator($customers, new CustomerListTransformer());
    }
}
