@extends('layouts.app')

@section('title', $event->name . '| Event Zone FIT-TDC')

@section('content')
<link rel="stylesheet" href="{{ asset('css/ckeditor.css') }}">
<div class="w-[92%] container mx-auto detail mt_container">
    <div class="grid grid-cols-1 xl:grid-cols-12 xl:gap-4 lg:gap-2">
        <div class="xl:col-span-8 xl:p-4 lg:col-6 lg:gap-2">
            <h2 class="md:text-3xl text-base font-bold md:pb-6 pb-4">{{$event->name}}</h2>
            <p class="md:text-base text-xs italic text-gray-500 md:pb-6 pb-3">
            </p>
            <div class="banner">
                <img src="{{ $event->event_photo }}" alt="" srcset="">
            </div>
            <div class="event-details">
                <h4>Thông Tin Sự Kiện</h4>
                <ul class="event-info">
                    <li><strong>Ngày bắt đầu đăng ký:</strong> {{ \Carbon\Carbon::parse($event->registration_start)->format('H:i d/m/Y') }}</li>
                    <li><strong>Ngày kết thúc đăng ký:</strong> {{ \Carbon\Carbon::parse($event->registration_end)->format('H:i d/m/Y') }}</li>
                    <li><strong>Ngày diễn ra:</strong> {{ \Carbon\Carbon::parse($event->event_start)->format('H:i d/m/Y') }}</li>
                    <li><strong>Địa điểm:</strong> {{$event->location}}</li>
                </ul>
            </div>
            <div class="mt-11">
                <div>
                    <p class="mb-5 font-bold md:inline mr-3">Đăng ký tham gia tại đây</p>
                    <a href="{{$event->registration_link}}" class="py-2 mx-5 btn-register">Đăng ký</a>
                </div>
                <p class="font-bold mt-5 mb-2" >Hoặc quét mã dưới đây để đăng ký</p>
                <div id="qrCodeSvg">
                    {!! $registrationCode !!}
                </div>
            </div>
            <div class="mt-11 ck-content">
                {!! $event->content !!}
            </div>
        </div>
        <div class="col-span-4  p-4">
            <!-- Nội dung của cột 20% -->
            @if (count($upcomingEvents) > 0)
            <h1 class="title font-bold uppercase"><span>Sắp diễn ra</span></h1>
            <div class="owl-carousel upcoming-carousel  owl-theme">
                @foreach ($upcomingEvents as $event)
                <div class="m-2 event-card">
                    <a href="{{ route('events.detail', ['name' => Str::slug($event->name) , 'id' => $event->id]) }}">
                        <div class="background">
                            <img src="{{$event->event_photo}}" alt="">
                        </div>
                        <div class="content px-4 py-2">
                            <div class="event-title">
                                <a>
                                    {{$event->name}}
                                </a>
                            </div>
                            <div class="event-desc">
                                <div class="event-tag event-time"><i class="fa-light fa-calendar"></i><span>{{\Carbon\Carbon::parse($event->start)->format('H:i d/m/Y')}}</span></div>
                                    <div class="event-tag event-location"><i class="fa-light fa-location-dot"></i><span>{{$event->location}}</span></div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
