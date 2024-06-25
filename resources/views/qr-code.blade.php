@extends('layouts.app')

@section('title', 'Tra cứu')

@section('content')

<div class="container text-center">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach ($qrCodes as $index => $qrCode)
        <div class="p-4">
            <p>Số thứ tự: {{ $index }}</p>
            {!! $qrCode !!}
        </div>
         @endforeach
    </div>
        
</div>

@endsection