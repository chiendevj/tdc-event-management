@extends('layouts.app')

@section('title', 'Điểm danh')

@section('content')
    <div class="background-tdc-attendence">
        <div class="attendence-box">
            <h1 class="attendence-form-title"><span>Điểm danh</span> </br> tham gia sự kiện</h1>
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
                <h2 class="attent-title">
                    {{ $event['name'] }}
                </h2>
                <form action="{{ route('submit.attendance') }}" method="post">
                    @csrf
                    <div class="mt-4">
                        <label for="">Họ và tên <span>*</span> </label>
                        <input type="text" name="fullname" placeholder="Nhập họ và tên của bạn">
                    </div>
                    <div class="mt-4">
                        <label for="">Mã số sinh viên <span>*</span></label>
                        <input type="text" name="student_id" placeholder="Nhập mã số sinh viên của bạn">
                    </div>
                    <div class="mt-4">
                        <label for="">Lớp <span>*</span></label>
                        <input type="text" name="class" placeholder="Nhập lớp của bạn">
                    </div>
                    <div class="mt-4">
                        <input type="hidden" name="event_id" value="{{$event['id']}}">
                        <input type="hidden" name="code" value="{{$event['code']}}">
                        <button class="btn-attended" type="submit">Gửi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
