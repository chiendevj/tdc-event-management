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
        <div class="col-span-2 p-4">
            <div class="fb-share-button" data-href="https://www.facebook.com/tdc.fit" data-layout="button_count" data-size="large">
                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https://www.facebook.com/tdc.fit&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">
                    Chia sẻ
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection