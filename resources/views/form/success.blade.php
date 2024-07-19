@extends('layouts.app')

@section('title', 'Đăng ký')

@section('content')
<div class="banner_display mt-[100px]">
    @if ($success)
    <h1 class="text-[20px] md:text-[23px] font-bold text-[#003b7a] text-center mt-5 capitalize"> {{ $success }}</h1>
    @endif
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <lottie-player src="https://lottie.host/b430ec1d-934e-49f6-80f5-d1bf77e0df9b/MXBmB0dc1k.json"
        background="##FFFFFF" speed="1" style="width: 300px; height: 300px ; margin: 30px auto;" loop autoplay direction="1"
        mode="normal"></lottie-player>
</div>
<div class="flex justify-center mt-5">
    <a href="{{route('home')}}" class="py-3 px-5 rounded-[5px] bg-[#003b7a] hover:opacity-80 text-white"><i class="fa-solid fa-angles-left"></i> Trang Chủ</a>
</div>
@endsection