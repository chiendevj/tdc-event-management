@extends('layouts.admin')

@section('title', 'Chỉnh sửa sự kiện')

@section('content')
    <div class="container mx-auto mt-[40px] px-8 py-4">
        <h3 class="uppercase block p-2 font-semibold rounded-sm text-white bg-[var(--dark-bg)] w-fit mb-[20px]">
            Chỉnh sửa sự kiện</h3>

        <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div
                class="border-2 border-dashed border-[var(--dark-bg)] choose_event_banner w-full flex items-center flex-col justify-center">
                <div class="banner_display">
                    <img src="{{ $event->event_photo }}" class="w-full h-full object-cover">
                </div>
                <label for="event_photo" class="cursor-pointer my-4">
                    Tải ảnh banner của sự kiện tại đây <span class="text-sm text-red-500">*</span>
                    <input type="file" id="event_photo" name="event_photo" hidden>
                    @error('event_photo')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </label>
            </div>

            <div class="mt-[40px] w-full">
                <div class="flex flex-col sm:flex-col lg:flex-row xl:flex-row gap-8 sm:gap-8 lg:gap-3 xl:gap-3">
                    <label for="name" class="flex flex-col items-start gap-2 w-full">
                        <span class="text-sm">Tên sự kiện <span class="text-sm text-red-500">*</span></span>
                        <input type="text" name="name" id="name" class="p-2 border rounded-sm outline-none w-full"
                            value="{{ old('name', $event->name) }}">
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </label>

                    <label for="location" class="flex flex-col items-start gap-2 w-full">
                        <span class="text-sm">Địa điểm diễn ra sự kiện <span class="text-sm text-red-500">*</span></span>
                        <input type="text" name="location" id="location" class="p-2 border rounded-sm outline-none w-full"
                            value="{{ old('location', $event->location) }}">
                        @error('location')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </label>
                </div>

                <div class="flex flex-col sm:flex-col lg:flex-row xl:flex-row gap-8 sm:gap-8 lg:gap-3 xl:gap-3 mt-8">
                    <label for="event_start" class=" flex flex-col items-start gap-2 w-full">
                        <span class="text-sm">Thời gian sự kiện bắt đầu diễn ra <span
                                class="text-sm text-red-500">*</span></span>
                        <input type="datetime-local" name="event_start" id="event_start"
                            class="p-2 border rounded-sm outline-none w-full"
                            value="{{ old('event_start', $event->event_start) }}">
                        @error('event_start')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </label>

                    <label for="event_end" class="flex flex-col items-start gap-2 w-full">
                        <span class="text-sm">Thời gian sự kiện kết thúc <span class="text-sm text-red-500">*</span></span>
                        <input type="datetime-local" name="event_end" id="event_end"
                            class="p-2 border rounded-sm outline-none w-full" value="{{ old('event_end', $event->event_end) }}">
                        @error('event_end')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </label>
                </div>

                <div class="flex flex-col sm:flex-col lg:flex-row xl:flex-row gap-8 sm:gap-8 lg:gap-3 xl:gap-3 mt-8">
                    <label for="registration_start" class="flex flex-col items-start gap-2 w-full">
                        <span class="text-sm">Thời gian bắt đầu mở đăng ký tham gia sự kiện <span
                                class="text-sm text-red-500">*</span></span>
                        <input type="datetime-local" name="registration_start" id="registration_start"
                            class="p-2 border rounded-sm outline-none w-full"
                            value="{{ old('registration_start', $event->registration_start) }}">
                        @error('registration_start')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </label>

                    <label for="registration_end" class="flex flex-col items-start gap-2 w-full">
                        <span class="text-sm">Thời gian đóng đăng ký tham gia sự kiện <span
                                class="text-sm text-red-500">*</span></span>
                        <input type="datetime-local" name="registration_end" id="registration_end"
                            class="p-2 border rounded-sm outline-none w-full"
                            value="{{ old('registration_end', $event->registration_end) }}">
                        @error('registration_end')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </label>
                </div>

                <div class="flex flex-col sm:flex-col lg:flex-row xl:flex-row gap-8 sm:gap-8 lg:gap-3 xl:gap-3 mt-8">
                    {{-- <label for="point" class="flex flex-col items-start gap-2 w-full">
                        <span class="text-sm">Điểm tham gia sự kiện <span class="text-sm text-red-500">*</span></span>
                        <input type="number" name="point" id="point" class="p-2 border rounded-sm outline-none w-full"
                            value="{{ old('point', $event->point) }}">
                        @error('point')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </label> --}}

                    <label for="status" class="flex flex-col items-start gap-2 w-full">
                        <span class="text-sm">Trạng thái của sự kiện <span class="text-sm text-red-500">*</span></span>
                        <select name="status" id="status" class="p-2 border rounded-sm outline-none w-full">
                            <option value="Sắp diễn ra" {{ old('status', $event->status) == 'Sắp diễn ra' ? 'selected' : '' }}>
                                Sắp diễn ra</option>
                            <option value="Đang diễn ra"
                                {{ old('status', $event->status) == 'Đang diễn ra' ? 'selected' : '' }}>Đang diễn ra</option>
                            <option value="Đã diễn ra" {{ old('status', $event->status) == 'Đã diễn ra' ? 'selected' : '' }}>Đã
                                diễn ra</option>
                            <option value="Đã hủy" {{ old('status', $event->status) == 'Đã hủy' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                        @error('status')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </label>
                </div>





                <div class="mt-8 flex flex-col items-start gap-2 w-full">
                    <span class="text-sm">Nội dung của sự kiện <span class="text-sm text-red-500">*</span></span>
                    <textarea name="content" id="editor">{{ old('content', $event->content) }}</textarea>
                    @error('content')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="mt-8 mb-10 py-2 px-4 bg-[var(--dark-bg)] text-white rounded-sm">Cập
                    nhật</button>
            </div>
        </form>
    </div>

    <script>
        const bannerDisplay = document.querySelector('.banner_display');
        const inputPhoto = document.querySelector('#event_photo');

        inputPhoto.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    const result = reader.result;
                    bannerDisplay.innerHTML = "";
                    bannerDisplay.innerHTML = `<img src="${result}" class="w-full h-full object-cover">`;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

@endsection
