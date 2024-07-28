@extends('layouts.app')

@section('title', 'Đăng ký')

@section('content')
    <div class="background-tdc-attendence mt_container">
        <div class="attendence-box">
            <h1 class="attendence-form-title">Cập nhật lại mật khẩu</h1>
            <div class="container mx-auto md:w-[50%] form-attendence">
                <div class="line">
                    <div class="line-left"></div>
                    <div class="circle"></div>
                    <div class="line-right"></div>
                </div>
                @if (session('success'))
                    <div class="bg-green-100 text-green-700 p-4 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('forget.password.change') }}" method="post">
                    @csrf
                    <input type="text" hidden name="token" value="{{ $token }}">
                    <div class="mt-4">
                        <label for="">Mật khẩu mới <span>*</span></label>
                        <input type="text" name="password" placeholder="Nhập vào mật khẩu mới">
                        <p id="password-error" class="block text-[12px] text-red-500"></p>
                    </div>
                    <div class="mt-4">
                        <button class="btn-attended" type="submit">Gửi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

@endsection
