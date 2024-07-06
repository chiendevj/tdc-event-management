<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = User::all();
        $roles = Role::all();
        $permissions = Permission::all();
        return view('dashboards.admin.accounts.index', compact('accounts', 'roles', 'permissions'));
    }

    public function create()
    {
        return view('dashboards.admin.accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|',
            'password' => 'required|min:6',
            // Add other validation rules as necessary
        ]);

        User::create([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'password' => bcrypt($request->password),
            // Add other fields as necessary
        ]);

        return redirect()->route('accounts.index')->with('success', 'Tạo tài khoản thành công.');
    }

    public function show(User $account)
    {
        return view('dashboards.admin.accounts.show', compact('account'));
    }

    public function edit(User $account)
    {
        return view('dashboards.admin.accounts.edit', compact('account'));
    }

    public function update(Request $request, User $account)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $account->id,
            // Add other validation rules as necessary
        ]);

        $account->update([
            'name' => $request->name,
            'email' => $request->email,
            // Add other fields as necessary
        ]);

        return redirect()->route('accounts.index')->with('success', 'Cập nhật tài khoản thành công.');
    }

    public function destroy(User $account)
{
    if ($account->hasRole('super-admin')) {
        return redirect()->route('accounts.index')->with('error', 'Bạn không thể xóa tài khoản superadmin.');
    }

    $account->delete();

    return redirect()->route('accounts.index')->with('success', 'Tài khoản đã được xóa thành công.');
}

}
