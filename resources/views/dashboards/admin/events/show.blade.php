@extends('layouts.admin')

@section('title', 'Chi tiết')

@section('content')
<link rel="stylesheet" href="{{ asset('css/ckeditor.css') }}">
<div class="w-full container mx-auto detail">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
        <div class="col-span-10 p-4">
            <div class="content ck-content">
            {!! $event->content !!}
            </div>
        </div>
        <div class="col-span-2  p-4">

        </div>
    </div>
</div>
@endsection
