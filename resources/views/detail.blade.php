@extends('layouts.app')

@section('title', 'Chi tiết')

@section('content')
<div class="w-[92%] container mx-auto detail">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
        <div class="col-span-8 p-4">
            <h2 class="md:text-3xl text-base  font-semibold md:pb-6 pb-4">Cuộc thi FIT Web Dev Challenges 2024, sân chơi học thuật cho sinh viên FIT-TDC</h2>
            <p class="md:text-base text-xs italic text-gray-500 md:pb-6 pb-3">
                Cuộc thi FIT Web Dev Challenges 2024 nhằm tạo sân chơi học thuật cho học sinh sinh viên, qua đó khích lệ tinh thần yêu thích, ham học hỏi, nâng cao tay nghề và phát huy tính sáng tạo. Đồng thời, tuyển chọn đội tuyển cho Hội thi HSSV Giỏi nghề TP.HCM năm 2025.
            </p>
            <div class="banner">
                <img src="{{ asset('assets/images/workshop2.jpg') }}" alt="" srcset="">
            </div>
            <div>
                Thời gian: 14h30
            </div>
        </div>
        <div class="col-span-4  p-4">
            <!-- Nội dung của cột 20% -->
            <h1 class="title font-bold capitalize">Sự kiện <span>nổi bật</span></h1>
            <div class="p-4 event-card">
                <div class="background">
                    <img src="{{ asset('assets/images/workshop.jpg') }}" alt="">
                </div>
                <div class="content">
                    <div class="event-title">
                        <a>
                            Workshop tìm hiểu về giấy
                        </a>
                    </div>
                    <div class="event-desc">
                        <div class="event-time"><span>7:00 18/6/2024</span></div>
                        <div class="event-location"><span>Hội trường D</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
