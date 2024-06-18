@extends('layouts.admin')

@section('title', 'Create new Events')

@section('content')
    <div class="container mx-auto mt-[40px]">
        <div class="flex items-center justify-between mb-[20px]">
            <h3 class="uppercase block p-2 font-semibold rounded-sm text-white bg-[var(--dark-bg)] w-fit">
                Danh sách các sự kiện</h3>
            <div class="relative border flex items-center justify-start p-2">
                <input type="text" placeholder="Tìm kiếm sự kiện" class=" outline-none rounded-sm min-w-[400px]">

                <div class="text-gray-400">
                    <i class="fa-light fa-magnifying-glass"></i>
                </div>
            </div>
        </div>
        <div class="w-full flex items-center justify-end">
            <a href="{{ route('events.create') }}"
                class="block p-2 bg-[var(--dark-bg)] text-white rounded-sm ml-auto w-fit">Tạo sự kiện mới</a>
        </div>
        <div class="grid grid-cols-4 gap-4 mt-[20px]">
            @foreach ($events as $event)
                <div class="event_item">
                    <a href="{{ route('events.show', $event->id) }}">
                      <div class="overflow-hidden">
                        <img src="{{ $event->event_photo }}" alt="" class="w-full overflow-hidden hover:scale-105 transition-all duration-100 ease-in">
                    </div>
                    <div class="p-2">
                        <h3 class="text-lg font-semibold uppercase">{{ $event->name }}</h3>
                        <p class="text-gray-400">{{ $event->location }}</p>
                    </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
