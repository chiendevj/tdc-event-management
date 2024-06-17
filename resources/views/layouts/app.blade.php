<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>@yield('title', 'My Laravel App')</title>
</head>

<body>
    @include('components.header')
    <div class="container">
        @yield('content')
    </div>
    @include('components.footer')
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
