@extends('layouts.app')

@section('title', 'Tra cứu')

@section('content')
    <div class="background-tdc">
        <div class="search-box">
            <h1 class="title"><span>Tra cứu</span> </br> tham gia sự kiện</h1>
            <form action="" method="get">
                <div>
                    <input class="input-search" placeholder="Nhập mã số sinh viên" type="text">
                    <button class="btn-search"><i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm</button>
                </div>
            </form>
        </div>
    </div>
@endsection