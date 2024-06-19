<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/all.css">
    <title>@yield('title', 'My Laravel App')</title>
</head>

<body>
    @include('components.header')
        @yield('content')
    @include('components.footer')


    @yield('scripts')
    <script src='{{ asset('js/fullcalendar/index.global.min.js') }}'></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        
//_______________________Navbar___________________________________//
const navbar = document.getElementById("navbar");
let lastScrollTop = 0;

window.addEventListener("scroll", function () {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    if (scrollTop > lastScrollTop) {
        // Downscroll
        navbar.classList.add("show");
    } else if (scrollTop === 0) {
        // Reached top of the page
        navbar.classList.remove("show");
    }
    lastScrollTop = scrollTop;
});

function onToggleMenu() {
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    if (sidebar.classList.contains("open")) {
        sidebar.classList.remove("open");
        overlay.classList.remove("open");
    } else {
        sidebar.classList.add("open");
        overlay.classList.add("open");
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const closeButton = document.querySelector("#sidebar .close-btn");
    closeButton.addEventListener("click", onToggleMenu);
});
//_______________________End Navbar___________________________________//


//_______________________Calendar___________________________________//

document.addEventListener("DOMContentLoaded", function () {
    var calendarEl = document.getElementById("calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
         locale: 'vi',
        initialView: "dayGridMonth",
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        }
    });
    calendar.render();
});


//_______________________End Calendar___________________________________//

    </script>
</body>

</html>
