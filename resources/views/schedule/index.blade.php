@extends('layouts.app')

@section('title', 'Lịch sự kiện | Event Zone | FIT-TDC | Khoa Công nghệ thông tin - Cao đẳng Công nghệ Thủ Đức')

@section('content')
    <div class="w-[92%] container mx-auto mt-[120px]">
        <div class="explain flex items-center justify-center gap-3 mb-4">
            <div class="explain-item flex items-center justify-center gap-2">
                <div class="explain-color event-upcoming"></div>
                <p class="explain-text">Sắp diễn ra</p>
            </div>
            <div class="explain-item items-center justify-center gap-2 flex">
                <div class="explain-color event-ongoing"></div>
                <p class="explain-text">Đang diễn ra</p>
            </div>
            <div class="explain-item items-center justify-center gap-2 flex">
                <div class="explain-color event-past"></div>
                <p class="explain-text">Đã diễn ra</p>
            </div>
            <div class="explain-item items-center justify-center gap-2 flex">
                <div class="explain-color event-cancelled"></div>
                <p class="explain-text">Đã hủy</p>
            </div>
        </div>
        <div id='calendar'></div>
    </div>
@endsection

@section('scripts')
    <script>
        //_______________________Calendar___________________________________//

        document.addEventListener("DOMContentLoaded", function() {

            let schedules = @json($events);
            // console.log(schedules);

            let calendarEl = document.getElementById("calendar");
            let calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'vi',
                initialView: "dayGridMonth",
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: schedules,
                eventDidMount: function(info) {
                    switch (info.event.extendedProps.status) {
                        case 'Đã diễn ra':
                            info.el.classList.add('event-past');
                            break;
                        case 'Đang diễn ra':
                            info.el.classList.add('event-ongoing');
                            break;
                        case 'Sắp diễn ra':
                            info.el.classList.add('event-upcoming');
                            break;
                        case 'Đã hủy':
                            info.el.classList.add('event-cancelled');
                            break;
                    }
                },
                eventClick: function(info) {
                    let eventId = info.event.id;
                    let name = info.event.title;
                    let eventDetailUrl = "{{ route('events.detail', ['name' => ':name', 'id' => ':id']) }}".replace(':name', slug(name) ).replace(':id', eventId);
                    window.location.href = eventDetailUrl;
                }
            });
            calendar.render();
        });

        function slug(str) {
            return String(str)
                .normalize("NFKD")
                .replace(/[\u0300-\u036f]/g, "")
                .replace(/[đĐ]/g, "d") //Xóa dấu
                .trim()
                .toLowerCase() //Cắt khoảng trắng đầu, cuối và chuyển chữ thường
                .replace(/[^a-z0-9\s-]/g, "") //Xóa ký tự đặc biệt
                .replace(/[\s-]+/g, "-"); //Thay khoảng trắng bằng dấu -, ko cho 2 -- liên tục
        }

        //_______________________End Calendar___________________________________//
    </script>
@endsection
