@extends('layouts.admin')

@section('title', 'Sự kiện')

@section('content')
    <div class="container mx-auto mt-[40px] px-8 py-4 div_wrapper">
        <div class="flex items-center lg:flex-row justify-between gap-4 flex-col sm:gap-4 mb-[20px]">
            <div class="flex items-center justify-center gap-3">
                <h3 class="uppercase block p-2 font-semibold rounded-sm text-white bg-[var(--dark-bg)] w-fit">
                    Danh sách các sự kiện</h3>
                @can('restore event')
                    <a href="{{ route('events.trash') }}"
                        class="uppercase block p-2 font-semibold rounded-sm text-white bg-[var(--dark-bg)] w-fit">
                        Thùng rác
                    </a>
                @endcan
            </div>
            <div class="flex items-center w-full lg:w-fit justify-between gap-3">
                <div class="relative border h-full w-full flex items-center justify-between p-2">
                    <input type="text" name="search" placeholder="Tìm kiếm sự kiện"
                        class="outline-none border-none p-0 rounded-sm min-w-[400px] min-h-[24px]">
                    <div class="text-gray-400">
                        <i class="fa-light fa-magnifying-glass"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full flex items-center justify-between flex-col gap-3 lg:flex-row">
            <div class="flex items-center w-full lg:w-fit justify-start gap-3 flex-col lg:flex-col xl:flex-row">
                <div class="relative border lg:w-fit flex items-center h-full justify-start p-2 text-gray-400 w-full">
                    <label for="filter_date_start" class="">Ngày bắt đầu:</label>
                    <input type="date" name="filter_date_start" id="filter_date_start"
                        class="border-none outline-none p-0 flex-1 lg:w-fit">
                </div>
                <div class="relative w-full lg:w-fit border flex items-center h-full justify-start p-2 text-gray-400">
                    <label for="filter_date_end">Ngày kết thúc:</label>
                    <input type="date" name="filter_date_end" id="filter_date_end"
                        class="border-none p-0 flex-1 outline-none lg:w-fit">
                </div>
                <div class="relative border flex items-center h-full justify-start p-2 text-gray-400 w-full xl:w-fit">
                    <select name="status" id="status" class="border-none outline-none min-h-[24px] w-full p-0">
                        <option value="all">Tất cả</option>
                        <option value="Sắp diễn ra">Sắp diễn ra</option>
                        <option value="Đang diễn ra">Đang diễn ra</option>
                        <option value="Đã diễn ra">Đã diễn ra</option>
                        {{-- <option value="newest">Mới nhất</option>
                        <option value="oldest">Cũ nhất</option> --}}
                        <option value="Đã hủy">Đã hủy</option>
                        <option value="featured">Sự kiện nổi bật</option>
                    </select>
                </div>
                <button
                    class="h-full p-2 bg-[var(--dark-bg)] hover:opacity-90 transition-all duration-100 ease-linear w-full xl:w-fit text-white border-[var(--dark-bg)] rounded-sm btn_filter">
                    Lọc sự kiện
                </button>
            </div>
            <div class="flex items-center justify-center gap-3 w-full lg:w-fit flex-col xl:flex-row">
                @can('create event')
                    <a href="{{ route('events.create') }}"
                        class="block p-2 bg-[var(--dark-bg)] hover:opacity-90 transition-all duration-100 ease-linear text-white rounded-sm lg:ml-auto xl:w-fit w-full text-center">
                        Tạo sự kiện mới
                    </a>
                    <button
                        class="btn_export_list block p-2 bg-[var(--dark-bg)] hover:opacity-90 transition-all duration-100 ease-linear text-white rounded-sm lg:ml-auto xl:w-fit w-full text-center">
                        Xuất danh sách hiện tại
                    </button>

                    <button
                        class="btn_export_all block p-2 bg-[var(--dark-bg)] hover:opacity-90 transition-all duration-100 ease-linear text-white rounded-sm lg:ml-auto xl:w-fit w-full text-center">
                        Xuất tất cả sự kiện
                    </button>
                @endcan

            </div>
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
        <div class="grid lg:grid-cols-3 xl:grid-cols-4 sm:grid-cols-2 gap-4 mt-[20px] list_events relative py-4">
            {{-- @foreach ($events as $event)
                <x-admin.event :event="$event" />
            @endforeach --}}
        </div>
    </div>

    <script>
        let page = 1;
        let searchPage = 1;
        let lastPage = {{ $events->lastPage() }};
        let isSearching = false;
        let isLoading = false;
        let preventLoad = false;
        let exportEvents = [];
        const loadingAnimation = document.querySelector('.loadmore_animate');
        const listEvents = document.querySelector('.list_events');
        const searchInput = document.querySelector('input[name="search"]');
        const btnFilter = document.querySelector('.btn_filter');
        const filterStartDate = document.querySelector('#filter_date_start');
        const filterEndDate = document.querySelector('#filter_date_end');
        const filterStatus = document.querySelector('#status');
        const btnExportExcel = document.querySelector('.btn_export_list');
        const btnExportExcelAll = document.querySelector('.btn_export_all');
        const container = document.querySelector('.div_wrapper');

        function showSkeletons() {
            for (let i = 0; i < 8; i++) {
                const skeleton = document.createElement('div');
                skeleton.classList.add('skeleton');
                listEvents.appendChild(skeleton);
            }
        }

        function removeSkeletons() {
            const skeletons = document.querySelectorAll('.skeleton');
            skeletons.forEach(skeleton => skeleton.remove());
        }

        // Lazy loading images
        function lazyLoad() {
            const lazyImages = document.querySelectorAll('img.lazy');
            lazyImages.forEach(img => {
                if (img.getBoundingClientRect().top < window.innerHeight && !img.classList.contains(
                        'lazy-loaded')) {
                    img.src = img.dataset.src;
                    img.onload = () => {
                        img.classList.add('lazy-loaded');
                    };
                }
            });
        }

        function toggleLoadingSkeleton(show) {
            if (show) {
                showSkeletons();
            } else {
                removeSkeletons();
            }
        }

        // Loadmore events
        async function loadMoreEvents() {
            if (isLoading) return;

            isLoading = true;
            toggleLoadingSkeleton(true);

            const startDate = filterStartDate.value;
            const endDate = filterEndDate.value;
            const status = filterStatus.value;

            const eventSearchRoute = "{{ route('events.search') }}" + `?search=${searchInput.value}&filter_date_start=${startDate}&filter_date_end=${endDate}&status=${status}&page=${searchPage}`;
            const eventMoreRoute = "{{ route('events.more') }}" + `?page=${page}`;

            const url = isSearching ?
                eventSearchRoute :
                eventMoreRoute;

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
                    data.data.data.forEach(event => {
                        exportEvents.push(event.id);
                        const eventItem = createEventItem(event);
                        listEvents.appendChild(eventItem);
                    });

                    lazyLoad();

                    if (isSearching && data.data.data.length < 8) {
                        preventLoad = true;
                    }
                } else {
                    if (isSearching && searchPage === 1) {
                        listEvents.innerHTML =
                            '<p class="text-center text-red-500 absolute w-full">Không có sự kiện nào</p>';
                        preventLoad = true;
                        exportEvents = [];
                    }
                }
            } catch (error) {
                console.error('Error fetching events:', error);
            } finally {
                isLoading = false;
                toggleLoadingSkeleton(false);
            }
        }

        function confirmDelete(event) {
            event.preventDefault();
            const userConfirmed = confirm("Bạn có chắc chắn muốn xóa sự kiện này?");
            if (userConfirmed) {
                window.location.href = event.currentTarget.href;
            }
        }

        function confirmCancel(event) {
            event.preventDefault();
            const userConfirmed = confirm("Bạn có chắc chắn muốn hủy sự kiện này?");
            if (userConfirmed) {
                window.location.href = event.currentTarget.href;
            }
        }

        function createEventItem(event) {
            // Event route
            const route = "{{ route('events.show', ':id') }}".replace(':id', event.id);
            const routeEdit = "{{ route('events.edit', ':id') }}".replace(':id', event.id);
            const routeDelete = "{{ route('events.move.trash', ':id') }}".replace(':id', event.id);
            const routeQR = "{{ route('qr-codes.create', ':id') }}".replace(':id', event.id);
            const routeCancel = "{{ route('events.cancel', ':id') }}".replace(':id', event.id);
            const routeFeature = "{{ route('events.featured', ':id') }}".replace(':id', event.id);


            const eventItem = document.createElement('div');
            const link = document.createElement('a');

            let isCanceled = false;

            // Check status of event
            let style = '';
            switch (event.status) {
                case 'Sắp diễn ra':
                    style = "event-upcoming"
                    break;
                case 'Đang diễn ra':
                    style = "event-ongoing"
                    break;
                case 'Đã diễn ra':
                    style = "event-past"
                    break;
                case 'Đã hủy':
                    isCanceled = true;
                    style = "event-cancelled"
                    break;
                default:
                    break;
            }

            // Check if event is featured
            const isFeatured = event.is_featured_event === 1;

            link.href = route;

            eventItem.classList.add('event_item', 'border', 'rounded-sm', 'overflow-hidden');

            link.innerHTML = `
                    <div class="overflow-hidden relative">
                        <img src="${event.event_photo}" alt="" class="overflow-hidden hover:scale-105 transition-all event_img duration-100 ease-in w-full">
                        <div class="action_hover absolute top-0 left-0 bottom-0 flex items-center justify-center right-0 bg-[rgba(0,0,0,0.2)]" style="backdrop-filter: blur(5px)">
                            <div class="flex items-center justify-center gap-2">
                                 @can('edit event')
                                 <a href="${routeEdit}" class="btn_edit btn_action relative flex items-center justify-center p-4 rounded-sm bg-white text-black w-[36px] h-[36px]">
                                    <i class="fa-light fa-pen-to-square"></i>
                                    <div class="absolute z-10 w-fit text-nowrap top-[-100%] inline-block px-3 py-2 text-[12px] text-white transition-opacity duration-300 rounded-sm shadow-sm tooltip bg-gray-700">
                                        Chỉnh sửa sự kiện
                                        <div class="tooltip-arrow absolute bottom-0"></div>
                                        </div>
                                    </a>
                                @endcan
                                @can('delete event')
                                <a href="${routeDelete}" class="btn_delete btn_action relative flex items-center justify-center p-4 rounded-sm bg-white text-black w-[36px] h-[36px]" onclick="return confirmDelete(event)">
                                    <i class="fa-light fa-trash"></i>
                                    <div class="absolute z-10 w-fit text-nowrap top-[-100%] inline-block px-3 py-2 text-[12px] text-white transition-opacity duration-300 rounded-sm shadow-sm tooltip bg-gray-700">
                                        Xóa sự kiện
                                        <div class="tooltip-arrow absolute bottom-0"></div>
                                    </div>
                                </a>
                                @endcan
                                 @can('cancel event')
                                ${!isCanceled ? `<a href="${routeCancel}" class="btn_qr btn_action flex items-center justify-center p-4 rounded-sm bg-white text-black w-[36px] h-[36px]" onclick="return confirmCancel(event)">
                                                    <i class="fa-light fa-ban"></i>
                                                    <div class="absolute z-10 w-fit text-nowrap top-[-100%] inline-block px-3 py-2 text-[12px] text-white transition-opacity duration-300 rounded-sm shadow-sm tooltip bg-gray-700">
                                                        Hủy sự kiện
                                                        <div class="tooltip-arrow absolute bottom-0"></div>
                                                        </div>
                                                        </a>` : ''}
                                @endcan
                                @can('qr event')
                                        <a href="${routeQR}" class="btn_qr btn_action flex items-center justify-center p-4 rounded-sm bg-white text-black w-[36px] h-[36px]">
                                            <i class="fa-light fa-qrcode"></i>
                                            <div class="absolute z-10 w-fit text-nowrap top-[-100%] inline-block px-3 py-2 text-[12px] text-white transition-opacity duration-300 rounded-sm shadow-sm tooltip bg-gray-700">
                                                Mã QR của sự kiện
                                                <div class="tooltip-arrow absolute bottom-0"></div>
                                            </div>
                                        </a>
                                @endcan
                                @can('featured event')
                                        <a href="${routeFeature}" class="btn_qr btn_action flex items-center justify-center p-4 rounded-sm bg-white text-black w-[36px] h-[36px]">
                                            <i class="fa-light fa-star  ${isFeatured ? 'text-yellow-400' : 'text-black'}"></i>
                                            <div class="absolute z-10 w-fit text-nowrap top-[-100%] inline-block px-3 py-2 text-[12px] text-white transition-opacity duration-300 rounded-sm shadow-sm tooltip bg-gray-700">
                                                Đánh dâu sự kiện nổi bật
                                                <div class="tooltip-arrow absolute bottom-0"></div>
                                            </div>
                                        </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="p-2">
                        <h3 class="text-lg font-semibold uppercase whitespace-nowrap overflow-hidden text-ellipsis">${event.name}</h3>
                        <p class="text-gray-400">${event.location}</p>
                        <p class="text-gray-400 px-2 mt-1 rounded-full text-white w-fit ${style}">${event.status}</p>
                    </div>
                `;

            eventItem.appendChild(link);
            return eventItem;
        }

        // Export events
        function exportEvent(type) {
            const url = "{{ route('events.export.excel.list') }}";
            if (type === "list") {
                if (exportEvents.length > 0) {
                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                type: type,
                                events: exportEvents
                            })
                        })
                        .then(response => {
                            if (response.ok) {
                                return response.blob();
                            } else {
                                throw new Error('Failed to download file');
                            }
                        })
                        .then(blob => {
                            const link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = 'events.xlsx';
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Có lỗi xảy ra khi xuất file Excel');
                        });
                } else {
                    alert('Không có sự kiện nào để xuất file Excel');
                }
            } else if (type === "all") {
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            type: type,
                        })
                    })
                    .then(response => {
                        if (response.ok) {
                            return response.blob();
                        } else {
                            throw new Error('Failed to download file');
                        }
                    })
                    .then(blob => {
                        const link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = 'events.xlsx';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Có lỗi xảy ra khi xuất file Excel');
                    });
            }
        }

        window.addEventListener('scroll', lazyLoad);
        window.addEventListener('resize', lazyLoad);

        // Debounce
        function debounce(func, delay) {
            let debounceTimer;
            return function() {
                const context = this;
                const args = arguments;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => func.apply(context, args), delay);
            };
        }

        // Search events
        async function handleSearch() {
            const searchValue = searchInput.value.trim();
            isSearching = searchValue.length > 0;
            page = 1;
            searchPage = 1;
            preventLoad = false;
            listEvents.innerHTML = '';
            exportEvents = [];
            loadMoreEvents();
        }

        // Scroll event
        window.addEventListener('scroll', () => {
            if (!preventLoad) {
                if (window.scrollY + window.innerHeight >= container.offsetHeight + 300 && !isLoading) {
                    if (isSearching && searchPage < lastPage) {
                        searchPage++;
                        loadMoreEvents();
                    } else if (!isSearching && page < lastPage) {
                        page++;
                        loadMoreEvents();
                    }
                }
            }
        });

        // Search event vs debounce
        searchInput.addEventListener('input', debounce(handleSearch, 300));

        // Filter event
        btnFilter.addEventListener('click', () => {
            page = 1;
            searchPage = 1;
            preventLoad = false;
            listEvents.innerHTML = '';
            isSearching = true;
            exportEvents = [];
            loadMoreEvents();
        });

        // Export Excel
        if (btnExportExcel) {
            btnExportExcel.addEventListener('click', () => {
                exportEvent('list');
            });
        }

        if (btnExportExcelAll) {
            btnExportExcelAll.addEventListener('click', () => {
                exportEvent('all');
            });
        }

        // First load
        loadMoreEvents();
    </script>

@endsection
