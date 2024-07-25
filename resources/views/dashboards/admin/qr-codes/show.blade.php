<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .break-page {
            page-break-before: always;
        }

        svg {
            width: 80px;
            height: 80px;
        }
    </style>
</head>

<body>
    <div class="py-4">
        @php
            $chunks = array_chunk($qrCodes, 16);
            function truncateWords($string, $limit, $end = '...')
            {
                $words = preg_split('/\s+/', $string); 
                if (count($words) > $limit) {
                    $truncated = implode(' ', array_slice($words, 0, $limit));
                    return $truncated . $end;
                }
                return $string;
            }
        @endphp

        @foreach ($chunks as $chunk)
            <div class="grid grid-cols-2 gap-4 pb-4">
                @foreach ($chunk as $qrCode)
                    <div class="p-2 border-2 border-black">
                        <div class="flex items-center gap-4">
                            <div>{{ $qrCode->qrImage }}</div>
                            <div class="text-left">
                                <h3 class="text-[15px] font-semibold pb-[3px]">{{ truncateWords($event->name, 12) }}
                                </h3>
                                <p class="text-[13px] pb-[3px] font-semibold">Ngày
                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $event->event_start)->format('d-m-Y') }}
                                </p>
                                <div class="text-[14px] font-bold italic">Mã chỉ có giá trị 1 lần điểm danh.</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Thêm page-break nếu không phải trang cuối cùng --}}
            @if (!$loop->last)
                <div class="break-page"></div>
            @endif
        @endforeach
    </div>

</body>

</html>
