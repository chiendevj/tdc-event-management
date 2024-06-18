@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="w-full bg-[var(--dark-bg)] mx-auto">
        <div class="system_analysis p-4 bg-[var(--dark-bg)] container mx-auto w-full px-8 py-4">
            <div class="grid grid-cols-4 gap-4 translate-y-[50%]">
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
    <div class="mt-[100px] container mx-auto">
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

        <div class="calender_table mt-[20px] w-full">
            <table class="w-full">
                <thead class="rounded-sm">
                    <th>Thứ 2</th>
                    <th>Thứ 3</th>
                    <th>Thứ 4</th>
                    <th>Thứ 5</th>
                    <th>Thứ 6</th>
                    <th>Thứ 7</th>
                    <th>Chủ Nhật</th>
                </thead>
                <tbody class="calender_body">

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
        const colors = ["#eb4d4b", "#6ab04c", "#f0932b", "#0abde3", "#6c5ce7", "#38ada9"];

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
            const firstDay = new Date(year, month, 1).getDay(); // First month of year

            let date = 1;
            let started = false;

            for (let i = 0; i < 6; i++) {
                let row = document.createElement('tr');

                for (let j = 1; j <= 7; j++) {
                    let cell = document.createElement('td');
                    let day = document.createElement('span');

                    day.classList.add("day")


                    // Start position
                    if (i === 0 && j === (firstDay === 0 ? 7 : firstDay)) {
                        started = true;
                    }

                    if (started && date <= daysInMonth) {
                        day.textContent = date;
                        cell.appendChild(day);

                        events.forEach(event => {
                            const eventStart = new Date(event.event_start);
                            const eventEnd = new Date(event.event_end);
                            // Check month and year of event match with current month and year in calendar
                            if (eventStart.getMonth() === month && eventStart.getFullYear() === year) {
                                if (eventStart.getDate() <= date && eventEnd.getDate() >= date) {
                                    const eventEle = document.createElement('div');
                                    const eventTitle = document.createElement('h4');
                                    const eventDescription = document.createElement('p');
                                    day.classList.add('active');
                                    const color = colors[Math.floor(Math.random() * colors.length)];
                                    eventEle.style.backgroundColor = color;
                                    eventEle.classList.add('event');
                                    eventTitle.classList.add('event_title');
                                    eventDescription.classList.add('event_desc');


                                    eventTitle.textContent = event.name;
                                    eventDescription.textContent = event.location;
                                    eventEle.appendChild(eventTitle);
                                    eventEle.appendChild(eventDescription);
                                    cell.appendChild(eventEle);
                                }
                            }
                        });


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
