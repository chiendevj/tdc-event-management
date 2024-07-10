@extends('layouts.admin')

@section('title', 'Tạo tài khoản mới')

@section('content')
<div class="px-20 py-10">
    <div class="flex justify-center">
        <h1 class="p-2 bg-blue-800 mb-4 text-white font-semibold">Tạo tài khoản mới</h1>
    </div>

    <form action="{{ route('accounts.store') }}" method="POST" class="px-40 py-10 border-blue-900 border-dashed border-2">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-[14px] font-medium text-blue-900">Họ và tên <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" class="mt-1 p-2 outline outline-gray-300 outline-2 rounded-sm block w-full text-blue-900 placeholder:text-sm" placeholder="Nhập họ và tên đầy đủ" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-[14px] font-medium text-blue-900">Email <span class="text-red-500">*</span></label>
            <input type="email" name="email" id="email" class="mt-1 p-2 outline outline-gray-300 outline-2 rounded-sm block w-full text-blue-900 placeholder:text-sm" placeholder="Nhập địa chỉ email đầy đủ" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-[14px] font-medium text-blue-900">Mật khẩu <span class="text-red-500">*</span></label>
            <input type="password" name="password" id="password" class="mt-1 p-2 outline outline-gray-300 outline-2 rounded-sm block w-full text-blue-900 placeholder:text-sm" placeholder="Nhập mật khẩu" required>
            <small class="text-red-500">Ít nhất 8 ký tự, gồm chữ hoa, chữ thường, số và ký tự đặc biệt</small>
        </div>
 
        <div class="mb-4">
            <label for="role" class="block text-[14px] font-medium text-blue-900">Vai trò <span class="text-red-500">*</span></label>
            <select name="role" id="role" class="mt-1 p-2 outline outline-gray-300 outline-2 rounded-sm block w-full text-blue-900">
                @foreach($roles as $role)
                    @if($role->name != 'super-admin')
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="flex justify-between">
            <a class="py-2 px-5 bg-green-600 text-white font-semibold opacity-90 hover:opacity-100" href="{{ route('accounts.index') }}">Trở lại</a>
            <button type="submit" class="py-2 px-5 bg-blue-800 text-white font-semibold opacity-90 hover:opacity-100">Tạo tài khoản</button>
        </div>
    </form>
</div>
@endsection
