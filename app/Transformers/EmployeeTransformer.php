<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Employee;

class EmployeeTransformer extends TransformerAbstract
{
    /**
     * Transform Barang.
     *
     * @param Employee $employee
     */
    public function transform(Employee $employee)
    {
        return [
            'id_employee' => $employee->id_employee,
            'name' => $employee->name,
            'address' => $employee->address,
            'phone_number' => $employee->phone_number,
            'salary' => $employee->salary,
            'role' => $employee->roles->role_name,
            'branch' => $employee->branchs->branch_name,
            'id_role' => $employee->id_role,
            'id_branch' => $employee->id_branch
        ];
    }
}