<?php
namespace App\Services;

use App\Models\Employee;
use App\Models\EmployeeMessage;
use App\Utils\ConstUtils;

class MessageService extends BaseService
{
    /**
     * 发送消息
     * @param Employee $employee
     * @param $biz
     * @param $biz_action
     * @param $title
     * @param $content
     * @return EmployeeMessage
     */
    public function send(Employee $employee, $biz, $biz_action, $title, $content)
    {
        $employeeMessage = new EmployeeMessage();
        $employeeMessage->setBiz($biz);
        $employeeMessage->employee_id = $employee->id;
        $employeeMessage->biz_action = $biz_action;
        $employeeMessage->title = $title;
        $employeeMessage->content = $content;
        if($this->employee){
            $employeeMessage->created_id = $this->employee->id;
        }
        $employeeMessage->save();
        return $employeeMessage;
    }


    /**
     * 已读消息
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function read($id)
    {
        $employeeMessage =  EmployeeMessage::findOrFail($id);
        $employeeMessage->is_read = ConstUtils::READ_TRUE;
        $employeeMessage->save();
        return $employeeMessage;
    }
}