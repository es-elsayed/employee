<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionRequest;
use App\Http\Resources\PermissionResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    private string $routeResourceName = 'permissions';

    public function __construct()
    {
        $this->middleware("can:$this->routeResourceName-create")->only(['create', 'store']);
        $this->middleware("can:$this->routeResourceName-read")->only('index');
        $this->middleware("can:$this->routeResourceName-update")->only(['edit', 'update']);
        $this->middleware("can:$this->routeResourceName-delete")->only('destroy');
    }

    public function index(Request $request)
    {
        $permission = Permission::query()
            ->select(['id', 'name', 'guard_name', 'created_at'])
            ->when($request->search, fn(Builder $builder, $search) => $builder->where('name', 'like', "%{$search}%"))
            ->latest('id')
            ->paginate(10);

        return Inertia::render('Permission/Index', [
            'title' => 'Permissions',
            'items' => PermissionResource::collection($permission),
            'headers' => [
                [
                    'label' => 'Name',
                    'name' => 'name',
                ],
                [
                    'label' => 'Created At',
                    'name' => 'created_at',
                ],
                [
                    'label' => 'Actions',
                    'name' => 'actions',
                ],
            ],
            'routeResourceName' => $this->routeResourceName,
            'filters' => (object) $request->all(),
            'can' => [
                'create' => $request->user()?->can('permissions-create'),
            ],
        ]);

    }

    public function create()
    {
        return Inertia::render('Permission/Create', [
            'action' => 'create',
            'routeResourceName' => $this->routeResourceName,
        ]);
    }

    public function store(PermissionRequest $request)
    {
        Permission::create($request->validated());
        return to_route('admin.permissions.index')->with('success', 'Permission Created Successfully');
    }
    public function edit(Permission $permission)
    {
        return Inertia::render('Permission/Create', [
            'item' => new PermissionResource($permission),
            'action' => 'edit',
            'routeResourceName' => $this->routeResourceName,
        ]);
    }

    public function update(PermissionRequest $request, Permission $permission)
    {
        $permission->update($request->validated());
        return to_route('admin.permissions.index')->with('success', 'Permission Updated Successfully');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return to_route('admin.permissions.index')->with('error', 'Permission Deleted Successfully');
    }
}
