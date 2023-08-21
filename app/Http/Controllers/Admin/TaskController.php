<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TaskRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\TaskResource;
use App\Models\Employee;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    private string $routeResourceName = 'tasks';

    public function __construct()
    {
        $this->middleware("can:$this->routeResourceName-create")->only(['create', 'store']);
        $this->middleware("can:$this->routeResourceName-read")->only('index');
        $this->middleware("can:$this->routeResourceName-update")->only(['edit', 'update']);
        $this->middleware("can:$this->routeResourceName-delete")->only('destroy');
    }

    public function index(Request $request)
    {
        $task = Task::query()
            ->select(['id', 'name', 'employee_id', 'completed_at', 'created_at'])
            ->filter($request->search, ['name'])
            ->latest('id')
            ->paginate(10);

        return Inertia::render('Task/Index', [
            'title' => 'Tasks',
            'items' => TaskResource::collection($task),
            'completed_atheaders' => [
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
                'create' => $request->user()->can('tasks-create'),
            ],
        ]);

    }

    public function create()
    {
        return Inertia::render('Task/Create', [
            'action' => 'create',
            'routeResourceName' => $this->routeResourceName,
            'employees' => EmployeeResource::collection(Employee::get(['id', 'first_name', 'last_name'])),
        ]);
    }

    public function store(TaskRequest $request)
    {
        $task = Task::create($request->validated());
        return to_route('admin.tasks.edit', $task->id)->with('success', 'Task Created Successfully');
    }
    public function edit(Task $task)
    {
        return Inertia::render('Task/Create', [
            'item' => new TaskResource($task),
            'action' => 'edit',
            'routeResourceName' => $this->routeResourceName,
            'employees' => EmployeeResource::collection(Employee::get(['id', 'first_name', 'last_name'])),
        ]);
    }

    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        return to_route('admin.tasks.index')->with('success', 'Task Updated Successfully');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return to_route('admin.tasks.index')->with('error', 'Task Deleted Successfully');
    }
}
