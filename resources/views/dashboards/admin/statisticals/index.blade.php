@extends('layouts.admin')

@section('title', 'Thống kê')

@section('content')
    <div class="p-4">
        <div class="container mx-auto px-8 py-4">
            <h3 class="uppercase block p-2 font-semibold rounded-sm text-white bg-[var(--dark-bg)] w-fit mb-[20px]">
                Thống kê sự kiện</h3>
                <div class="flex flex-col lg:flex-row sm:justify-between mb-4 items-center sm:items-start">
    <div class="mb-4 lg:mb-0 lg:mr-4">
        <form action="{{ route('statisticals.index') }}" method="GET">
            <div class="flex items-center gap-4">
                <label for="year">Năm học:</label>
                <select name="year" id="year" class="relative border flex items-center h-full justify-start p-2 text-gray-400 w-full xl:w-fit outline-none">
                    <option value="">Tất cả</option>
                    @php
                        $currentYear = date('Y') - 1;
                        $startYear = $currentYear - 2;
                        $endYear = $currentYear + 2;
                    @endphp
                    @for ($year = $startYear; $year <= $endYear; $year++)
                        @php
                            $nextYear = $year + 1;
                            $academicYear = "$year - $nextYear";
                        @endphp
                        <option value="{{ $year }}" @if ($year == $selectedYear) selected @endif>
                            {{ $academicYear }}</option>
                    @endfor
                </select>
                <button type="submit" class="bg-[var(--dark-bg)] hover:opacity-90 transition-all duration-100 ease-linear text-white py-2 px-4 rounded-sm">Lọc</button>
            </div>
        </form>
    </div>
    <div>
        <form action="{{ route('statisticals.index') }}" method="GET">
            <div class="flex items-center space-x-4">
                <label for="search" class="text-nowrap">Tìm kiếm:</label>
                <input type="text" name="search" id="search" class="border h-full w-full flex items-center justify-between p-2 outline-none" value="{{ $search }}">
                <button type="submit" class="bg-[var(--dark-bg)] hover:opacity-90 transition-all duration-100 ease-linear text-white py-2 px-4 rounded-sm">Tìm</button>
            </div>
        </form>
    </div>
