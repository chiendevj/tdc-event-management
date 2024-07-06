@extends('layouts.admin')

@section('title', 'Sửa tài khoản')

@section('content')
<div class="px-20 py-10">
    <div class="flex justify-center">
        <h1 class="p-2 bg-blue-800 mb-4 text-white font-semibold">Chỉnh sửa tài khoản</h1>
    </div>

    <form action="{{ route('accounts.update', $account->id) }}" method="POST" class="px-40 py-10 border-blue-900 border-dashed border-2">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-[14px] font-medium text-blue-900">Họ và tên <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" class="mt-1 p-2 outline outline-gray-300 outline-2 rounded-sm block w-full text-blue-900 placeholder:text-sm" placeholder="Nhập họ và tên đầy đủ" required value="{{ $account->name }}">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-[14px] font-medium text-blue-900">Email <span class="text-red-500">*</span></label>
            <input type="email" name="email" id="email" class="mt-1 p-2 outline outline-gray-300 outline-2 rounded-sm block w-full text-blue-900 placeholder:text-sm" placeholder="Nhập địa chỉ email đầy đủ" required value="{{ $account->email }}">
        </div>

        <div class="mb-4">
            <label for="password" class="block text-[14px] font-medium text-blue-900">Mật khẩu</label>
            <input type="password" name="password" id="password" class="mt-1 p-2 outline outline-gray-300 outline-2 rounded-sm block w-full text-blue-900 placeholder:text-sm" placeholder="Nhập mật khẩu mới (nếu muốn thay đổi)">
            <small class="text-gray-500">Ít nhất 8 ký tự, gồm chữ hoa, chữ thường, số và ký tự đặc biệt</small>
        </div>

        @if(!$account->hasRole('super-admin'))
        <div class="mb-4">
            <label for="role" class="block text-[14px] font-medium text-blue-900">Vai trò <span class="text-red-500">*</span></label>
            <select name="role" id="role" class="mt-1 p-2 outline outline-gray-300 outline-2 rounded-sm block w-full text-blue-900">
                @foreach($roles as $role)
                    @if($role->name != 'super-admin')
                        <option value="{{ $role->name }}" {{ $account->roles->contains('name', $role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        @endif

        <div class="flex justify-between">
            <a class="py-2 px-5 bg-green-600 text-white font-semibold opacity-90 hover:opacity-100" href="{{ route('accounts.index') }}">Trở lại</a>
            <button type="submit" class="py-2 px-5 bg-blue-800 text-white font-semibold opacity-90 hover:opacity-100">Cập nhật</button>
        </div>
    </form>
</div>
@endsection
