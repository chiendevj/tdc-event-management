@extends('layouts.admin')

@section('title', 'Create new Events')

@section('content')

    <div class="container mx-auto mt-[40px]">
        <h3 class="uppercase block p-2 font-semibold rounded-sm text-white bg-[var(--dark-bg)] w-fit mb-[20px]">
            Tạo sự kiện mới</h3>

        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div
                class="border-2 border-dashed border-[var(--dark-bg)] choose_event_banner w-full flex items-center justify-center">
                <div class="banner_display">
                    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                    <lottie-player src="https://lottie.host/4e363e08-db5c-4f9a-a357-dae55f4e24f1/qmLtQct7kp.json"
                        background="##FFFFFF" speed="1" style="width: 300px; height: 300px" loop autoplay direction="1"
                        mode="normal"></lottie-player>
                </div>
                <label for="event_photo" class="cursor-pointer">
                    Tải ảnh banner của sự kiện tại đây <span class="text-sm text-red-500">*</span>
                    <input type="file" id="event_photo" name="event_photo" hidden>
                    @error('event_photo')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </label>
            </div>

            <div class="mt-[40px] w-full">
                <label for="name" class="flex flex-col items-start gap-2 w-full">
                    <span class="text-sm">Tên sự kiện <span class="text-sm text-red-500">*</span></span>
                    <input type="text" name="name" id="name" class="p-2 border rounded-sm outline-none w-full"
                        value="{{ old('name') }}">
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </label>

                <label for="location" class="mt-8 flex flex-col items-start gap-2 w-full">
                    <span class="text-sm">Địa điểm diễn ra sự kiện <span class="text-sm text-red-500">*</span></span>
                    <input type="text" name="location" id="location" class="p-2 border rounded-sm outline-none w-full"
                        value="{{ old('location') }}">
                    @error('location')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </label>

                <label for="event_start" class="mt-8 flex flex-col items-start gap-2 w-full">
                    <span class="text-sm">Thời gian sự kiện bắt đầu diễn ra <span
                            class="text-sm text-red-500">*</span></span>
                    <input type="datetime-local" name="event_start" id="event_start"
                        class="p-2 border rounded-sm outline-none w-full" value="{{ old('event_start') }}">
                    @error('event_start')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </label>

                <label for="event_end" class="mt-8 flex flex-col items-start gap-2 w-full">
                    <span class="text-sm">Thời gian sự kiện kết thúc <span class="text-sm text-red-500">*</span></span>
                    <input type="datetime-local" name="event_end" id="event_end"
                        class="p-2 border rounded-sm outline-none w-full" value="{{ old('event_end') }}">
                    @error('event_end')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </label>

                <label for="registration_start" class="mt-8 flex flex-col items-start gap-2 w-full">
                    <span class="text-sm">Thời gian bắt đầu mở đăng ký tham gia sự kiện <span
                            class="text-sm text-red-500">*</span></span>
                    <input type="datetime-local" name="registration_start" id="registration_start"
                        class="p-2 border rounded-sm outline-none w-full" value="{{ old('registration_start') }}">
                    @error('registration_start')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </label>

                <label for="registration_end" class="mt-8 flex flex-col items-start gap-2 w-full">
                    <span class="text-sm">Thời gian đóng đăng ký tham gia sự kiện <span
                            class="text-sm text-red-500">*</span></span>
                    <input type="datetime-local" name="registration_end" id="registration_end"
                        class="p-2 border rounded-sm outline-none w-full" value="{{ old('registration_end') }}">
                    @error('registration_end')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </label>

                <label for="point" class="mt-8 flex flex-col items-start gap-2 w-full">
                    <span class="text-sm">Điểm tham gia sự kiện <span class="text-sm text-red-500">*</span></span>
                    <input type="number" name="point" id="point" class="p-2 border rounded-sm outline-none w-full"
                        value="{{ old('point', 4) }}">
                    @error('point')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </label>

                <button type="submit" class="mt-8 mb-10 py-2 px-4 bg-[var(--dark-bg)] text-white rounded-sm">Tạo</button>
            </div>
        </form>
    </div>

@endsection
