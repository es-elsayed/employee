<?php

namespace App\Http\Requests\Admin;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'max:255',
                Rule::unique(Employee::class, 'email')->ignore($this->employee),
            ],
            'salary' => ['required', 'numeric'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'department_id' => ['required', Rule::exists(Department::class, 'id')],
            'manager_id' => ['required', Rule::exists(Employee::class, 'id')],
        ];

        if ($this->input('password') === null) {
            // Remove password rules if password is null
            unset($rules['password']);
        } else {
            // Add password rules if password is not null
            $passwordRule = $this->route('employee') ? 'nullable' : 'required';
            $rules['password'] = ['bail', $passwordRule, Password::defaults(), 'confirmed'];
        }

        return $rules;
    }
}
