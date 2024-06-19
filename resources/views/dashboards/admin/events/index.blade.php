@extends('layouts.admin')

@section('title', 'Sự kiện')

@section('content')
    <div class="container mx-auto mt-[40px]">
        <div class="flex items-center lg:flex-row justify-between gap-4 flex-col sm:gap-4 mb-[20px]">
            <h3 class="uppercase block p-2 font-semibold rounded-sm text-white bg-[var(--dark-bg)] w-fit">
                Danh sách các sự kiện</h3>
            <div class="flex items-center justify-between gap-3">
                <div class="relative border h-full flex items-center justify-start p-2">
                    <input type="text" name="search" placeholder="Tìm kiếm sự kiện"
                        class="outline-none rounded-sm min-w-[400px] min-h-[24px]">
                    <div class="text-gray-400">
                        <i class="fa-light fa-magnifying-glass"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full flex items-center justify-between">
            <div class="flex items-center justify-start gap-3">
                <div class="relative border flex items-center h-full justify-start p-2 text-gray-400">
                    <label for="filter_date_start">Ngày bắt đầu:</label>
                    <input type="date" name="filter_date_start" id="filter_date_start" class="border-none outline-none">
                </div>
                <div class="relative border flex items-center h-full justify-start p-2 text-gray-400">
                    <label for="filter_date_end">Ngày kết thúc:</label>
                    <input type="date" name="filter_date_end" id="filter_date_end" class="border-none outline-none">
                </div>
                <div class="relative border flex items-center h-full justify-start p-2 text-gray-400">
                    <select name="filter" id="filter" class="border-none outline-none min-h-[24px]">
                        <option value="all">Tất cả</option>
                        <option value="upcoming">Sắp diễn ra</option>
                        <option value="ongoing">Đang diễn ra</option>
                        <option value="past">Đã diễn ra</option>
                        <option value="newest">Mới nhất</option>
                        <option value="oldest">Cũ nhất</option>
                    </select>
                </div>
                <button class="h-full p-2 bg-[var(--dark-bg)] text-white border-[var(--dark-bg)] rounded-sm">Lọc sự
                    kiện</button>
            </div>
            @can('create event')
                <a href="{{ route('events.create') }}"
                    class="block p-2 bg-[var(--dark-bg)] text-white rounded-sm ml-auto w-fit">
                    Tạo sự kiện mới
                </a>
            @endcan
        </div>
        <div class="grid lg:grid-cols-4 sm:grid-cols-2 gap-4 mt-[20px] list_events min-h-[60vh]">
            {{-- @foreach ($events as $event)
                <x-admin.event :event="$event" />
            @endforeach --}}
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
        let searchPage = 1;
        let lastPage = {{ $events->lastPage() }};
        const loadingAnimation = document.querySelector('.loadmore_animate');
        const listEvents = document.querySelector('.list_events');
        const searchInput = document.querySelector('input[name="search"]');
        let isLoading = false;
        let isSearching = false;

        // Toggle loading
        function toggleLoadingAnimation(show) {
            if (show) {
                loadingAnimation.classList.remove('hidden');
                loadingAnimation.classList.add('flex');
            } else {
                loadingAnimation.classList.remove('flex');
                loadingAnimation.classList.add('hidden');
            }
        }

        // Create event item
        function createEventItem(event) {
            const eventItem = document.createElement('div');
            const route = "{{ route('events.show', ':id') }}".replace(':id', event.id);
            eventItem.classList.add('event_item', 'border', 'rounded-sm', 'overflow-hidden');
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
            return eventItem;
        }

        // Loadmore events
        async function loadMoreEvents() {
            if (isLoading) return;

            isLoading = true;
            toggleLoadingAnimation(true);

            const url = isSearching ?
                `/api/events/search?search=${searchInput.value}&page=${searchPage}` :
                `/api/events/more?page=${page}`;

            try {
                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    }
                });
                const data = await response.json();



                if (data.data.data.length > 0) {
                    data.data.data.forEach(event => listEvents.appendChild(createEventItem(event)));
                }
            } catch (error) {
                console.error('Error fetching events:', error);
            } finally {
                isLoading = false;
                toggleLoadingAnimation(false);
            }
        }

        // Search events
        async function handleSearch() {
            const searchValue = searchInput.value.trim();
            isSearching = searchValue.length > 0;
            page = 1;
            searchPage = 1;
            listEvents.innerHTML = '';
            loadMoreEvents();
        }

        // Scroll event
        window.addEventListener('scroll', () => {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100 && !isLoading) {
                if (isSearching && searchPage < lastPage) {
                    searchPage++;
                    loadMoreEvents();
                } else if (!isSearching && page < lastPage) {
                    page++;
                    loadMoreEvents();
                }
            }
        });

        // Search event
        searchInput.addEventListener('input', handleSearch);

        // First load
        loadMoreEvents();
    </script>

@endsection
