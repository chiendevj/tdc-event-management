@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="w-full bg-[var(--dark-bg)] mx-auto">
        <div class="system_analysis p-4 bg-[var(--dark-bg)] container mx-auto w-full px-8 py-4">
            <div class="grid lg:grid-cols-4 gap-4 sm:gird-cols-2">
                <div class="relative analysis_item">
                    <div
                        class="absolute top-[-10px] w-[20px] h-[20px] right-[20px] bg-green-500 flex items-center justify-center text-white p-4 rounded-sm">
                        <i class="fa-light fa-user"></i>
                    </div>
                    <h4 class="text-sm font-semibold uppercase">Sinh viên đã tham gia sự kiện</h4>
                    <h2 class="text-lg font-bold total_paticipant">0</h2>
                    <p class="text-sm text-gray-400">
                        Tổng số sinh viên đã tham gia sự kiện
                    </p>
                </div>
                <div class="relative analysis_item">
                    <div
                        class="absolute top-[-10px] w-[20px] h-[20px] right-[20px] bg-green-500 flex items-center justify-center text-white p-4 rounded-sm">
                        <i class="fa-light fa-calendar-days"></i>
                    </div>
                    <h4 class="text-sm font-semibold uppercase">Sự kiện đã tổ chức</h4>
                    <h2 class="text-lg font-bold total_event">0</h2>
                    <p class="text-sm text-gray-400">
                        Tổng số sự kiện đã tổ chức
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-[60px] container mx-auto px-8">
        <h3
            class="text-lg text-center uppercase block p-2 font-semibold rounded-sm text-white bg-[var(--dark-bg)] w-fit mx-auto">
            Lịch biểu sự kiện</h3>
        <div class="change_date flex items-center justify-between mt-[20px]">
            <div
                class="icon_prev_date text-[var(--dark-bg)] font-semibold transition-all duration-100 ease-in p-2 flex items-center justify-center w-[32px] h-[32px] hover:text-white hover:bg-[var(--dark-bg)] rounded-full cursor-pointer">
                <i class="fa-light fa-chevron-left"></i>
            </div>
            <div class="display_date">
                <h3
                    class="text-center display_current_date uppercase block p-2 font-semibold rounded-sm text-white bg-[var(--dark-bg)] w-fit mx-auto">
                    Tháng 6 / 2024</h3>
            </div>
            <div
                class="icon_next_date text-[var(--dark-bg)] font-semibold transition-all duration-100 ease-in p-2 flex items-center justify-center w-[32px] h-[32px] hover:text-white hover:bg-[var(--dark-bg)] rounded-full cursor-pointer">
                <i class="fa-light fa-chevron-right"></i>
            </div>
        </div>

        <div class="calender_table mt-[20px] w-full mb-8 rounded-sm overflow-hidden">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="rounded-sm text-xs border border-[var(--table-border)] text-gray-700 uppercase bg-gray-300 dark:bg-gray-700 dark:text-gray-400">
                    <th scope="col" class="px-6 py-3 text-center">Thứ 2</th>
                    <th scope="col" class="px-6 py-3 text-center">Thứ 3</th>
                    <th scope="col" class="px-6 py-3 text-center">Thứ 4</th>
                    <th scope="col" class="px-6 py-3 text-center">Thứ 5</th>
                    <th scope="col" class="px-6 py-3 text-center">Thứ 6</th>
                    <th scope="col" class="px-6 py-3 text-center">Thứ 7</th>
                    <th scope="col" class="px-6 py-3 text-center">Chủ Nhật</th>
                </thead>
                <tbody class="calender_body bg-[var(--table-calender-bg)]">

                </tbody>
            </table>
        </div>
    </div>

    <script>
        const displayDate = document.querySelector('.display_current_date');
        const btnChangeNextDate = document.querySelector('.icon_next_date');
        const btnChangePrevDate = document.querySelector('.icon_prev_date');
        const totalParticipant = document.querySelector('.total_paticipant');
        const totalEvent = document.querySelector('.total_event');
        let events = [];
        // const colors = ["#eb4d4b", "#6ab04c", "#f0932b", "#0abde3", "#6c5ce7", "#38ada9"];

        // Get current date and display
        const currentDate = new Date();
        displayDate.textContent = `Tháng ${currentDate.getMonth() + 1} / ${currentDate.getFullYear()}`;


        btnChangeNextDate.addEventListener('click', () => {
            const currentMonth = parseInt(displayDate.textContent.split(' / ')[0].split(' ')[1]);
            const currentYear = parseInt(displayDate.textContent.split(' / ')[1]);

            // Check if next month is greater than 12
            if (currentMonth + 1 > 12) {
                generateCalendar(0, currentYear + 1);
                displayDate.textContent = `Tháng 1 / ${currentYear + 1}`;
                return;
            }

            generateCalendar(currentMonth, currentYear);
            displayDate.textContent = `Tháng ${currentMonth + 1} / ${currentYear}`;
        });

        btnChangePrevDate.addEventListener('click', () => {
            const currentMonth = parseInt(displayDate.textContent.split(' / ')[0].split(' ')[1]);
            const currentYear = parseInt(displayDate.textContent.split(' / ')[1]);

            // Check if next month is less than 1
            if (currentMonth - 1 < 1) {
                generateCalendar(11, currentYear - 1);
                displayDate.textContent = `Tháng 12 / ${currentYear - 1}`;
                return;
            }

            generateCalendar(currentMonth - 2, currentYear);
            displayDate.textContent = `Tháng ${currentMonth - 1} / ${currentYear}`;
        });

        function generateCalendar(month, year) {
            const calendarBody = document.querySelector('.calender_body');
            calendarBody.innerHTML = '';

            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const firstDay = new Date(year, month, 1).getDay(); // frist day of month

            let date = 1;
            let started = false;

            for (let i = 0; i < 6; i++) {
                let row = document.createElement('tr');
                row.classList.add("bg-white","border-b", "border-[var(--table-border)]")

                for (let j = 1; j <= 7; j++) {
                    let cell = document.createElement('td');
                    cell.classList.add("px-6","py-4","dark:text-gray-400");
                    let day = document.createElement('span');
                    day.classList.add("day");

                    // first day of month
                    if (i === 0 && j === (firstDay === 0 ? 7 : firstDay)) {
                        started = true;
                    }

                    if (started && date <= daysInMonth) {
                        day.textContent = date;
                        cell.appendChild(day);
                        renderEventsForDay(cell, date, month, year, day);
                        date++;
                    }

                    row.appendChild(cell);
                }

                calendarBody.appendChild(row);

                if (date > daysInMonth) {
                    break;
                }
            }
        }

        function renderEventsForDay(cell, date, month, year, day) {
            events.forEach(event => {
                const eventStart = new Date(event.event_start);
                const eventEnd = new Date(event.event_end);
                const eventStartMonth = eventStart.getMonth();
                const eventEndMonth = eventEnd.getMonth();

                // Check if event is in the same year and month
                if (eventStart.getFullYear() === year && eventEnd.getFullYear() === year) {
                    if (eventStartMonth === eventEndMonth && eventStartMonth === month) {
                        if (eventStart.getDate() <= date && date <= eventEnd.getDate()) {
                            day.classList.add('active');
                            createEventElement(event, cell);
                        }
                    } else if (eventStartMonth !== eventEndMonth && eventStartMonth === month) {
                        // case event start in previous month and end in current month
                        if (eventStart.getDate() <= date) {
                            day.classList.add('active');
                            createEventElement(event, cell);
                        }
                    } else if (eventEndMonth !== eventStartMonth && eventEndMonth === month) {
                         // case event start in previous month and end in current month
                        if (eventEnd.getDate() >= date) {
                            day.classList.add('active');
                            createEventElement(event, cell);
                        }
                    }
                }
            });
        }

        function createEventElement(event, cell) {
            const eventEle = document.createElement('div');
            const eventTitle = document.createElement('h4');
            const eventDescription = document.createElement('p');
            // const color = colors[Math.floor(Math.random() * colors.length)];

            // eventEle.style.backgroundColor = color;
            eventEle.classList.add('event');
            eventTitle.classList.add('event_title');
            eventDescription.classList.add('event_desc');
            eventTitle.textContent = event.name;
            eventDescription.textContent = event.location;
            eventEle.appendChild(eventTitle);
            eventEle.appendChild(eventDescription);
            cell.appendChild(eventEle);
        }


        async function getEvents(params) {
            const url = "/api/events";
            const response = await fetch(url);
            const data = await response.json();
            if (data.success) {
                events = data.data;
                return true;
            }

            return false;
        }

        getEvents().then(() => {
            generateCalendar(currentDate.getMonth(), currentDate.getFullYear());
            totalEvent.textContent = events.length;
        });
    </script>
@endsection
