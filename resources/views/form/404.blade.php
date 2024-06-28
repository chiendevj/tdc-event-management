@extends('layouts.app')

@section('title', 'Not found')

@section('content')
<div class="banner_display ">
    @if ($error)
    <h1 class="text-[20px] md:text-[23px] font-bold text-[#003b7a] text-center mt-5 capitalize"> {{ $error }}</h1>
    @endif

    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <lottie-player src="https://lottie.host/f4ca584c-c602-4f19-862b-a0bad2c50eda/csE9ROFt5P.json    "
        background="##FFFFFF" speed="1" style="width: 300px; height: 300px ; margin: 30px auto;" loop autoplay direction="1"
        mode="normal"></lottie-player>
</div>
@endsection