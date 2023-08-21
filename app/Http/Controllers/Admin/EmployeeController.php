<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeRequest;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\EmployeeResource;
use App\Models\Department;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    private string $routeResourceName = 'employees';

    public function __construct()
    {
        $this->middleware("can:$this->routeResourceName-create")->only(['create', 'store']);
        $this->middleware("can:$this->routeResourceName-read")->only('index');
        $this->middleware("can:$this->routeResourceName-update")->only(['edit', 'update']);
        $this->middleware("can:$this->routeResourceName-delete")->only('destroy');
    }

    public function index(Request $request)
    {
        return Inertia::render('Employee/Index', [
            'title' => 'Employees',
            'items' => EmployeeResource::collection(EmployeeService::get($request)),
            'headers' => [
                [
                    'label' => 'Name',
                    'data' => 'full_name',
                ],
                [
                    'label' => 'Email',
                    'data' => 'email',
                ],
                [
                    'label' => 'Salary',
                    'data' => 'salary',
                ],
                [
                    'label' => 'Created At',
                    'data' => 'created_at',
                ],
                [
                    'label' => 'Actions',
                    'data' => 'actions',
                ],
            ],
            'routeResourceName' => $this->routeResourceName,
            'filters' => (object) $request->all(),
            'can' => [
                'create' => $request->user()->can('employees-create'),
            ],
        ]);

    }

    public function create()
    {
        return Inertia::render('Employee/Create', [
            'action' => 'create',
            'routeResourceName' => $this->routeResourceName,
            'managers' => EmployeeResource::collection(Employee::get(['id', 'first_name', 'last_name'])),
            'departments' => DepartmentResource::collection(Department::get(['id', 'name'])),
        ]);
    }

    public function store(EmployeeRequest $request)
    {
        $employee = EmployeeService::create($request);

        return to_route('admin.employees.edit', $employee->id)->with('success', 'Employee Created Successfully');
    }
    public function edit(Employee $employee)
    {
        $employee->load('manager', 'department');

        return Inertia::render('Employee/Create', [
            'item' => new EmployeeResource($employee),
            'action' => 'edit',
            'routeResourceName' => $this->routeResourceName,
            'managers' => EmployeeResource::collection(Employee::get(['id', 'first_name', 'last_name'])),
            'departments' => DepartmentResource::collection(Department::get(['id', 'name'])),
        ]);
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->validated());
        return to_route('admin.employees.index')->with('success', 'Employee Updated Successfully');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return to_route('admin.employees.index')->with('error', 'Employee Deleted Successfully');
    }
}
