<?php

namespace App\Services;

use App\Http\Requests\Admin\EmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeService
{
    public static function get(Request $request)
    {
        $query = Employee::query()
            ->with('manager', 'department')
            ->select(['id', 'first_name', 'last_name', 'email', 'salary', 'image', 'manager_id', 'department_id', 'created_at'])
            ->filter($request->search, ['first_name', 'last_name', 'email'])
            ->latest('id');

        $employees = $query->paginate(10);

        return $employees;
    }

    public static function create(EmployeeRequest $employeeRequest)
    {
        $employee = Employee::create($employeeRequest->validated());

        $employee->assignRole('employee');
        
        if ($employeeRequest->hasFile('image')) {
            self::uploadImage($employee, $employeeRequest->file('image'));
        }

        return $employee;
    }

    public static function update(EmployeeRequest $employeeRequest, Employee $employee)
    {
        $data = $employeeRequest->validated();

        // Check if the 'password' field is present in the request data
        if (isset($data['password'])) {
            // Update the password
            $employee->update([
                'password' => bcrypt($data['password']), // Assuming you're using bcrypt for password hashing
            ]);

            // Remove the 'password' field from the data to prevent it from being updated again
            unset($data['password']);
        }

        // Update the other fields
        $employee->update($data);

        return $employee;
    }

    public static function uploadImage(Employee $employee, $image = null)
    {
        $employee->image = $image->store($employee::PATH, 'public');
        $employee->save();
    }
}
