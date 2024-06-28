@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
    <div class="w-[92%] container mx-auto">
        <div class="big-event">
            <h1 class="title font-bold capitalize">Sự kiện <span>Sắp diễn ra</span></h1>
            <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4" id="upcoming-events">
            </div>
            <div id="upcoming-pagination" class="pagination-bar mt-6"></div>
        </div>
        <div class="big-event">
            <h1 class="title font-bold capitalize">Sự kiện <span>nổi bật</span></h1>
            <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4" id="featured-events">
            </div>
            <div id="featured-pagination" class="pagination-bar mt-6"></div>
                
        </div>

        {{-- <div class="big-event">
            <h1 class="title font-bold capitalize">Sự kiện <span>nổi bật</span></h1>
            <div class="mt-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 event-card">
                        <div class="background">
                            <img src="{{ asset('assets/images/workshop.jpg') }}" alt="">
                        </div>
                        <div class="content">
                            <div class="event-title">
                                <a>
                                    Workshop tìm hiểu về giấy
                                </a>
                            </div>
                            <div class="event-desc">
                                <div class="event-time"><span>7:00 18/6/2024</span></div>
                                <div class="event-location"><span>Hội trường D</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 event-card">
                        <div class="background">
                            <img src="{{ asset('assets/images/workshop1.jpg') }}" alt="">
                        </div>
                        <div class="content">
                            <div class="event-title">
                                <a>
                                    Xây dựng thương hiệu cá nhân
                                </a>
                            </div>
                            <div class="event-desc">
                                <div class="event-time"><span>8:00 18/6/2024</span></div>
                                <div class="event-location"><span>Hội trường D</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 event-card">
                        <div class="background">
                            <img src="{{ asset('assets/images/workshop2.jpg') }}" alt="">
                        </div>
                        <div class="content">
                            <div class="event-title">
                                <a>
                                    Cuộc thi web dev challanges
                                </a>
                            </div>
                            <div class="event-desc">
                                <div class="event-time"><span>14:30 18/5/2024</span></div>
                                <div class="event-location"><span>Tại phòng B002B</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <script>
        async function fetchEvents(linkUrl, listType) {
            const response = await fetch(linkUrl);
            const result = await response.json();
            console.log(result);

            const eventsContainer = document.getElementById(`${listType}-events`);
            eventsContainer.innerHTML = ''; // Clear existing content

            result.data.forEach(event => {
                const eventElement = document.createElement('a');
                let route = "{{ route('events.detail', ':id') }}".replace(':id', event.id);
                eventElement.classList.add('p-4');
                eventElement.classList.add('event-card');
                eventElement.href = route
                eventElement.innerHTML = `
                    <div class="background">
                            <img src="${event.event_photo}" alt="">
                        </div>
                        <div class="content">
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

            setupPagination(result, listType);
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
                    const linkUrl = listType === 'upcoming'
                        ? `/api/upcoming-events?page=${data.current_page - 1}`
                        : `/api/featured-events?page=${data.current_page - 1}`;
                    fetchEvents(linkUrl, listType);
                }
            });
            paginationContainer.appendChild(prevButton);

            //Page links with ellipsis logic
            const total_pages = data.last_page;
            const current_page = data.current_page;
            const max_links = 5;
            const half_links = Math.floor(max_links / 2 );

            let start_page = Math.max(1, current_page - half_links);
            let end_page = Math.min(total_pages, current_page + half_links);

            if(start_page > 1) {
                const fistPage = document.createElement('button');
                const page = 1;
                fistPage.textContent = '1';
                fistPage.classList.add('page-link');
                if(1 == current_page){
                    fistPage.classList.add('active');
                }
                fistPage.addEventListener('click', function() {
                    const linkUrl = listType === 'upcoming'
                        ? `/api/upcoming-events?page=${page}`
                        : `/api/featured-events?page=${page}`;
                    fetchEvents(linkUrl, listType);
                })
                paginationContainer.appendChild(fistPage);
            }

            if(start_page > 2) {
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
                    const linkUrl = listType === 'upcoming' 
                        ? `/api/upcoming-events?page=${page}` 
                        : `/api/featured-events?page=${page}`;
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
                    const linkUrl = listType === 'upcoming'
                        ? `/api/upcoming-events?page=${total_pages}`
                        : `/api/featured-events?page=${total_pages}`;
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
                    const linkUrl = listType === 'upcoming'
                        ? `/api/upcoming-events?page=${data.current_page + 1}`
                        : `/api/featured-events?page=${data.current_page + 1}`;
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






