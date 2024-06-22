@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
    <div class="w-[92%] container mx-auto">
        <div class="big-event">
            <h1 class="title font-bold capitalize">Sự kiện <span>nổi bật</span></h1>
            <div class="mt-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                    <div class="p-4 event-card">
                        <div class="background">
                            <img src="{{ asset('assets/images/workshop1.jpg') }}" alt="">
                        </div>
                        <div class="content">
                            <div class="event-title">
                                <a>
                                    Xây dựng thương hiệu cá nhân
                                </a>
                            </div>
                            <div class="event-desc">
                                <div class="event-time"><span>8:00 18/6/2024</span></div>
                                <div class="event-location"><span>Hội trường D</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 event-card">
                        <div class="background">
                            <img src="{{ asset('assets/images/workshop2.jpg') }}" alt="">
                        </div>
                        <div class="content">
                            <div class="event-title">
                                <a>
                                    Cuộc thi web dev challanges
                                </a>
                            </div>
                            <div class="event-desc">
                                <div class="event-time"><span>14:30 18/5/2024</span></div>
                                <div class="event-location"><span>Tại phòng B002B</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


