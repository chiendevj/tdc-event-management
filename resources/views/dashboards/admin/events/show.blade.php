@extends('layouts.admin')

@section('title', 'Chi tiết')

@section('content')
<link rel="stylesheet" href="{{ asset('css/ckeditor.css') }}">
<div class="w-full container mx-auto detail">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
        <div class="col-span-12 md:col-span-8 p-4">
            <h2 class="text-lg font-bold mt-4">Nội dung của sự kiện</h2>
            <div class="content ck-content">
                {!! $event->content !!}
            </div>
            <h2 class="text-lg font-bold mt-4">Danh sách sinh viên đã đăng ký tham gia</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <!-- Table Headers -->
                    <thead class="text-xs text-gray-700 uppercase bg-gray-300 dark:bg-gray-700 dark:text-gray-400">
                        <!-- Header Rows -->
                        <tr>
                            <th scope="col" class="px-6 py-3 text-sm">
                                Mã sinh viên
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-sm">
                                Họ và tên
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-sm">
                                Lớp
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-sm">
                                Email
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Student Data Rows -->
                        @forelse($students as $student)
                            <tr class="bg-gray-100 border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white break-words whitespace-normal">
                                    {{ $student->id }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $student->fullname }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $student->classname }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $student->id . '@mail.tdc.edu.vn' }}
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-gray-100 border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="4" class="border px-4 py-2 text-center">Không có sinh viên nào đăng ký</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-span-12 md:col-span-4 p-4">
            <h2 class="text-lg font-bold">Biểu đồ số lượng sinh viên đăng ký và tham gia</h2>
            <canvas id="classChart" width="300" height="300"></canvas>
        </div>
        <div class="col-span-12 p-4">
            <h2 class="text-lg font-bold mt-4">Thông tin chi tiết khác</h2>
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <!-- Additional Details Table -->
                <thead class="text-xs text-gray-700 uppercase bg-gray-300 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-sm">
                            Thuộc tính
                        </th>
                        <th scope="col" class="px-6 py-3 text-sm">
                            Giá trị
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-gray-100 border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4 font-medium">Ngày bắt đầu</td>
                        <td class="px-6 py-4">{{ $event->event_start }}</td>
                    </tr>
                    <tr class="bg-gray-200 border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4 font-medium">Ngày kết thúc</td>
                        <td class="px-6 py-4">{{ $event->event_end }}</td>
                    </tr>
                    <tr class="bg-gray-100 border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4 font-medium">Địa điểm</td>
                        <td class="px-6 py-4">{{ $event->location }}</td>
                    </tr>
                    <tr class="bg-gray-200 border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4 font-medium">Trạng thái</td>
                        <td class="px-6 py-4">{{ $event->status }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-span-12 p-4">
            <div class="fb-share-button" data-href="{{ $url }}" data-layout="button_count" data-size="large">
                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">
                    Chia sẻ
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('classChart').getContext('2d');
        var registeredCounts = @json($registeredCounts);
        var attendedCounts = @json($attendedCounts);
        var labels = Object.keys(registeredCounts);

        var classChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Sinh viên đăng ký',
                        data: Object.values(registeredCounts),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        fill: false
                    },
                    {
                        label: 'Sinh viên tham gia',
                        data: Object.values(attendedCounts),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: false
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
