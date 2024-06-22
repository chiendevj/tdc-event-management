@extends('layouts.login')

{{-- Body --}}
@section('content')
<div class="w-full min-h-screen flex flex-col gap-3 items-center justify-center bg-gray-300">
    {{-- Error notify --}}
    @if ($errors->any())
    <div class="mb-2 form_error_notify bg-white rounded-lg overflow-hidden">
        <span class="block w-full p-4 bg-red-500 text-white">Thất bại</span>
        <ul>
            @foreach ($errors->all() as $error)
            <li class="text-red-500 p-2">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    {{-- Success notify --}}
    @if (session('success'))
    <div class="form_success_notify">
        <div class="mb-2 form_error_notify bg-white rounded-lg overflow-hidden">
            <span class="block w-full p-4 bg-green-500 text-white">Thành công</span>
            <ul>
                <li class="text-green-500 p-4">{{ session('success') }}</li>
            </ul>
        </div>
    </div>
    @endif
    <div class="flex flex-col md:flex-row p-4 bg-gray-200 rounded-lg shadow-lg overflow-hidden w-full max-w-4xl">
        <div class="w-full md:w-1/2 flex items-center justify-center">
            <img src="{{ asset('assets/images/bg-login-1.jpg') }}" alt="" class="object-cover w-full h-full md:h-auto rounded-lg">
        </div>

        <form method="POST" action="{{ route('handle_login') }}" class="w-full md:w-1/2 flex flex-col gap-4 p-8">
            @csrf
            <h3 class="text-xl font-semibold">Đăng nhập với quyền quản trị</h3>

            <label for="email" class="flex flex-col gap-2">
                <span class="text-sm text-gray-500">Email <span class="text-red-600">*</span></span>
                <input type="email" placeholder="Vui lòng nhập email" name="email" id="email" class="rounded-lg border bg-transparent border-gray-500 p-2 outline-none w-full text-sm focus:border-blue-500 focus:border-2">
            </label>

            <label for="password" class="flex flex-col gap-2">
                <span class="text-sm text-gray-500">Mật khẩu <span class="text-red-600">*</span></span>
                <input type="password" placeholder="Vui lòng nhập mật khẩu" name="password" id="password" class="rounded-lg border bg-transparent border-gray-500 p-2 outline-none w-full text-sm focus:border-blue-500 focus:border-2">
            </label>

            <label for="remember" class="flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember" class="bg-[var(--background)]">
                <span class="text-sm text-gray-500">Duy trì đăng nhập</span>
            </label>

            <button class="rounded-lg border text-sm text-gray-200 border-blue-500 bg-blue-400 hover:bg-blue-600 transition-colors duration-300 ease-in p-2 outline-none w-full">
                Đăng nhập
            </button>
        </form>
    </div>
    <div>
        <p class="text-sm"><a href="/" class="text-blue-600">Trở về trang chủ</a></p>
    </div>
</div>
@endsection

@section('script')
@endsection
