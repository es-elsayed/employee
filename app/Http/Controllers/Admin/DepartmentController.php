<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    private string $routeResourceName = 'departments';

    public function __construct()
    {
        $this->middleware("can:$this->routeResourceName-create")->only(['create', 'store']);
        $this->middleware("can:$this->routeResourceName-read")->only('index');
        $this->middleware("can:$this->routeResourceName-update")->only(['edit', 'update']);
        $this->middleware("can:$this->routeResourceName-delete")->only('destroy');
    }

    public function index(Request $request)
    {
        $department = Department::query()
            ->select(['id', 'name', 'description', 'created_at'])
            ->when($request->search, fn(Builder $builder, $search) => $builder->where('name', 'like', "%{$search}%"))
            ->latest('id')
            ->paginate(10);

        return Inertia::render('Department/Index', [
            'title' => 'Departments',
            'items' => DepartmentResource::collection($department),
            'headers' => [
                [
                    'label' => 'Name',
                    'data' => 'name',
                ],
                [
                    'label' => 'Description',
                    'data' => 'description',
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
                'create' => $request->user()?->can('departments-create'),
            ],
        ]);

    }

    public function create()
    {
        return Inertia::render('Department/Create', [
            'action' => 'create',
            'routeResourceName' => $this->routeResourceName,
        ]);
    }

    public function store(DepartmentRequest $request)
    {
        Department::create($request->validated());
        return to_route('admin.departments.index')->with('success', 'Department Created Successfully');
    }
    public function edit(Department $department)
    {
        return Inertia::render('Department/Create', [
            'item' => new DepartmentResource($department),
            'action' => 'edit',
            'routeResourceName' => $this->routeResourceName,
        ]);
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        $department->update($request->validated());
        return to_route('admin.departments.index')->with('success', 'Department Updated Successfully');
    }

    public function destroy(Department $department)
    {
        if ($department->employees()->exists()) {
            return redirect()->route('admin.departments.index')->with('error', 'Cannot delete department with assigned employees');
        }

        $department->delete();
        return redirect()->route('admin.departments.index')->with('success', 'Department Deleted Successfully');
    }

}
