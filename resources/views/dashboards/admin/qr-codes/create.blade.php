@extends('layouts.admin')

@section('title', 'Create QR')

@section('content')
<div class="container mx-auto md:w-[50%] h-96">
    <div class="py-3 px-5 shadow-[0_0_5px_rgba(0,0,0,0.3)] mt-3 rounded-[5px]">
        <form action="{{ route('qr-codes.store', ['id' => $eventId]) }}" method="POST">
            @csrf
            <label for="quantity" class="block pb-3"> <span class="font-medium">Số lượng mã cần tạo</span></label>
            <div class="flex gap-8">
                <input type="number" class="grow border py-[10px] px-4 rounded-md" name="quantity" id="" min="1" max="300">
                <button type="submit" class="bg-[#04397f] text-white px-5 py-[10px] rounded-md" >
                   @if ($codeCount > 0)
                    Tạo thêm
                   @else
                   Tạo
                   @endif 
                </button>
            </div>
        </form>
    </div>
    <div class="py-3 px-5 shadow-[0_0_5px_rgba(0,0,0,0.3)] mt-3 rounded-[5px]">
            <div class="block pb-3"> <span class="font-medium">Số lượng QR đã được tạo</span></div>
            <div class="flex justify-between">
                <div>{{$codeCount}}</div>
                <a href="{{route('qr-codes.show', ['id' => $eventId])}}" class="bg-[#04397f] text-white px-5 py-[10px] rounded-md" >Xem</a>
            </div>
    </div>
</div>
@endsection