@extends('layouts.admin')

@section('title', 'Thống kê')

@section('content')

<div class="p-4">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <h1 class="text-2xl font-semibold mb-4">Thống kê sự kiện</h1>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Tên sự kiện
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Số lượng sinh viên
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Chi tiết
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $event->name }}
                        </th>
                        <td class="px-6 py-4 text-center">
                            {{ $event->students_count }}
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-blue-600 hover:underline dark:text-blue-500" onclick="showEventDetails('{{ $event->id }}')">Chi tiết</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="eventDetailsModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-gray-100 rounded-lg shadow-lg p-6 w-full max-w-2xl">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Chi tiết sự kiện</h2>
                <button class="text-gray-600 hover:text-gray-900 text-3xl" onclick="closeModal()">&times;</button>
            </div>
            <div id="eventDetailsContent">
                <!-- Nội dung chi tiết sự kiện sẽ được tải vào đây -->
            </div>
            <div class="mt-4">
                <button id="exportExcelBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Xuất Excel</button>
            </div>
            <canvas id="eventChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let eventChart = null; // Variable to store the chart instance

    function showEventDetails(eventId) {
        fetch(`{{ route('events.details', ['id' => ':id']) }}`.replace(':id', eventId))
            .then(response => response.json())
            .then(data => {
                const eventDetailsContent = document.getElementById('eventDetailsContent');
                const chartCanvas = document.getElementById('eventChart');
                const chartContext = chartCanvas.getContext('2d');

                if (data.event.students.length === 0) {
                    eventDetailsContent.innerHTML = `<p><em class="text-lg text-red-500">Không có sinh viên nào tham gia sự kiện này.</em></p>`;
                    document.getElementById('exportExcelBtn').style.display = 'none'; // Ẩn nút xuất Excel nếu không có sinh viên
                    document.getElementById('eventDetailsModal').classList.remove('hidden');
                    return;
                }

                eventDetailsContent.innerHTML = `
                    <p><strong>Tên sự kiện:</strong> ${data.event.name}</p>
                    <p><strong>Tổng sinh viên:</strong> ${data.event.students.length}</p>
                    <p><strong>Ngày bắt đầu:</strong> ${formatDate(data.event.event_start)}</p>
                    <p><strong>Ngày kết thúc:</strong> ${formatDate(data.event.event_end)}</p>
                `;

                const classLabels = Object.keys(data.classStatistics);
                const classCounts = Object.values(data.classStatistics);

                eventChart = new Chart(chartContext, {
                    type: 'bar',
                    data: {
                        labels: classLabels,
                        datasets: [{
                            label: 'Số lượng sinh viên',
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
                    window.location.href = `{{ route('events.export.excel', ['eventId' => ':eventId']) }}`.replace(':eventId', eventId);
                };

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
        const formattedHours = hours % 12 || 12; // Convert hours to 12-hour format
        const minutes = date.getMinutes().toString().padStart(2, '0');
        const day = date.getDate().toString().padStart(2, '0');
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const year = date.getFullYear();
        return `${formattedHours}:${minutes} ${ampm} ${day}/${month}/${year}`;
    }
</script>

@endsection