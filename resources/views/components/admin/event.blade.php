<div class="event_item border rounded-sm overflow-hidden">
    <a href="{{ route('events.show', $event->id) }}">
        <div class="overflow-hidden relative">
            <img src="{{ $event->event_photo }}" alt=""
                class="w-full overflow-hidden hover:scale-105 transition-all event_img duration-100 ease-in">
            <div class="action_hover absolute top-0 left-0 bottom-0 flex items-center justify-center right-0 bg-[rgba(0,0,0,0.2)]"
                style="backdrop-filter: blur(5px)">
                <div class="flex items-center justify-center gap-2">
                    <a href=""
                        class="btn_edit btn_action relative flex items-center justify-center p-4 rounded-sm bg-white text-black w-[36px] h-[36px]">
                        <i class="fa-light fa-pen-to-square"></i>
                        <div
                            class="absolute z-10 w-fit text-nowrap top-[-100%] inline-block px-3 py-2 text-[12px]  text-white transition-opacity duration-300 rounded-sm shadow-sm tooltip bg-gray-700">
                            Chỉnh sửa sự kiện
                            <div class="tooltip-arrow absolute bottom-0"></div>
                        </div>
                    </a>

                    <a href=""
                        class="btn_qr btn_action flex items-center justify-center p-4 rounded-sm bg-white text-black w-[36px] h-[36px]">
                        <i class="fa-light fa-qrcode"></i>
                        <div
                            class="absolute z-10 w-fit text-nowrap top-[-100%] inline-block px-3 py-2 text-[12px]  text-white transition-opacity duration-300 rounded-sm shadow-sm tooltip bg-gray-700">
                            Mã QR của sự kiện
                            <div class="tooltip-arrow absolute bottom-0"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="p-2">
            <h3 class="text-lg font-semibold uppercase">{{ $event->name }}</h3>
            <p class="text-gray-400">{{ $event->location }}</p>
        </div>
    </a>
</div>
