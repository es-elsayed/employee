<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Http\Resources\RoleResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $role = Role::query()
            ->select(['id', 'name', 'guard_name', 'created_at'])
            ->latest('id')
            ->when($request->name, fn(Builder $builder, $name) => $builder->where('name', 'like', "%{$name}%"))
            ->paginate(10);
        return Inertia::render('Role/Index', [
            'roles' => RoleResource::collection($role),
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
            'filters' => (object) $request->all(),
        ]);

    }

    public function create()
    {
        return Inertia::render('Role/Create');
    }

    public function store(RoleRequest $request)
    {
        Role::create($request->validated());
        return redirect()->route('admin.roles.index')->with('success', 'Role Created Successfully');
    }
    public function edit(Role $role)
    {
        return Inertia::render('Role/Create', [
            'role' => new RoleResource($role),
        ]);
    }

    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        return redirect()->route('admin.roles.index')->with('success', 'Role Updated Successfully');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role Deleted Successfully');
    }
}
