@extends('layouts.admin')

@section('title', 'Sự kiện')

@section('content')
<link href="{{ asset('css/ckeditor.css') }}" rel="stylesheet">
<div class="container mx-auto mt-[40px] px-8 py-4 ck-content">
    {!! $event->content !!}
</div>
@endsection
