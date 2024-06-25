@extends('layouts.admin')

@section('title', 'Create QR')

@section('content')
<div class="p-28">
    <form action="{{ route('qr-codes.store', ['id' => $eventId]) }}" method="POST">
        @csrf
         <label for="quantity">Quantity:</label>
        <input type="number" class="border p-4" name="quantity" id="" min="1" max="300">
        <button type="submit" class="border p-4" >Create</button>
    </form>
</div>
@endsection