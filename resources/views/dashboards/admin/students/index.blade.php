@extends('layouts.admin')

@section('title', 'Thống kê')

@section('content')

    <div class="container mx-auto px-8 py-4 div_wrapper">
        <div class="p-4">
            <div class="flex items-center justify-between mb-4 lg:flex-row flex-col gap-3">
                <h3 class="uppercase block p-2 font-semibold rounded-sm text-white bg-[var(--dark-bg)] w-fit">
                    Sinh viên tham gia sự kiện
                </h3>
                <div class="flex items-center justify-center gap-3">
                    <div class="relative border flex items-center h-full justify-start p-2 text-gray-400 w-full xl:w-fit">
                        <select name="course" id="course" class="border-none outline-none min-h-[24px] w-full p-0">
                            <option value="all">Tất cả</option>
                            @php
                                $selectedYear = $courseYear;
                                // Get the current year, then get the last two digits of the year
                                $year = substr(date('Y'), 2);
                                $startYear = 22;
                                // Get first number of start year
                                // 22 => 2
                                $yearChar = substr($startYear, 0, 1);
                                for ($i = $year; $i >= $startYear; $i--) {
                                    $selected = $yearChar . $i == $selectedYear ? 'selected' : '';
                                    echo "<option value='$yearChar$i'  $selected>Khóa $i</option>";
                                }
                            @endphp
                        </select>
                    </div>
                    <div class="relative border h-full flex items-center justify-between p-2 w-fit">
                        <input type="text" name="search" placeholder="Tìm kiếm sinh viên"
                            class="outline-none border-none p-0 rounded-sm min-w-[400px] min-h-[24px]">
                        <div class="text-gray-400">
                            <i class="fa-light fa-magnifying-glass"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-sm list_student">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                STT
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Họ và tên
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                MSSV
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Lớp
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Tổng số sự kiện tham gia
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Xem thêm
                            </th>
                        </tr>
                    </thead>
                    <tbody class="table_body">
                        @foreach ($students as $key => $student)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 dark:text-white break-words whitespace-normal">
                                    {{ $key + 1 }}
                                </th>
                                <td class="px-6 py-4 text-center">
                                    {{ $student->fullname }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $student->id }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $student->classname }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $student->events_count }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button class="text-blue-600 hover:underline"
                                        onclick="showStudentEventDetail('{{ $student->id }}')">
                                        Chi tiết
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination Links -->
            <div class="mt-4 flex items-center justify-center pagination_bar">
                {{ $students->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="studentDetailModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div
                class="inline-block align-bottom bg-gray-100 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full lg:max-w-4xl xl:max-w-6xl">
                <div class="bg-gray-100 p-6">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-xl font-semibold model_title">Chi tiết tham gia sự kiện của sinh viên</h2>
                        <button class="text-gray-600 hover:text-gray-900 text-3xl" onclick="closeModal()">&times;</button>
                    </div>
                    <div class="mb-4">
                        <button id="exportStudentDetail"
                            class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-sm ease-in transition-all">Xuất
                            Excel
                        </button>
                    </div>
                    <div id="studentDetailContent" class="rounded-sm overflow-hidden">
                        <!-- Nội dung chi tiết sự kiện sẽ được tải vào đây -->
                    </div>
                    <canvas id="eventChart" width="400" height="200" class="hidden"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        const inputSearch = document.querySelector('input[name="search"]');
        const tableBody = document.querySelector('.table_body');
        const studentDetailModal = document.getElementById('studentDetailModal');
        const prevInnerHTML = tableBody.innerHTML;
        const paginationBar = document.querySelector('.pagination_bar');
        const filterOption = document.getElementById('course');

        filterOption.addEventListener('change', function() {
            const value = this.value;
            const url = "{{ route('students.course.get', ':course') }}".replace(':course', value);
            window.location.href = url;

        });

        function closeModal() {
            document.getElementById('studentDetailModal').classList.add('hidden');
        }

        const showStudentEventDetail = (studentId) => {
            const url = "{{ route('students.get', ':studentId') }}".replace(':studentId', studentId);
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        const student = data.data;
                        const detail = document.createElement('div');
                        detail.innerHTML = `
                        <p>Mã số sinh viên: ${student.id}</p>
                        <p>Họ và tên: ${student.fullname}</p>
                        <p>Lớp: ${student.classname}</p>
                        <p>Số sự kiện tham gia: ${student.events_count}</p>
                      `;

                        const listEvent = document.createElement('div');
                        listEvent.classList.add('list_event_participant');
                        listEvent.innerHTML = `
                        <h3 class="text-left font-semibold my-4">Danh sách sự kiện đã tham gia</h3>
                        <div class="rounded-sm overflow-hidden">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Tên sự kiện
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center">
                                            Số lượng sinh viên tham gia
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center">
                                            Chi tiết
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${student.events.map((event, index) => {
                                      const route = "{{ route('events.show', ':eventId') }}".replace(':eventId', event.id);
                                      return `
                                                              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                                  <th scope="row"
                                                                      class="px-6 py-4 font-medium text-gray-900 dark:text-white break-words whitespace-normal">
                                                                      ${event.name}
                                                                  </th>
                                                                  <td class="px-6 py-4 text-center">
                                                                      ${event.participants_count}
                                                                  </td>
                                                                  <td class="px-6 py-4 text-center">
                                                                      <div class="flex items-center justify-center gap-3">
                                                                          <a href="${route}">
                                                                              Chi tiết
                                                                          </a>
                                                                      </div>
                                                                  </td>
                                                              </tr>
                                                          `;
                                    }).join('')}
                                </tbody>
                            </table>
                        </div>
                      `;
                        document.getElementById('studentDetailContent').innerHTML = detail.innerHTML + listEvent
                            .innerHTML;
                        document.getElementById('exportStudentDetail').addEventListener('click', () => {
                            window.location.href =
                                "{{ route('events.export.excel.participants', ':studentId') }}".replace(
                                    ':studentId', studentId);
                        });
                        studentDetailModal.classList.remove('hidden');
                    }
                });
        }

        function handleSearch() {
            const value = this.value.trim();

            if (value === '') {
                tableBody.innerHTML = prevInnerHTML;
                paginationBar.classList.remove('hidden');
                return;
            }

            paginationBar.classList.add('hidden');


            const url = "{{ route('students.get', ':studentId') }}".replace(':studentId', value);
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        const student = data.data;
                        tableBody.innerHTML = `
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 dark:text-white break-words whitespace-normal">
                                    1
                                </th>
                                <td class="px-6 py-4 text-center">
                                    ${student.fullname}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    ${student.id}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    ${student.classname}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    ${student.events.length}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button class="text-blue-600 hover:underline"
                                        onclick="showStudentEventDetail('${student.id}')">
                                        Chi tiết
                                    </button>
                                </td>
                            </tr>
                      `;
                    } else {
                        tableBody.innerHTML =
                            `<tr><td colspan="6" class="text-center p-4 text-red-500">Không tìm thấy sinh viên</td></tr>`;
                    }
                })
        }

        function debounce(func, delay) {
            let debounceTimer;
            return function() {
                const context = this;
                const args = arguments;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => func.apply(context, args), delay);
            };
        }

        inputSearch.addEventListener('input', debounce(handleSearch, 300));
    </script>
@endsection
