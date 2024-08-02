@extends('layouts.app')

@section('title', 'Event Zone | FIT-TDC | Khoa Công nghệ thông tin - Cao đẳng Công nghệ Thủ Đức')

@section('content')
    {{-- Notification bar --}}
    <div class="fixed bottom-5 right-5 z-50 btn-show-notify hidden">
        <div class="dot-notify w-2 h-2 rounded-[50%] bg-red-500 absolute top-[-2px] left-[-2px]"></div>
        <div class="flex items-center gap-3 cursor-pointer bg-white shadow-md rounded-md p-3">
            <i class="fa-solid fa-bell bell text-[#FFA500]"></i>
            <span class="text-sm">Thông báo mới</span>
        </div>
    </div>

    {{-- Notify board --}}
    <div class="fixed notify_board w-[80%] lg:w-fit bg-white shadow-lg p-8 rounded-lg top-[50%] left-[50%] z-50"
        style="z-index: 999">
        <button
            class="btn_close_noti absolute top-[-10px] right-[-10px] w-[30px] h-[30px] rounded-[50%] bg-white border shadow-sm flex items-center justify-center">
            <i class="fa-solid fa-times  hover:text-red-500 transition-all duration-100 ease-linear"></i>
        </button>
        <div class="flex items-center justify-center flex-col">
            <div class="mt-4">
                <h3 class="uppercase text-red-500 font-bold text-lg text-center mb-2 noti-title"></h3>
                <div class="noti-content max-h-[65vh] overflow-auto"></div>
            </div>
            <div class="mt-4 flex items-end justify-end w-full gap-2">
                <button
                    class="btn_mark_readed w-[40px] text-green-500 h-[40px] btn_action border shadow-sm rounded-[50%] flex items-center justify-center text-sm relative">
                    <i class="fa-solid fa-check"></i>
                    <div
                        class="absolute z-10 w-fit text-nowrap top-[-100%] inline-block px-3 py-2 text-[12px] text-white transition-opacity duration-300 rounded-sm shadow-sm tooltip bg-gray-700">
                        Đánh dấu đã đọc thông báo, thông báo này sẽ không hiển thị nữa
                        <div class="tooltip-arrow absolute bottom-0"></div>
                    </div>
                </button>
                <button
                    class="btn_next_notify dot_mark_next_noti w-[40px] h-[40px] border shadow-sm rounded-[50%] flex items-center justify-center text-sm relative">0/0</button>
            </div>
        </div>
    </div>
    {{-- Banner  --}}
    <div class="w-full banner_bg mt_container relative overflow-hidden">
        <div class="slider">
            <h1
                class="temp_text hidden text-[30px] md:text-[42px] font-bold uppercase absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%] text-center">
                Chào mừng bạn đến với Sự kiện FIT - TDC
            </h1>
            <div class="list">
            </div>
            <div class="buttons">
                <button id="prev"><i class="fa-regular fa-chevron-left"></i></button>
                <button id="next"><i class="fa-regular fa-chevron-right"></i></button>
            </div>
            <ul class="dots">

            </ul>
        </div>
    </div>
    <div class="w-[92%] container mx-auto">
        @if (count($upcomingEvents) > 0)
        <div class="big-event">
            <h1 class="title font-bold uppercase text_title"><span>Sắp diễn ra</span> <span class="text_title">|
                    Upcoming</span></h1>
            <div class="line">
                <div class="line-left"></div>
                <div class="circle"></div>
                <div class="line-right"></div>
            </div>
            <div id="upcoming-loading" class="hidden">Đang tải...</div>
            <div class="mt-5 mx-auto md:w-[80%]">
                <div class="owl-carousel event-carousel owl-theme" id="upcoming-events">
                    @foreach ($upcomingEvents as $event)
                        <div class="event-card m-2 md:flex">
                            <div class="background-upcoming">
                                <a
                                    href="{{ route('events.detail', ['name' => Str::slug($event->name), 'id' => $event->id]) }}">
                                    <img src="{{ $event->event_photo }}" alt="">
                                </a>
                            </div>
                            <div class="content p-4 flex flex-col justify-center">
                                <div class="event-title event-title-upcoming">
                                    <a
                                        href="{{ route('events.detail', ['name' => Str::slug($event->name), 'id' => $event->id]) }}">
                                        {{ $event->name }}
                                    </a>
                                </div>
                                <div class="event-desc">
                                    <div class="event-tag event-time"><i
                                            class="fa-light fa-calendar"></i><span>{{ \Carbon\Carbon::parse($event->event_start)->format('H:i d/m/Y') }}</span>
                                    </div>
                                    <div class="event-tag event-location"><i
                                            class="fa-light fa-location-dot"></i><span>{{ $event->location }}</span></div>
                                    <div class="event-status"><span class="event-upcoming">{{ $event->status }}</span></div>
                                </div>
                                <hr>
                                <div class="event-register mb-2 mt-6 mx-auto">
                                    <a href="{{$event->registration_link}}" class="btn-register">Đăng ký</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div id="upcoming-pagination" class="pagination-bar mt-6"></div>
        </div>
        @endif
        <div class="big-event">
            <h1 class="title font-bold uppercase text_title"><span class="text_title">Event Zone</span>
            </h1>
            <div class="line">
                <div class="line-left"></div>
                <div class="circle"></div>
                <div class="line-right"></div>
            </div>
            <div class="search-block">
                <div class="events_search">
                    <input type="input" name="" id="search-input">
                    <div class="inline px-3 icon-search"></div>
                </div>
                <div class="search-results">
                    <ul id="event-search-results">
                    </ul>
                </div>
            </div>
            <div id="featured-loading" class="">

            </div>
            <div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-4" id="featured-events">
            </div>
            <div id="featured-pagination" class="pagination-bar mt-6"></div>

        </div>
    </div>
    <script>
        // Banner
        let slider = document.querySelector('.slider .list');
        let items = document.querySelectorAll('.slider .list .item');
        let next = document.getElementById('next');
        let prev = document.getElementById('prev');
        let dots = document.querySelectorAll('.slider .dots li');
        const btnCloseNoti = document.querySelector('.btn_close_noti');
        const bell = document.querySelector('.btn-show-notify');
        const overlay = document.querySelector('#overlay');
        const notifyBoard = document.querySelector('.notify_board');
        const notiTitle = document.querySelector('.noti-title');
        const notiContent = document.querySelector('.noti-content');
        const markNextNoti = document.querySelector('.dot_mark_next_noti');
        const btnNextNoti = document.querySelector('.btn_next_notify');
        const btnMarkReaded = document.querySelector('.btn_mark_readed');
        const SLIDE_TIMER = 5000;
        let marked = [];

        if (localStorage.getItem('readed_noti')) {
            marked = JSON.parse(localStorage.getItem('readed_noti'));
        }


        async function createSliderItems() {
            const url = "{{ route('events.get.featured') }}";
            return await fetch(url)
                .then(response => response.json())
                .then(data => {

                    if (data.data.length === 0) {
                        return false;
                    }

                    data.data.forEach((item, key) => {
                        let div = document.createElement('a');
                        let route = "{{ route('events.detail', ['name' => ':name', 'id' => ':id']) }}"
                            .replace(':name', slug(event.name)).replace(':id', event.id);
                        div.href = route;
                        div.className = 'item';
                        div.innerHTML = `<img src="${item.event_photo}" alt="">`;
                        slider.appendChild(div);
                        let li = document.createElement('li');
                        li.className = key === 0 ? 'active' : '';
                        document.querySelector('.slider .dots').appendChild(li);
                    })
                    items = document.querySelectorAll('.slider .list .item');
                    dots = document.querySelectorAll('.slider .dots li');
                    lengthItems = items.length - 1;
                    return true;
                }).catch(error => {
                    return false;
                });
        }

        createSliderItems().then(result => {
            if (result) {
                let lengthItems = items.length - 1;
                let active = 0;

                next.onclick = function() {
                    active = active + 1 <= lengthItems ? active + 1 : 0;
                    reloadSlider();
                }

                prev.onclick = function() {
                    active = active - 1 >= 0 ? active - 1 : lengthItems;
                    reloadSlider();
                }

                let refreshInterval = setInterval(() => {
                    next.click()
                }, SLIDE_TIMER);

                function reloadSlider() {
                    slider.style.left = -items[active].offsetLeft + 'px';
                    //
                    let last_active_dot = document.querySelector('.slider .dots li.active');
                    last_active_dot.classList.remove('active');
                    dots[active].classList.add('active');

                    clearInterval(refreshInterval);
                    refreshInterval = setInterval(() => {
                        next.click()
                    }, SLIDE_TIMER);
                }

                dots.forEach((li, key) => {
                    li.addEventListener('click', () => {
                        active = key;
                        reloadSlider();
                    })
                })
            } else {
                document.querySelector('.temp_text').style.display = 'block';
                document.querySelector('.buttons').style.display = 'none';
            }
        })

        window.onresize = function(event) {
            reloadSlider();
        };

        // Events
        function formatDate(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');

            return `${day}-${month}-${year} ${hours}:${minutes}`;
        }

        //Get Upcoming event
        async function getUpcomingEvents(linkUrl) {
            const eventsContainer = document.getElementById('upcoming-events');
            const response = await fetch(linkUrl);
            const results = await response.json();
            results.forEach(event => {
                let route = "{{ route('events.detail', ['name' => ':name', 'id' => ':id']) }}".replace(':name',
                    slug(event.name)).replace(':id', event.id);
                const eventElement = document.createElement('div');
                let style = "event-upcoming"
                eventElement.classList.add('event-card', 'm-2', 'md:flex', 'md:flex-row');

                eventElement.innerHTML = `
                        <div class="background-upcoming">
                            <a href="${route}">
                            <img src="${event.event_photo}" alt="">
                            </a>
                        </div>
                        <div class="content p-4 flex flex-col justify-center">
                            <div class="event-title event-title-upcoming">
                                <a href="${route}"> ${event.name}
                                </a>
                            </div>
                            <div class="event-desc">
                                 <div class="event-tag event-time"><i class="fa-light fa-calendar"></i><span>${formatDate(event.event_start)}</span></div>
                                <div class="event-tag event-location"><i class="fa-light fa-location-dot"></i><span>${event.location}</span></div>
                                <div class="event-status"><span class="${style}">${event.status}</span></div>
                            </div>
                            <hr>
                            <div class="event-register mb-2 mt-6 mx-auto">
                                <a href="${event.registration_link}" class="btn-register">Đăng ký</a>
                            </div>
                        </div>
                    `;
                eventsContainer.appendChild(eventElement);
            });
        }


        //Get all event
        async function fetchEvents(linkUrl, listType) {
            const eventsContainer = document.getElementById(`${listType}-events`);
            const loadingElement = document.getElementById(`${listType}-loading`);
            eventsContainer.innerHTML = '';
            loadingElement.classList.remove('hidden');
            loadingElement.innerHTML = loadingLayout();

            const response = await fetch(linkUrl);
            const result = await response.json();

            eventsContainer.innerHTML = '';
            loadingElement.classList.add('hidden');

            try {
                if (result.data.length === 0) {
                    const noEventsMessage = document.createElement('p');
                    noEventsMessage.textContent = 'Không có sự kiện nào.';
                    noEventsMessage.className = 'text-red-500 text-center';
                    eventsContainer.className = '';
                    eventsContainer.appendChild(noEventsMessage);
                } else {
                    result.data.forEach(event => {
                        let route = "{{ route('events.detail', ['name' => ':name', 'id' => ':id']) }}".replace(
                            ':name', slug(event.name)).replace(':id', event.id);
                        const eventElement = document.createElement('a');
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

                        eventElement.classList.add('event-card');
                        eventElement.href = route;
                        eventElement.innerHTML = `
                        <div class="background">
                            <img src="${event.event_photo}" alt="">
                        </div>
                        <div class="content p-4">
                            <div class="event-title">
                                <a href="${route}">
                                    ${event.name}
                                </a>
                            </div>
                            <div class="event-desc">
                                <div class="event-tag event-time"><i class="fa-light fa-calendar"></i><span>${formatDate(event.event_start)}</span></div>
                                <div class="event-tag event-location"><i class="fa-light fa-location-dot"></i><span>${event.location}</span></div>
                                <div class="event-status"><span class="${style}">${event.status}</span></div>
                            </div>
                        </div>
            `;
                        eventsContainer.appendChild(eventElement);
                    });
                    if (result.last_page > 1) {
                        setupPagination(result, listType);
                    }
                }
            } catch (error) {
                console.log(error);
            } finally {
                loadingElement.classList.add('hidden');
            }
        }

        function slug(str) {
            return String(str)
                .normalize("NFKD")
                .replace(/[\u0300-\u036f]/g, "")
                .replace(/[đĐ]/g, "d") //Xóa dấu
                .trim()
                .toLowerCase() //Cắt khoảng trắng đầu, cuối và chuyển chữ thường
                .replace(/[^a-z0-9\s-]/g, "") //Xóa ký tự đặc biệt
                .replace(/[\s-]+/g, "-"); //Thay khoảng trắng bằng dấu -, ko cho 2 -- liên tục
        }

        // Pagiation
        function setupPagination(data, listType) {
            const paginationContainer = document.getElementById(`${listType}-pagination`);
            paginationContainer.innerHTML = '';

            const prevButton = document.createElement('button');
            prevButton.innerHTML = `
            <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
        </svg>
            `;
            prevButton.classList.add('page-link');
            if (data.current_page === 1) {
                prevButton.disabled = true;
            }
            prevButton.addEventListener('click', () => {
                if (data.current_page > 1) {
                    const linkUrl = `/api/all-events?page=${data.current_page - 1}`;
                    fetchEvents(linkUrl, listType);
                }
            });
            paginationContainer.appendChild(prevButton);

            //Page links with ellipsis logic
            const total_pages = data.last_page;
            const current_page = data.current_page;
            const max_links = 5;
            const half_links = Math.floor(max_links / 2);

            let start_page = Math.max(1, current_page - half_links);
            let end_page = Math.min(total_pages, current_page + half_links);

            if (start_page > 1) {
                const fistPage = document.createElement('button');
                const page = 1;
                fistPage.textContent = '1';
                fistPage.classList.add('page-link');
                if (1 == current_page) {
                    fistPage.classList.add('active');
                }
                fistPage.addEventListener('click', function() {
                    const linkUrl = listType === `/api/all-events?page=${page}`;
                    fetchEvents(linkUrl, listType);
                })
                paginationContainer.appendChild(fistPage);
            }

            if (start_page > 2) {
                const ellipsis = document.createElement('span');
                ellipsis.textContent = '...';
                paginationContainer.appendChild(ellipsis);
            }



            // Generate pagination links
            for (let page = start_page; page <= end_page; page++) {
                const pageLink = document.createElement('button');
                pageLink.textContent = page;
                pageLink.classList.add('page-link');
                if (page === data.current_page) {
                    pageLink.classList.add('active');
                }
                pageLink.addEventListener('click', () => {
                    const linkUrl = `/api/all-events?page=${page}`;
                    fetchEvents(linkUrl, listType);
                });
                paginationContainer.appendChild(pageLink);
            }

            if (end_page < total_pages - 1) {
                const ellipsis = document.createElement('span');
                ellipsis.textContent = '...';
                paginationContainer.appendChild(ellipsis);
            }

            if (end_page < total_pages) {
                const lastPage = document.createElement('button');
                lastPage.textContent = total_pages;
                lastPage.classList.add('page-link');
                if (total_pages === current_page) {
                    lastPage.classList.add('active');
                }
                lastPage.addEventListener('click', () => {
                    const linkUrl = `/api/all-events?page=${total_pages}`;
                    fetchEvents(linkUrl, listType);
                });
                paginationContainer.appendChild(lastPage);
            }

            // Next button
            const nextButton = document.createElement('button');
            nextButton.innerHTML = `
            <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
        </svg>
            `;
            nextButton.classList.add('page-link');
            if (data.current_page === data.last_page) {
                nextButton.disabled = true;
            }
            nextButton.addEventListener('click', () => {
                if (data.current_page < data.last_page) {
                    const linkUrl = `/api/all-events?page=${data.current_page + 1}`;
                    fetchEvents(linkUrl, listType);
                }
            });
            paginationContainer.appendChild(nextButton);

        }


        // Initial fetch

        fetchEvents('/api/all-events', 'featured');


        // Notification
        const showNotify = (title, content, show = false) => {
            notiTitle.textContent = title;
            notiContent.innerHTML = content;

            if (show) {
                notifyBoard.classList.add("active");
                overlay.classList.add("open");
            }
        }

        const getNotifications = async () => {
            const url = "{{ route('notifications.get') }}";
            const response = await fetch(url);
            const data = await response.json();
            return data;
        }


        getNotifications().then((result) => {
            if (result.status === "success") {
                if (result.data.length > 0) {

                    let currentNoti = 0;

                    while (currentNoti < result.data.length && marked.includes(result.data[currentNoti].id)) {
                        currentNoti++;
                    }


                    if (currentNoti === result.data.length) {
                        currentNoti = 0
                        showNotify(result.data[currentNoti].title, result.data[currentNoti].content);
                        btnMarkReaded.classList.add('readed');
                    } else {
                        showNotify(result.data[currentNoti].title, result.data[currentNoti].content, true);
                    }

                    markNextNoti.textContent = currentNoti + 1 + "/" + result.data.length;

                    bell.classList.remove("hidden");
                    bell.addEventListener('click', () => {
                        overlay.classList.toggle("open");
                        notifyBoard.classList.toggle("active");
                    });

                    btnCloseNoti.addEventListener('click', () => {
                        notifyBoard.classList.remove("active")
                        overlay.classList.remove("open");
                    });

                    btnNextNoti.addEventListener('click', () => {
                        notifyBoard.classList.remove("active");
                        currentNoti++;
                        if (currentNoti >= result.data.length) {
                            currentNoti = 0;
                        }

                        if (marked.includes(result.data[currentNoti].id)) {
                            btnMarkReaded.classList.add('readed');
                        } else {
                            btnMarkReaded.classList.remove('readed');
                        }

                        markNextNoti.textContent = currentNoti + 1 + "/" + result.data.length;
                        showNotify(result.data[currentNoti].title, result.data[currentNoti].content);
                        notifyBoard.classList.add("active");
                    });

                    btnMarkReaded.addEventListener('click', () => {
                        const currentNotiId = result.data[currentNoti].id;
                        marked.push(currentNotiId);
                        localStorage.setItem('readed_noti', JSON.stringify(marked));
                        btnMarkReaded.classList.add('readed');
                    });
                }
            }
        }).catch((err) => {
            console.log(err);
        });

        function loadingLayout() {
            const loadingText = `
            <div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div role="status" class="p-4 space-y-8 animate-pulse md:space-y-0 rtl:space-x-reverse md:flex md:flex-col md:gap-4 md:items-center">
                        <div class="flex items-center justify-center w-full h-60 bg-gray-300 rounded dark:bg-gray-700 mb-5">
                            <svg class="w-10 h-10 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z"/>
                            </svg>
                        </div>
                        <div class="w-full">
                            <div class="h-7 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                            <div class="h-4 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[480px] mb-2.5"></div>
                            <div class="h-4 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
                        </div>
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div role="status" class="hidden md:block p-4 space-y-8 animate-pulse md:space-y-0 rtl:space-x-reverse md:flex md:flex-col md:gap-4 md:items-center">
                        <div class="flex items-center justify-center w-full h-60 bg-gray-300 rounded dark:bg-gray-700 mb-5">
                            <svg class="w-10 h-10 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z"/>
                            </svg>
                        </div>
                        <div class="w-full">
                            <div class="h-7 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                            <div class="h-4 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[480px] mb-2.5"></div>
                            <div class="h-4 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
                        </div>
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div role="status" class="hidden md:block p-4 space-y-8 animate-pulse md:space-y-0 rtl:space-x-reverse md:flex md:flex-col md:gap-4 md:items-center">
                        <div class="flex items-center justify-center w-full h-60 bg-gray-300 rounded dark:bg-gray-700 mb-5">
                            <svg class="w-10 h-10 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z"/>
                            </svg>
                        </div>
                        <div class="w-full">
                            <div class="h-7 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                            <div class="h-4 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[480px] mb-2.5"></div>
                            <div class="h-4 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
                        </div>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            `
            return loadingText
        }

        // Search all event
        const eventSearch = document.querySelector('#event-search-results');
        const searchInput = document.querySelector('#search-input');
        const searchIcon = document.querySelector('.icon-search');
        searchIcon.innerHTML = `
        <i class="fa-solid fa-magnifying-glass"></i>
        `;
        searchInput.addEventListener('input', function(e) {
            let key = e.target.value;
            fetchEventBySearch(key);
        })

        async function fetchEventBySearch(key) {
            if (key == "") {
                eventSearch.innerHTML = "";
                eventSearch.style.maxHeight = '0px';
                eventSearch.style.padding = '0px';
            } else {
                searchIcon.innerHTML = `
            <div role="status">
    <svg aria-hidden="true" class="w-6 h-6 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
    </svg>
    <span class="sr-only">Loading...</span>
</div>
            `
                const url = `/tim-kiem?key=${encodeURIComponent(key)}`;

                const response = await fetch(url);

                const results = await response.json();
                console.log("Key: ", key);
                console.log(results);

                searchIcon.innerHTML = '<i class="fa-solid fa-magnifying-glass"></i>';
                eventSearch.innerHTML = "";
                if (results.length <= 0) {
                    eventSearch.innerHTML = `
                <div class="search-empty">
                            <img  src="{{ asset('assets/images/empty-box.png') }}" alt="" srcset="">
                            <p>Không tìm thấy kết quả: <span>${key}</span></p>
                        </div>
                `;
                }
                results.forEach(event => {
                    eventSearch.style.maxHeight = '370px'
                    eventSearch.style.padding = '10px';
                    eventSearch.style.overflowY = 'scroll';
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

                    eventSearch.innerHTML += `
                <li class="item-search" data-id="${event.id}">
                            <img src="${event.event_photo}" alt=""
                                srcset="">
                                <div class="content">
                                    <h3>${event.name}</h3>
                                    <div class="event-tag event-location text-[12px]"><i class="fa-light fa-location-dot"></i><span class="ml-2">${event.location}</span></div>
                                    <div class="event-status-search mt-2"><span class="${style}">${event.status}</span></div>
                                </div>
                </li>
                `
                    const itemSearches = eventSearch.querySelectorAll('.item-search');
                    itemSearches.forEach(item => {
                        item.addEventListener('click', function() {
                            searchInput.value = "";
                            const eventId = this.getAttribute('data-id');
                            const route = `/su-kien/${ slug(event.name)}-${eventId}`;
                            window.location.href = route;
                        })
                    });

                    var instance = new Mark(eventSearch);
                    instance.mark(key, { accuracy: "partially" });
                });
            }
        }
    </script>
@endsection
