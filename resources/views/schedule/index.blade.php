@extends('layouts.app')

@section('title', 'Lịch sự kiện')

@section('content')
    <div class="w-[92%] container mx-auto mt-12">
        <div id='calendar'></div>
    </div>
@endsection

@section('scripts')
    <script>
        //_______________________Calendar___________________________________//

        document.addEventListener("DOMContentLoaded", function() {

            let schedules = @json($events);
            console.log(schedules);

            let calendarEl = document.getElementById("calendar");
            let calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'vi',
                initialView: "dayGridMonth",
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: schedules
            });
            calendar.render();
        });
        //_______________________End Calendar___________________________________//
    </script>
@endsection
