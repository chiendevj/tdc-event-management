@extends('layouts.app')

@section('title', 'Trang chủ')

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
    <div class="fixed notify_board w-[80%] lg:w-fit bg-white shadow-lg p-8 rounded-lg top-[50%] left-[50%] z-50">
        <button
            class="btn_close_noti absolute top-[-10px] right-[-10px] w-[30px] h-[30px] rounded-[50%] bg-white border shadow-sm flex items-center justify-center">
            <i class="fa-solid fa-times  hover:text-red-500 transition-all duration-100 ease-linear"></i>
        </button>
        <div class="flex items-center justify-center flex-col">
            <div class="mt-4">
                <h3 class="uppercase text-red-500 font-bold text-lg text-center mb-2 noti-title"></h3>
                <div class="noti-content"></div>
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
        <div class="big-event">
            <h1 class="title font-bold uppercase text_title"><span>Sự kiện</span> <span class="text_title">Sắp diễn
                    ra</span></h1>
            <div id="upcoming-loading" class="hidden">Đang tải...</div>
            <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4" id="upcoming-events">
            </div>
            <div id="upcoming-pagination" class="pagination-bar mt-6"></div>
        </div>
        <div class="big-event">
            <h1 class="title font-bold uppercase text_title"><span>Sự kiện</span> <span class="text_title">nổi bật</span>
            </h1>
            <div id="featured-loading" class="">

            </div>
            <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4" id="featured-events">
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

        console.log(marked);

        async function createSliderItems() {
            const url = "{{ route('events.get.featured') }}";
            return await fetch(url)
                .then(response => response.json())
                .then(data => {

                    if (data.data.length === 0) {
                        return false;
                    }

                    data.data.forEach((item, key) => {
                        let div = document.createElement('div');
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

        async function fetchEvents(linkUrl, listType) {
            const eventsContainer = document.getElementById(`${listType}-events`);
            const loadingElement = document.getElementById(`${listType}-loading`);
            eventsContainer.innerHTML = '';
            loadingElement.classList.remove('hidden');
            loadingElement.innerHTML = `
            <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4">
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
                </div>
            `

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
                        let route = "{{ route('events.detail', ':id') }}".replace(':id', event.id);
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
                                <div class="event-time"><span>${event.event_start}</span></div>
                                <div class="event-location"><span>${event.location}</span></div>
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
                    const linkUrl = listType === 'upcoming' ?
                        `/api/upcoming-events?page=${data.current_page - 1}` :
                        `/api/featured-events?page=${data.current_page - 1}`;
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
                    const linkUrl = listType === 'upcoming' ?
                        `/api/upcoming-events?page=${page}` :
                        `/api/featured-events?page=${page}`;
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
                    const linkUrl = listType === 'upcoming' ?
                        `/api/upcoming-events?page=${page}` :
                        `/api/featured-events?page=${page}`;
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
                    const linkUrl = listType === 'upcoming' ?
                        `/api/upcoming-events?page=${total_pages}` :
                        `/api/featured-events?page=${total_pages}`;
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
                    const linkUrl = listType === 'upcoming' ?
                        `/api/upcoming-events?page=${data.current_page + 1}` :
                        `/api/featured-events?page=${data.current_page + 1}`;
                    fetchEvents(linkUrl, listType);
                }
            });
            paginationContainer.appendChild(nextButton);

        }

        // Initial fetch
        fetchEvents('/api/upcoming-events', 'upcoming');
        fetchEvents('/api/featured-events', 'featured');

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
    </script>
@endsection
