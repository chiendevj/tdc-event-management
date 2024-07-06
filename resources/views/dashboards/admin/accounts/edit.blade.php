@extends('layouts.admin')

@section('title', 'Sửa tài khoản')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Sửa tài khoản</h1>
    
    <form action="{{ route('accounts.update', $account) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Tên</label>
            <input type="text" name="name" id="name" value="{{ $account->name }}" class="form-input mt-1 block w-full" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ $account->email }}" class="form-input mt-1 block w-full" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật tài khoản</button>
    </form>
</div>
@endsection
