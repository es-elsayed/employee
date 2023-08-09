<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    private string $routeResourceName = 'users';

    public function __construct()
    {
        $this->middleware("can:$this->routeResourceName-create")->only(['create', 'store']);
        $this->middleware("can:$this->routeResourceName-read")->only('index');
        $this->middleware("can:$this->routeResourceName-update")->only(['edit', 'update']);
        $this->middleware("can:$this->routeResourceName-delete")->only('destroy');
    }

    public function index(Request $request)
    {
        return Inertia::render('User/Index', [
            'title' => 'Users',
            'items' => UserResource::collection(UserService::get($request)),
            'headers' => [
                ['label' => 'Name', 'data' => 'name'],
                ['label' => 'Email', 'data' => 'email'],
                ['label' => 'Roles', 'data' => 'roles'],
                ['label' => 'Created At', 'data' => 'created_at'],
                ['label' => 'Actions', 'data' => 'actions'],
            ],
            'routeResourceName' => $this->routeResourceName,
            'filters' => (object) $request->all(),
            'can' => ['create' => $request->user()->can('users-create')],
        ]);
    }

    public function create()
    {
        return Inertia::render('User/Create', [
            'action' => 'create',
            'routeResourceName' => $this->routeResourceName,
            'roles' => RoleResource::collection(Role::get(['id', 'name'])),
        ]);
    }

    public function store(UserRequest $request)
    {
        $user = UserService::create($request);

        $user->assignRole($request->role_id);

        return to_route("admin.$this->routeResourceName.index")->with('success', 'User Created Successfully');
    }

    public function edit(User $user)
    {
        $user->load('roles:id,name');

        return Inertia::render('User/Create', [
            'item' => new UserResource($user),
            'action' => 'edit',
            'routeResourceName' => $this->routeResourceName,
            'roles' => RoleResource::collection(Role::get(['id', 'name'])),
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        UserService::update($request, $user);

        $user->syncRoles($request->role_id);

        return to_route("admin.$this->routeResourceName.index")->with('success', 'User Updated Successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return to_route("admin.$this->routeResourceName.index")->with('error', 'User Deleted Successfully');
    }
}
