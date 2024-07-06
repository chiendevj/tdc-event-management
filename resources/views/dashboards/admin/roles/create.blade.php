@extends('layouts.admin')

@section('title', 'Tạo quyền mới')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Tạo tài khoản mới</h1>
    
    <form action="{{ route('accounts.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Tên</label>
            <input type="text" name="name" id="name" class="form-input mt-1 block w-full" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="form-input mt-1 block w-full" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu</label>
            <input type="password" name="password" id="password" class="form-input mt-1 block w-full" required>
        </div>
        <button type="submit" class="btn btn-primary">Tạo tài khoản</button>
    </form>
</div>
@endsection
