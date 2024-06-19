@extends('layouts.admin')

@section('title', 'Create new Events')

@section('content')
    <div class="container mx-auto mt-[40px]">
        <div class="flex items-center lg:flex-row justify-between gap-4 flex-col sm:gap-4 mb-[20px]">
            <h3 class="uppercase block p-2 font-semibold rounded-sm text-white bg-[var(--dark-bg)] w-fit">
                Danh sách các sự kiện</h3>
            <div class="relative border flex items-center justify-start p-2">
                <input type="text" placeholder="Tìm kiếm sự kiện" class=" outline-none rounded-sm min-w-[400px]">

                <div class="text-gray-400">
                    <i class="fa-light fa-magnifying-glass"></i>
                </div>
            </div>
        </div>
        <div class="w-full flex items-center justify-end">
            <a href="{{ route('events.create') }}"
                class="block p-2 bg-[var(--dark-bg)] text-white rounded-sm ml-auto w-fit">Tạo sự kiện mới</a>
        </div>
        <div class="grid lg:grid-cols-4 sm:grid-cols-2 gap-4 mt-[20px] list_events">
            @foreach ($events as $event)
                <x-admin.event :event="$event" />
            @endforeach
        </div>
        <div class="loadmore_animate hidden items-center justify-center relative">
            <div class="dot-spinner">
                <div class="dot-spinner__dot"></div>
                <div class="dot-spinner__dot"></div>
                <div class="dot-spinner__dot"></div>
                <div class="dot-spinner__dot"></div>
                <div class="dot-spinner__dot"></div>
                <div class="dot-spinner__dot"></div>
                <div class="dot-spinner__dot"></div>
                <div class="dot-spinner__dot"></div>
            </div>
        </div>
    </div>

    <script>
        let page = 1;
        let lastPage = {{ $events->lastPage() }};
        const loadingAnimation = document.querySelector('.loadmore_animate');
        let isLoading = false;

        async function loadmore(page) {
            loadingAnimation.classList.remove('hidden');
            loadingAnimation.classList.add('flex');
            fetch(`/api/events/more?page=${page}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    isLoading = false;
                    if (data.data.data.length > 0) {
                        data.data.data.forEach(event => {
                            const eventItem = document.createElement('div');
                            const route = "{{ route('events.show', ':id') }}".replace(':id', event.id);
                            eventItem.classList.add('event_item', 'border', 'rounded-sm',
                                'overflow-hidden');
                            eventItem.innerHTML = `
                                <a href="${route}">
                                    <div class="overflow-hidden">
                                        <img src="${event.event_photo}" alt="" class="w-full overflow-hidden hover:scale-105 transition-all duration-100 ease-in">
                                    </div>
                                    <div class="p-2">
                                        <h3 class="text-lg font-semibold uppercase">${event.name}</h3>
                                        <p class="text-gray-400">${event.location}</p>
                                    </div>
                                </a>
                            `;
                            document.querySelector('.list_events').appendChild(eventItem);
                            loadingAnimation.classList.remove('flex');
                            loadingAnimation.classList.add('hidden');
                        });
                    }
                });
        }

        window.addEventListener('scroll', () => {
            console.log(window.innerHeight + window.scrollY);
            console.log(document.body.offsetHeight);
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
                if (!isLoading) {
                    isLoading = true;
                    page++;
                    if (page <= lastPage) {
                        loadmore(page);
                    }
                }
            }
        });
    </script>
@endsection
