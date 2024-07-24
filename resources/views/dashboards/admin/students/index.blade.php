@extends('layouts.admin')

@section('title', 'Sinh viên')

@section('content')
    <div class="container mx-auto px-8 py-4 div_wrapper">
        {{-- Form upload --}}
        <div class="overlay fixed top-0 left-0 right-0 bottom-0 bg-[rgba(0,0,0,0.2)] z-10"></div>
        <form method="POST" action="{{ route('excel.students.import') }}" enctype="multipart/form-data"
            class="import_form p-8 rounded-lg bg-white shadow-lg fixed top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%] z-10">
            @csrf
            <label for="import_students">
                <iframe src="https://lottie.host/embed/e743699b-a756-4b11-a6b3-55103552a8fa/0lbq4higLI.json"></iframe>
                <h3 class="text-sm text-center">
                    Chọn file dữ liệu cần nhập <span class="text-red-500">tại đây *</span>
                    <span class="import_file font-semibold text-[var(--dark-bg)] block">
                    </span>
                </h3>
                <input type="file" hidden id="import_students" name="import_students">
            </label>
            <button
                class="mt-4 w-full btn_submit_import p-2 rounded-sm text-white bg-[var(--dark-bg)] flex items-center justify-center gap-3"
                type="submit">Nhập dữ liệu
                <div class="fetching_data hidden animate-spin">
                    <i class="fa-duotone fa-solid fa-spinner-third"></i>
                </div>
            </button>
            <button type="button"
                class="btn_close_import_form top-[-10px] right-[-10px] w-[20px] h-[20px] bg-white absolute rounded-full p-4 flex items-center cursor-pointer shadow-sm justify-center">
                <i class="fa-light fa-times"></i>
            </button>
        </form>

        <div class="p-4">
            <div class="flex items-center justify-between mb-4 xl:flex-row flex-col gap-3">
                <h3 class="uppercase block p-2 font-semibold rounded-sm text-white bg-[var(--dark-bg)] w-fit">
                    Sinh viên tham gia sự kiện
                </h3>
                <div class="flex items-center justify-center gap-3 flex-col xl:flex-row">
                    <button
                        class="block p-2 rounded-sm text-white w-full xl:w-fit bg-[var(--dark-bg)] btn_show_import_form">
                        Nhập danh sách sinh viên
                    </button>
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
                    <thead class="text-xs text-gray-700 uppercase bg-gray-300 dark:bg-gray-700 dark:text-gray-400">
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
                            <tr class="bg-gray-100 border-b dark:bg-gray-800 dark:border-gray-700">
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
                class="inline-block align-bottom bg-gray-100 rounded-lg text-left shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full lg:max-w-4xl xl:max-w-6xl">
                <div class="bg-gray-100 p-6">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-xl font-semibold model_title uppercase">Chi tiết tham gia sự kiện của sinh viên</h2>
                        <button class="text-gray-600 hover:text-gray-900 text-3xl" onclick="closeModal()">&times;</button>
                    </div>
                    <div class="mb-4 flex items-center justify-start gap-2">
                        <button id="exportStudentDetail"
                            class="btn_action relative bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-sm ease-in transition-all">
                            <i class="fa-light fa-file-excel"></i>
                            <div
                                class="absolute z-10 w-fit text-nowrap top-[-100%] left-[50%] translate-x-[-50%] inline-block px-3 py-2 text-[12px] text-white transition-opacity duration-300 rounded-sm shadow-sm tooltip bg-gray-700">
                                Xuất toàn bộ danh sách sự kiện ra Excel
                                <div class="tooltip-arrow absolute bottom-0"></div>
                            </div>
                        </button>
                        <form id="deleteStudent" action="{{ route('students.delete') }}" method="POST"
                            class="btn_action relative bg-red-500 hover:bg-red-600 text-white rounded-sm ease-in transition-all">
                            @csrf
                            <button class="btn_delete_student w-full h-full py-2 px-4" type="button">
                                <i class="fa-light fa-trash"></i>
                            </button>
                            <input type="text" name="student_id" id="student_id" hidden>
                            <div
                                class="absolute z-10 w-fit text-nowrap top-[-100%] left-[50%] translate-x-[-50%] inline-block px-3 py-2 text-[12px] text-white transition-opacity duration-300 rounded-sm shadow-sm tooltip bg-gray-700">
                                Xóa sinh viên khỏi hệ thống
                                <div class="tooltip-arrow absolute bottom-0"></div>
                            </div>
                        </form>
                    </div>
                    <div id="studentDetailContent" class="rounded-sm">
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
        const studentContent = document.getElementById('studentDetailContent');
        const inputImport = document.getElementById('import_students');
        const importFile = document.querySelector('.import_file');
        const importForm = document.querySelector('.import_form');
        const btnShowImportForm = document.querySelector('.btn_show_import_form');
        const btnCloseImportForm = document.querySelector('.btn_close_import_form');
        const overlay = document.querySelector('.overlay');
        const btnSubmitImport = document.querySelector('.btn_submit_import');
        const formDeleteStudent = document.getElementById('deleteStudent');
        const btnDeleteStudent = document.querySelector('.btn_delete_student');
        const inputStudentId = document.getElementById('student_id');


        filterOption.addEventListener('change', function() {
            const value = this.value;
            const url = "{{ route('students.course.get', ':course') }}".replace(':course', value);
            window.location.href = url;
        });

        function closeModal() {
            document.getElementById('studentDetailModal').classList.add('hidden');
            studentContent.innerHTML = '';
        }

        const showStudentEventDetail = (studentId) => {
            const url = "{{ route('students.get', ':studentId') }}".replace(':studentId', studentId);
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        const academics = data.data.events_by_academic_period;
                        const student = data.data;
                        const detail = document.createElement('div');
                        detail.innerHTML = `
                        <p><span class="font-semibold">Mã số sinh viên:</span> ${student.id}</p>
                        <p><span class="font-semibold">Họ và tên:</span> ${student.fullname}</p>
                        <p><span class="font-semibold">Lớp:</span> ${student.classname}</p>
                        <p><span class="font-semibold">Số sự kiện tham gia:</span> ${student.events_count}</p>
                      `;

                        studentContent.appendChild(detail);

                        btnDeleteStudent.addEventListener('click', () => {
                            inputStudentId.value = studentId;
                            // confirm delete
                            if (!confirm('Bạn có chắc chắn muốn xóa sinh viên này không?')) {
                                return;
                            }

                            formDeleteStudent.submit();
                        });

                        academics.forEach(academic => {
                            const listEvent = document.createElement('div');
                            listEvent.classList.add('list_event_participant', 'mb-4');
                            listEvent.innerHTML = `
                               <div class="flex items-center justify-between flex-col sm:flex-row lg:flex-row xl:flex-row">
                                     <h3 class="text-left font-semibold my-4">Danh sách sự kiện đã tham gia (${academic.academic_period})</h3>
                                      <button id="exportStudentDetailSemester${academic.academic_period_id}"
                                        class="btn_action relative bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-sm ease-in transition-all">
                                        <i class="fa-light fa-file-excel"></i>
                                        <div
                                            class="absolute z-10 w-fit text-nowrap top-[-100%] left-[50%] translate-x-[-50%] inline-block px-3 py-2 text-[12px] text-white transition-opacity duration-300 rounded-sm shadow-sm tooltip bg-gray-700">
                                            Xuất danh sách sự kiện ra Excel
                                            <div class="tooltip-arrow absolute bottom-0"></div>
                                        </div>
                                    </button>
                                </div>
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
                                            ${academic.events.map((event, index) => {
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
                            studentContent.appendChild(listEvent);
                            document.getElementById('exportStudentDetail').addEventListener('click', () => {
                                window.location.href =
                                    "{{ route('events.export.excel.participants', ':studentId') }}"
                                    .replace(
                                        ':studentId', studentId);
                            });

                            document.getElementById('exportStudentDetailSemester' + academic
                                .academic_period_id).addEventListener('click', () => {
                                window.location.href =
                                    "{{ route('students.events.export', [':studentId', ':academicPeriodId']) }}"
                                    .replace(':studentId', studentId)
                                    .replace(':academicPeriodId', academic.academic_period_id);
                            });
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

            const url = "{{ route('students.search', ':searchValue') }}".replace(':searchValue', value);
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
                        tableBody.innerHTML = '';
                        const students = data.data.data;
                        console.log(students);
                        if (students.length > 0) {
                            students.forEach((student, index) => {
                                tableBody.innerHTML += `
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white break-words whitespace-normal">
                                        ${index + 1}
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
                                        ${student.events_count}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button class="text-blue-600 hover:underline"
                                            onclick="showStudentEventDetail('${student.id}')">
                                            Chi tiết
                                        </button>
                                    </td>
                                </tr>
                        `;
                            })
                        } else {
                            tableBody.innerHTML =
                                `<tr><td colspan="6" class="text-center p-4 text-red-500">Không tìm thấy sinh viên</td></tr>`;
                        }
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
        inputImport.addEventListener('change', function() {
            importFile.textContent = this.files[0].name;
        });


        btnShowImportForm.addEventListener('click', function() {
            importForm.classList.add('active');
            overlay.classList.add('active');
        });

        btnCloseImportForm.addEventListener('click', function() {
            importForm.classList.remove('active');
            overlay.classList.remove('active');
        });

        importForm.addEventListener('submit', function() {
            btnSubmitImport.disabled = true;
            const fetchingData = document.querySelector('.fetching_data');
            fetchingData.classList.remove('hidden');
        });
    </script>
@endsection
