@extends('layouts.app')

@section('title', 'Tra cứu')

@section('content')
<div class="background-tdc">
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
    <div class="search-box">
        <h1 class="title"><span>Tra cứu</span><br> tham gia sự kiện</h1>
        <form id="searchForm" action="{{ route('search_events_by_student') }}" method="get">
            <div class="flex items-center">
                <input id="studentIdInput" class="input-search rounded-l-lg" name="student_id" placeholder="Nhập mã số sinh viên" type="text">
                <button type="submit" class="btn-search rounded-r-lg"><i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm</button>
            </div>
        </form>
    </div>
</div>

@endsection
