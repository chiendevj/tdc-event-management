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
        $permissions = Permission::all(); // Lấy danh sách tất cả permissions
        $rolePermissions = $role->permissions()->pluck('id')->toArray(); // Lấy danh sách permissions của role

        return view('dashboards.admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
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

        if ($request->permissions) {
            $role->permissions()->sync($request->permissions); // Đồng bộ permissions
        } else {
            $role->permissions()->detach(); // Xóa tất cả permissions nếu không có permissions nào được chọn
        }

        return redirect()->route('accounts.index')->with('success', 'Cập nhật quyền thành công.');
    }

    public function destroy(Role $role)
    {
        if ($role === 'super-admin') {
            return redirect()->route('accounts.index')->with('success', 'Không thể xóa quyền Super Admin!');
        }

        $role->permissions()->detach();
        // Xóa quyền
        $role->delete();
        return redirect()->route('accounts.index')->with('success', 'Xóa quyền thành công.');
    }
}