</div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-sm">
                @if ($events->isEmpty())
                <p class="text-center text-red-500 p-20">Không có sự kiện nào để hiển thị.</p>
                @else
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-300 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-sm">
                                Tên sự kiện
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-sm">
                                Số lượng sinh viên tham gia
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-sm">
                                Học kì
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-sm">
                                Chi tiết
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 dark:text-white break-words whitespace-normal">
                                    {{ $event->name }}
                                </th>
                                <td class="px-6 py-4 text-center">
                                    {{ $event->students_count }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $event->semester }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <button class="text-blue-600 hover:underline"
                                            onclick="showEventDetails('{{ $event->id }}')">Tổng quan</button>
                                        <button class="text-blue-600 hover:underline"
                                            onclick="showListParticipants('{{ $event->id }}')">Danh sách tham
                                            gia</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="eventDetailsModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div
                class="inline-block align-bottom bg-gray-100 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full lg:max-w-3xl xl:max-w-3xl">
                <div class="bg-gray-100 p-6">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-xl font-semibold model_title">Chi tiết sự kiện</h2>
                        <button class="text-gray-600 hover:text-gray-900 text-3xl" onclick="closeModal()">&times;</button>
                    </div>
                    <div class="mb-4">
                        <button id="exportExcelBtn"
                            class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-sm ease-in transition-all">Xuất
                            Excel</button>
                    </div>
                    <div id="eventDetailsContent" class="rounded-sm overflow-hidden">
                        <!-- Nội dung chi tiết sự kiện sẽ được tải vào đây -->
                    </div>
                    <canvas id="eventChart" width="400" height="200" class="hidden"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        let eventChart = null;

        function showEventDetails(eventId) {
            eventDetailsContent.innerHTML = '<p>Đang tải...</p>';
            fetch(`{{ route('events.details', ['id' => ':id']) }}`.replace(':id', eventId))
                .then(response => response.json())
                .then(data => {
                    const eventDetailsContent = document.getElementById('eventDetailsContent');
                    const chartCanvas = document.getElementById('eventChart');
                    const chartContext = chartCanvas.getContext('2d');

                    if (data.event.students.length === 0) {
                        eventDetailsContent.innerHTML =
                            `<p><em class="text-lg text-red-500">Không có sinh viên nào tham gia sự kiện này.</em></p>`;
                        document.getElementById('exportExcelBtn').style.display =
                            'none'; // Ẩn nút xuất Excel nếu không có sinh viên
                        document.getElementById('eventDetailsModal').classList.remove('hidden');
                        return;
                    }

                    eventDetailsContent.innerHTML = `
                    <p><strong>Tên sự kiện:</strong> ${data.event.name}</p>
                    <p><strong>Tổng sinh viên tham gia:</strong> ${data.event.students.length}</p>
                    <p><strong>Ngày bắt đầu:</strong> ${formatDate(data.event.event_start)}</p>
                    <p><strong>Ngày kết thúc:</strong> ${formatDate(data.event.event_end)}</p>
                `;

                    const classLabels = Object.keys(data.classStatistics);
                    const classCounts = Object.values(data.classStatistics);
                    chartCanvas.classList.remove('hidden');
                    eventChart = new Chart(chartContext, {
                        type: 'bar',
                        data: {
                            labels: classLabels,
                            datasets: [{
                                label: 'Số lượng sinh viên tham gia',
                                data: classCounts,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    document.getElementById('exportExcelBtn').onclick = function() {
                        window.location.href = `{{ route('events.export.excel', ['eventId' => ':eventId']) }}`
                            .replace(':eventId', eventId);
                    };
                    document.querySelector('.model_title').innerText = `Chi tiết sự kiện`;
                    document.getElementById('eventDetailsModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching event details:', error);
                });
        }

        function closeModal() {
            document.getElementById('exportExcelBtn').style.display = 'flex';
            document.getElementById('eventDetailsModal').classList.add('hidden');
            if (eventChart) {
                eventChart.destroy();
                eventChart = null;
            }
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const hours = date.getHours();
            const ampm = hours >= 12 ? 'PM' : 'AM';
            const formattedHours = hours % 12 || 12;
            const minutes = date.getMinutes().toString().padStart(2, '0');
            const day = date.getDate().toString().padStart(2, '0');
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const year = date.getFullYear();
            return `${formattedHours}:${minutes} ${ampm} ${day}-${month}-${year}`;
        }

        function showListParticipants(eventId) {
            const chartCanvas = document.getElementById('eventChart');
            chartCanvas.classList.add('hidden');
            eventDetailsContent.innerHTML = '<p>Đang tải...</p>';
            fetch(`{{ route('events.participants', ['id' => ':id']) }}`.replace(':id', eventId))
                .then(response => response.json())
                .then(data => {
                    if (data.data.length === 0) {

                        document.getElementById('exportExcelBtn').style.display =
                            'none';
                        eventDetailsContent.innerHTML =
                            `<p><em class="text-lg text-red-500">Không có sinh viên nào tham gia sự kiện này.</em></p>`;
                        document.getElementById('eventDetailsModal').classList.remove('hidden');
                        return;
                    } else {
                        // Create table
                        const table = document.createElement('table');
                        table.classList.add("w-full", "text-sm", "text-left", "text-gray-500", "dark:text-gray-400");
                        const tableBody = document.createElement('tbody');
                        const tableHeader = document.createElement('thead');

                        // Create table header
                        tableHeader.classList.add("text-xs", "text-gray-700", "uppercase", "bg-gray-50",
                            "dark:bg-gray-700", "dark:text-gray-400", "text-center");
                        tableHeader.innerHTML = `
                            <tr>
                                <th class="px-6 py-4">STT</th>
                                <th class="px-6 py-4">Mã sinh viên</th>
                                <th class="px-6 py-4">Họ và tên</th>
                                <th class="px-6 py-4">Lớp</th>
                            </tr>
                        `;

                        data.data.forEach((student, index) => {
                            // console.log(student);
                            // Create table body
                            const tr = document.createElement('tr');

                            tr.classList.add("bg-white", "border-b", "dark:bg-gray-800",
                                "dark:border-gray-700");
                            tr.innerHTML = `
                                <td class="px-6 py-4 text-center">${index + 1}</td>
                                <td class="px-6 py-4 text-center">${student.pivot.student_id}</td>
                                <td class="px-6 py-4 text-center">${student.fullname}</td>
                                <td class="px-6 py-4 text-center">${student.classname}</td>
                            `;

                            tableBody.appendChild(tr);
                        })

                        table.appendChild(tableHeader);
                        table.appendChild(tableBody);
                        eventDetailsContent.innerHTML = '';

                        document.querySelector('.model_title').innerText = `Danh sách sinh viên tham gia sự kiện`;
                        eventDetailsContent.appendChild(table);
                        document.getElementById('exportExcelBtn').onclick = function() {
                            window.location.href = `{{ route('events.export.excel', ['eventId' => ':eventId']) }}`
                                .replace(':eventId', eventId);
                        };
                        document.getElementById('eventDetailsModal').classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error fetching participants:', error);
                });
        }
    </script>
@endsection
