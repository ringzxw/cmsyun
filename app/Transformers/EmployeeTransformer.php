<?php

namespace App\Transformers;

use App\Models\Employee;
use League\Fractal\TransformerAbstract;

class EmployeeTransformer extends TransformerAbstract
{
    public function transform(Employee $employee)
    {
        $role =  $employee->roles()->first();
        return [
            'id'            => $employee->id,
            'name'          => $employee->name,
            'email'         => $employee->email,
            'avatar'        => $employee->avatar,
            'mobile'        => $employee->mobile,
            'created_at'    => $employee->created_at->toDateTimeString(),
            'updated_at'    => $employee->updated_at->toDateTimeString(),
            'role'          => $role->slug,
            'role_name'     => $role->name,
            'team_name'     => $employee->team->name,
        ];
    }
}