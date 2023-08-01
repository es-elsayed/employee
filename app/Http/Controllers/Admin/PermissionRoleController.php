<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionRoleController extends Controller
{
    public function __invoke(Request $request, Permission $permission)
    {
        $action = $request->action;
        $roleId = $request->roleId;
        if ($action == 'attach') {
            $permission->assignRole($roleId);
        } else {
            $permission->removeRole($roleId);
        }

        return redirect()->back()->with('success', "Permission $action ed successfully.");

    }

}
