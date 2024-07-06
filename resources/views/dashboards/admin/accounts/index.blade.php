@extends('layouts.admin')

@section('title', 'Quản lý Tài khoản, Quyền và Permissions')

@section('content')
<div class="px-40 py-20">
    <div class="flex justify-between mb-10">
        <h4 class="font-bold mb-4 p-2 bg-blue-900 inline-block text-white">Danh sách tài khoản</h4>
        <a href="{{ route('accounts.create') }}" class="font-bold p-2 mb-4 bg-blue-900 text-white hover:bg-green-600">Tạo tài khoản mới</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-10">
        <thead class="text-xs text-gray-700 uppercase bg-gray-300 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3 text-sm">ID</th>
                <th scope="col" class="px-6 py-3 text-center text-sm">Họ và tên</th>
                <th scope="col" class="px-6 py-3 text-center text-sm">Email</th>
                <th scope="col" class="px-6 py-3 text-center text-sm">Quyền</th>
                <th scope="col" class="px-6 py-3 text-center text-sm">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accounts as $account)
            <tr class="bg-gray-100 border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-mono font-semibold text-gray-900">{{ $account->id }}</th>
                <td class="px-6 py-4 font-medium text-gray-900 text-start break-words whitespace-normal">{{ $account->name }}</td>
                <td class="px-6 py-4 text-center">{{ $account->email }}</td>
                <td class="px-6 py-4 text-center">{{ $account->getRoleNames()->join(', ') }}</td>
                <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center gap-3">
                        <a class="text-blue-600 hover:underline" href="{{ route('accounts.edit', $account) }}">Sửa</a>
                        <form action="{{ route('accounts.destroy', $account) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này không?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-blue-600 hover:underline">Xóa</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="flex justify-between mb-10">
        <h4 class="font-bold mb-4 p-2 bg-blue-900 inline-block text-white">Danh sách Quyền</h4>
        <a href="{{ route('roles.create') }}" class="font-bold p-2 mb-4 bg-blue-900 text-white hover:bg-green-600">Tạo quyền mới</a>
    </div>

    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-10">
        <thead class="text-xs text-gray-700 uppercase bg-gray-300 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3 text-sm">ID</th>
                <th scope="col" class="px-6 py-3 text-center text-sm">Tên quyền</th>
                <th scope="col" class="px-6 py-3 text-center text-sm">Permissions</th>
                <th scope="col" class="px-6 py-3 text-center text-sm">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
            <tr class="bg-gray-100 border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-mono font-semibold text-gray-900">{{ $role->id }}</th>
                <td class="px-6 py-4 font-medium text-gray-900 text-start break-words whitespace-normal">{{ $role->name }}</td>
                <td class="px-6 py-4 text-start">{{ $role->permissions->pluck('name')->join(', ') }}</td>
                <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center gap-3">
                        <a class="text-blue-600 hover:underline" href="{{ route('roles.edit', $role) }}">Sửa</a>
                        <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa quyền này không?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-blue-600 hover:underline">Xóa</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

 
</div>
@endsection
