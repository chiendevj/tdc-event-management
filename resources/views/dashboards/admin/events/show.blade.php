@extends('layouts.admin')

@section('title', 'Chi tiết')

@section('content')
<link rel="stylesheet" href="{{ asset('css/ckeditor.css') }}">
<div class="w-full container mx-auto detail">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
       <div class="col-span-12 md:col-span-8 p-4">
                <h1 class="font-bold my-4" style="color: #19a0e4; font-size: 25px">{{ $event->name }}</h1>
                <div class="banner">
                    <img src="{{ $event->event_photo }}" alt=""
                        srcset=""
                        style="width: 100%;
                        background-color: #fff;
                        box-shadow: 0 0 5px #ccc;
                        padding: 10px;">
                </div>
                <h2 class="text-md font-bold mt-4">Nội dung của sự kiện</h2>
                <div class="content ck-content">
                    {!! $event->content !!}
                </div>
            </div>
        <div class="col-span-12 md:col-span-4 p-4">
            <h2 class="text-lg font-bold">Biểu đồ số lượng sinh viên đăng ký và tham gia</h2>
            <canvas id="classChart" width="300" height="300"></canvas>
        </div>
        <div class="col-span-12 p-4">
            <h2 class="text-lg font-bold mt-4">Thông tin chi tiết khác</h2>
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-300 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-sm">Thuộc tính</th>
                        <th scope="col" class="px-6 py-3 text-sm">Giá trị</th>
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
                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('classChart').getContext('2d');
        var totalRegisteredCount = @json($totalRegisteredCount);
        var totalAttendedCount = @json($totalAttendedCount);

        var classChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Đăng ký', 'Tham gia'],
                datasets: [{
                    label: 'Số lượng sinh viên',
                    data: [totalRegisteredCount, totalAttendedCount],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            }
        });
    });
</script>
@endsection
