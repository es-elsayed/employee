<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    private string $routeResourceName = 'tasks';

    public function __construct()
    {
        // $this->middleware("can:$this->routeResourceName-read");
        // $this->middleware("can:$this->routeResourceName-update");
    }

    public function index(Request $request)
    {
        $task = Task::query()
            ->where('employee_id', auth()->user()->id)
            ->select(['id', 'name', 'employee_id', 'completed_at', 'created_at'])
            ->filter($request->search, ['name'])
            ->latest('id')
            ->paginate(10);

        return Inertia::render('EmployeeDashboard', [
            'title' => 'Tasks',
            'items' => TaskResource::collection($task),
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
            ],
            'routeResourceName' => $this->routeResourceName,
            'filters' => (object) $request->all(),
            'can' => [
                'create' => $request->user()->can('tasks-create'),
            ],
        ]);

    }

}
