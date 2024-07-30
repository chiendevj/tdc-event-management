@extends('layouts.admin')

@section('title', 'Sửa tài khoản')

@section('content')
<div class="px-20 py-10">
    <div class="flex justify-center">
        <h1 class="p-2 bg-blue-800 mb-4 text-white font-semibold">Cấu hình đường dẫn cho Admin</h1>
    </div>

    <form action="{{ route('config.update') }}" method="POST" class="px-40 py-10 border-blue-900 border-dashed border-2">
        @csrf
        @method('POST')
        <div class="mb-4">
            <label for="route" class="block text-[14px] font-medium text-blue-900">Địa chỉ mới <span class="text-red-500">*</span></label>
            <input type="text" name="route" id="route" class="mt-1 p-2 outline outline-gray-300 outline-2 rounded-sm block w-full text-blue-900 placeholder:text-sm" placeholder="Ví dụ: Nhập vào 'admindeptrai' => đường dãn tới trang admin sẽ là: admindeptrai/admin/dashboard" required >
        </div>

        <div class="flex justify-between">
            <button type="submit" class="py-2 px-5 bg-blue-800 text-white font-semibold opacity-90 hover:opacity-100">Cập nhật</button>
        </div>
    </form>
</div>
@endsection
