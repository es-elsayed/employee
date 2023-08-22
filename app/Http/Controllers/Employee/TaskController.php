<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TaskRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\EmployeeTaskResource;
use App\Models\Employee;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    private string $routeResourceName = 'tasks';

    public function __construct()
    {
        $this->middleware("role:employee");
        $this->middleware("role:employee");
    }

    public function index(Request $request)
    {
        $task = Task::query()
            ->where('employee_id', auth()->user()->id)
            ->select(['id', 'name', 'employee_id', 'completed_at', 'created_at'])
            ->filter($request->search, ['name'])
            ->latest('id')
            ->paginate(10);

        return Inertia::render('Employee/Task/Index', [
            'title' => 'Tasks',
            'items' => EmployeeTaskResource::collection($task),
            'headers' => [
                [
                    'label' => '#',
                    'data' => '',
                ],
                [
                    'label' => 'Name',
                    'data' => 'name',
                ],
                [
                    'label' => 'Employee',
                    'data' => 'employee',
                ],
                [
                    'label' => 'Status',
                    'data' => 'status',
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
                'create' => $request->user()->hasRole('employee'),
            ],
        ]);

    }
    public function edit(Task $task)
    {
        return Inertia::render('Employee/Task/Edit', [
            'item' => new EmployeeTaskResource($task),
            'action' => 'edit',
            'routeResourceName' => $this->routeResourceName,
        ]);
    }

    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        return to_route('employee.tasks.index')->with('success', 'Task Updated Successfully');
    }
}
