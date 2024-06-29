<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Main css --}}
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('assets/logo/logo_removebg.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/attendence.css') }}">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/all.css">
    <link rel="stylesheet" href="{{ asset('js/owlcarousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/owlcarousel/assets/owl.theme.default.min.css') }}">
    <title>@yield('title', 'My Laravel App')</title>
</head>

<body>
    @include('components.header')
    @yield('content')
    @include('components.footer')


    @yield('scripts')
    <script src='{{ asset('js/fullcalendar/index.global.min.js') }}'></script>
    <script src="{{ asset('js/owlcarousel/jquery.min.js') }}"></script>
    <script src="{{ asset('js/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            dots:true,
            autoplay: true,
            autoplayTimeout: 3000,
            items: 1,
        })
    </script>
</body>

</html>
