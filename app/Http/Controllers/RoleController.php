<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // Quản lý roles
    public function create()
    {
        $permissions = Permission::all();
        return view('dashboards.admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'nullable|string'
        ]);

        // Create the new role
        $role = Role::create(['name' => $request->name]);

        // Create and assign permissions to the role
        if ($request->filled('permissions')) {
            $permissions = explode(',', $request->permissions);
            foreach ($permissions as $permissionName) {
                $permission = Permission::firstOrCreate(['name' => $permissionName]);
                $role->givePermissionTo($permission);
            }
        }

        return redirect()->route('accounts.index')->with('success', 'Tạo quyền mới thành công.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();  
        return view('dashboards.admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
        ]);

        $role->update([
            'name' => $request->name,
        ]); 
        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('accounts.edit')->with('success', 'Cập nhật quyền thành công.');
    }


    public function destroy(Role $role)
    {
        if ($role->name == 'super-admin') {
            return redirect()->route('accounts.index')->with('error', 'Không thể xóa quyền Super Admin!');
        }

        $role->permissions()->detach();
        // Xóa quyền
        $role->delete();
        return redirect()->route('accounts.index')->with('success', 'Xóa quyền thành công.');
    }
}
