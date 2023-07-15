<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Http\Resources\RoleResource;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return Inertia::render('Role/Index', [
            'roles' => RoleResource::collection(Role::latest('id')->paginate(10)),
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
}
