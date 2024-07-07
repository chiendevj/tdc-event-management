@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
    {{-- Banner  --}}
    <div class="w-full banner_bg mt_container relative overflow-hidden">
        <div class="slider">
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
            <h1 class="title font-bold uppercase text_title"><span>Sự kiện</span> <span class="text_title">Sắp diễn ra</span></h1>
            <div id="upcoming-loading" class="hidden">Đang tải...</div>
            <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4" id="upcoming-events">
            </div>
            <div id="upcoming-pagination" class="pagination-bar mt-6"></div>
        </div>
        <div class="big-event">
            <h1 class="title font-bold uppercase text_title"><span>Sự kiện</span> <span class="text_title">nổi bật</span></h1>
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
        const SLIDE_TIMER = 5000;



        async function createSliderItems() {
            const url = "{{ route('events.get.featured') }}";
            await fetch(url)
                .then(response => response.json())
                .then(data => {
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

        createSliderItems();

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
                        const eventElement = document.createElement('a');
                        let route = "{{ route('events.detail', ':id') }}".replace(':id', event.id);
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
    </script>
@endsection
