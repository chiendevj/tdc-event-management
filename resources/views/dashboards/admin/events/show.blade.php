@extends('layouts.admin')

@section('title', 'Chi tiết')

@section('head')
    <!-- Open Graph Meta Tags for Facebook -->
    <meta property="og:title" content="{{ $event->name }}" />
    <meta property="og:description" content="{{ Str::limit(strip_tags($event->content), 100) }}" />
    <meta property="og:url" content="{{ Request::fullUrl() }}" />
    <meta property="og:type" content="article" />
    <!-- If you have an event image -->
    @if($event->image)
        <meta property="og:image" content="{{ asset('storage/' . $event->image) }}" />
    @endif
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/ckeditor.css') }}">
<div class="w-full container mx-auto detail">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
        <div class="col-span-10 p-4">
            <h2 class="md:text-5xl text-base font-extrabold md:pb-6 pb-4">{{$event->name}}</h2>

            <div class="content ck-content">
                {!! $event->content !!}
            </div>
        </div>
        <div class="col-span-2 p-4">
            <!-- Facebook Share Button -->
            <div class="fb-share-button" 
                data-href="{{ Request::fullUrl() }}" 
                data-layout="button" 
                data-size="large">
                <a target="_blank" 
                   href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}" 
                   class="fb-xfbml-parse-ignore">
                    Chia sẻ
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v12.0" nonce="YOUR_NONCE_VALUE"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var shareButton = document.querySelector('.fb-share-button a');
        shareButton.addEventListener('click', function(event) {
            event.preventDefault();
            var url = shareButton.href;
            window.open(url, 'facebook-share-dialog', 'width=800,height=600');
            return false;
        });
    });
</script>
@endsection
