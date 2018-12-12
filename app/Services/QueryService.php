<?php
namespace App\Services;

use App\Exceptions\PermissionException;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class QueryService extends BaseService
{
    /**
     * 员工导出筛选
     * @return Employee|\Illuminate\Database\Eloquent\Builder
     */
    public function getEmployeeListExportQuery()
    {
        $query = Employee::query();
        $requests = Cache::get('EmployeeExporter_'.$this->employee->id);
        if($requests){
            foreach ($requests as $k=>$v)
            {
                if(is_md5($k)){
                    if($v){
                        $query->where(function ($q) use ($v) {
                            $q->where('name', 'like', '%'.$v.'%')
                                ->orWhere('mobile', 'like', '%' . $v . '%')
                                ->orWhere('username', 'like', '%' . $v . '%');
                        });
                    }
                    continue;
                }
            }
        }
        return $query;
    }


    /**
     * 客户列表筛选
     * @param Request $request
     * @return Customer|\Illuminate\Database\Eloquent\Builder
     * @throws PermissionException
     */
    public function getCustomerListQuery(Request $request)
    {
        $query = Customer::query();
        $checked = $this->getPermissionService($this->employee)->check('customer-index');
        if(!$checked){
            throw new PermissionException('没有查看客户权限');
        }
        return $query;
    }
}