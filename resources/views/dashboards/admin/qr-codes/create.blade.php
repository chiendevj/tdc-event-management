@extends('layouts.admin')

@section('title', 'Create QR')

@section('content')
    <div class="container mx-auto md:w-[50%]">
        <div class="py-3 px-5 shadow-[0_0_5px_rgba(0,0,0,0.3)] mt-3 rounded-[5px]">
            <form id="qr-code-form" action="{{ route('qr-codes.store', ['id' => $eventId]) }}" method="POST">
                @csrf
                <label for="quantity" class="block pb-3"> <span class="font-medium">Số lượng mã cần tạo</span></label>
                <div class="flex gap-8">
                    <input type="number" class="grow border py-[10px] px-4 rounded-md" name="quantity" id=""
                        min="1" max="300">
                    <button type="submit" class="bg-[#04397f] text-white px-5 py-[10px] rounded-md hover:bg-[#1c5fb7]">
                        @if ($totalCount > 0)
                            Tạo thêm
                        @else
                            Tạo
                        @endif
                    </button>
                </div>
            </form>
        </div>
        <div class="py-3 px-5 shadow-[0_0_5px_rgba(0,0,0,0.3)] mt-3 rounded-[5px]">
            <div class="block pb-3"> <span class="font-medium">Tổng số lượng QR đã được tạo</span></div>
            <div class="flex justify-between">
                <div>{{ $totalCount }}</div>
                <a href="{{ route('qr-codes.show', ['id' => $eventId]) }}"
                    class="bg-[#04397f] text-white px-5 py-[10px] rounded-md hover:bg-[#1c5fb7]">Xem</a>
            </div>
        </div>
        @foreach ($countCreatedCodes as $countCreatedCode)
            <div class="py-3 px-5 shadow-[0_0_5px_rgba(0,0,0,0.3)] mt-3 rounded-[5px]">
                <div class="block pb-3"> <span class="font-medium">Ngày:
                        {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i', $countCreatedCode->datetime)->format('d-m-Y H:i') }}
                    </span></div>
                <div class="flex justify-between">
                    <div>{{ $countCreatedCode->count }}</div>
                    <form action="{{ route('qr-codes.delete', ['id' => $eventId]) }}" method="POST"
                        onsubmit="confirm('Bạn có muốn xóa số mã này?')">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="datetime" value="{{ $countCreatedCode->datetime }}">
                        <button type="submit" class="bg-red-500 text-white px-5 py-[10px] rounded-md hover:bg-red-600"><i
                                class="fa-regular fa-trash-can"></i></button>
                    </form>
                </div>
            </div>
        @endforeach

        <!-- Loading -->

        <div id="qr_loading" style="display: none">
            <style>
                .loader-dots div {
                    animation-timing-function: cubic-bezier(0, 1, 1, 0);
                }

                .loader-dots div:nth-child(1) {
                    left: 8px;
                    animation: loader-dots1 0.6s infinite;
                }

                .loader-dots div:nth-child(2) {
                    left: 8px;
                    animation: loader-dots2 0.6s infinite;
                }

                .loader-dots div:nth-child(3) {
                    left: 32px;
                    animation: loader-dots2 0.6s infinite;
                }

                .loader-dots div:nth-child(4) {
                    left: 56px;
                    animation: loader-dots3 0.6s infinite;
                }

                @keyframes loader-dots1 {
                    0% {
                        transform: scale(0);
                    }

                    100% {
                        transform: scale(1);
                    }
                }

                @keyframes loader-dots3 {
                    0% {
                        transform: scale(1);
                    }

                    100% {
                        transform: scale(0);
                    }
                }

                @keyframes loader-dots2 {
                    0% {
                        transform: translate(0, 0);
                    }

                    100% {
                        transform: translate(24px, 0);
                    }
                }
            </style>
            <div class="fixed top-0 left-0 z-50 w-screen h-screen flex items-center justify-center"
                style="background: rgba(0, 0, 0, 0.3);">
                <div class="bg-white border py-2 px-5 rounded-lg flex items-center flex-col">
                    <div class="loader-dots block relative w-20 h-5 mt-2">
                        <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-[#04397f]"></div>
                        <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-[#04397f]"></div>
                        <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-[#04397f]"></div>
                        <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-[#04397f]"></div>
                    </div>
                    <div class="text-gray-500 text-sm font-medium mt-2 text-center px-7">
                        Đang tạo mã...
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('qr-code-form');
            const loading = document.getElementById('qr_loading');

            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                loading.style.display = 'block';

                const formData = new FormData(form);
                
                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    })
                    
                    const data = await response.json();
                    
                    if(data.success) {
                        window.location.href = "{{ route('qr-codes.show', ['id' => $eventId]) }}";

                    }else {
                        console.error("Fail to generate QR code: ", data);
                    }
                } catch (error) {
                    console.error("Error QR code: ", error);
                }
                finally {
                    loading.style.display = 'none';
                }

            });
        })
    </script>
@endsection
