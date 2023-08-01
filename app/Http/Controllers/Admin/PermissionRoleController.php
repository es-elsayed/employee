<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionRoleController extends Controller
{
    public function __invoke(Request $request, Permission $permission)
    {
        if ($request->action == 'attach') {
            $permission->assignRole($request->roleId);
        } else {
            $permission->removeRole($request->roleId);
        }
        return redirect()->back()->with('success', 'Permission ' . $request->action . 'ed successfully.');
    }

}
