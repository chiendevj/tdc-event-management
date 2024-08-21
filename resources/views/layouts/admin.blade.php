<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Share Facbook meta -->
    <meta property="og:url" content="{{ $url ?? '' }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $title ?? '' }}" />
    <meta property="og:description" content="{{ $description ?? 'Sự kiện hấp dẫn' }}" />
    <meta property="og:image" content="{{ $image ?? '' }}" />
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    {{-- Taiwind css --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Main css --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-event.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form-question.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form-statistic.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/logo/logo_removebg.png') }}" type="image/x-icon">
    {{-- Fontawsome icons --}}
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/all.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/sharp-thin.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/sharp-solid.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/sharp-regular.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/sharp-light.css">
    
    <title>@yield('title', 'TDC EVENTS')</title>
</head>

<body>
    @include('components.admin.header')
    <div class="">
        @yield('content')
    </div>
    @include('components.admin.footer')
    <script src="{{ asset('js/app.js') }}"></script>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v20.0&appId=760799009295495" nonce="{{ $nonce ?? '' }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/share.js') }}"></script>
</body>

</html>