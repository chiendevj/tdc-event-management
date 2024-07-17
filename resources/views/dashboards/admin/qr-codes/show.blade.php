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
    </style>
</head>

<body>
    <div class="py-4">
        @php 
        $chunks = array_chunk($qrCodes, 14); 
        function truncateWords($string, $limit, $end = '...')
        {
            if (str_word_count($string, 0) > $limit) {
                $words = str_word_count($string, 2);
                $pos = array_keys($words);
                $string = substr($string, 0, $pos[$limit]) . $end;
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
                                <h3 class="text-base md:text-lg font-semibold pb-[5px]">
                                    {{ truncateWords($event_name, 12) }}
                                </h3>
                                <div class="text-sm md:text-base font-bold italic">Mã chỉ có giá trị 1 lần điểm danh.</div>
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
