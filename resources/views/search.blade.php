@extends('layouts.app')

@section('title', 'Tra cứu')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="bg-white shadow-md rounded-lg p-20 max-w-xl w-full">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Tra cứu tham gia sự kiện</h1>
        <form id="searchForm" method="get" data-url="{{ route('search_events_by_student') }}">
            <div class="flex items-center mb-4 flex-col gap-5">
                <input id="studentId" class="input-search flex-1 p-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" name="student_id" placeholder="Nhập mã số sinh viên" type="text">
                <button type="submit" class="btn-search p-3 bg-blue-800 text-white rounded-lg hover:bg-blue-900"><i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm</button>
            </div>
        </form>
        <!-- Modal -->
        <div id="eventsModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white rounded-lg w-full max-w-lg overflow-hidden">
                <div class="flex justify-between items-center px-6 py-4 bg-blue-950">
                    <h2 class="text-lg font-semibold text-gray-200" id="modalTitle">Kết quả tra cứu</h2>
                    <button class="text-gray-200 hover:text-yellow-400 focus:outline-none p-5 text-2xl" onclick="closeModal()">&times;</button>
                </div>
                <div class="p-6" id="modalBody"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function closeModal() {
        document.getElementById('eventsModal').style.display = 'none';
    }

    // Lấy modal
    var modal = document.getElementById('eventsModal');

    // Khi người dùng click bên ngoài modal, đóng modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    let studentIdRegex = /^\d{5}[a-zA-Z]{2}\d{4}$/;

    let modalBody = document.getElementById("modalBody");
    let modalTitle = document.getElementById("modalTitle");

    // Xử lý sự kiện submit form bằng Ajax
    document.getElementById("searchForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Ngăn không gửi request mặc định

        var studentId = document.getElementById("studentId").value.trim();

        if (studentId === '') {
            showModal('bg-red-600', 'Vui lòng nhập mã số sinh viên để tra cứu.');
            return;  
        }

        // Kiểm tra mã số sinh viên với biểu thức chính quy
        if (!studentIdRegex.test(studentId)) {
            showModal('bg-red-600', 'Mã số sinh viên không hợp lệ.');
            return;  
        }

        var apiUrl = this.getAttribute('data-url');

        fetch(apiUrl + '?student_id=' + studentId)
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.error) {
                    showModal('bg-red-600', data.error);
                } else {
                    showEvents(data);
                }
            })
            .catch(function(error) {
                console.error('Đã xảy ra lỗi:', error);
            });

        function showModal(headerClass, message) {
            modalTitle.parentElement.className = `flex justify-between items-center px-6 py-4 ${headerClass}`;
            modalTitle.innerHTML = 'Kết quả tra cứu';
            modalBody.innerHTML = `<p class="text-gray-700">${message}</p>`;
            modal.style.display = "flex";
        }

        function showEvents(data) {
            modalTitle.parentElement.className = 'flex justify-between items-center px-6 py-4 bg-blue-950';
            modalTitle.innerHTML = `Kết quả tra cứu cho sinh viên ${data.student.fullname} (MSSV: ${data.student.id})`;

            if (data.events.length > 0) {
                let html = `
                    <h3 class="text-lg font-semibold mb-2">Các sự kiện sinh viên đã tham gia:</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-200 bg-blue-800 uppercase tracking-wider">Tên sự kiện</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                `;

                data.events.forEach((event, index) => {
                    const bgColorClass = index % 2 === 0 ? 'bg-gray-100' : 'bg-blue-400 text-white';
                    html += `
                        <tr class="${bgColorClass}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-medium">${event.id}. </span> ${event.name}
                            </td>
                        </tr>
                    `;
                });

                html += `
                            </tbody>
                        </table>
                    </div>
                `;

                modalBody.innerHTML = html;
            } else {
                modalBody.innerHTML = '<p>Sinh viên chưa tham gia sự kiện nào.</p>';
            }

            modal.style.display = "flex";
        }
    });

    function createBubble() {
        const bubble = document.createElement('div');
        bubble.className = 'bubble';
        const size = Math.random() * 50 + 20;
        bubble.style.width = `${size}px`;
        bubble.style.height = `${size}px`;
        bubble.style.left = `${Math.random() * 70 + 10}%`;
        bubble.style.animationDuration = `${Math.random() * 5 + 5}s`;
        document.body.appendChild(bubble);

        setTimeout(() => {
            bubble.remove();
        }, 10000);
    }

    setInterval(createBubble, 500);
</script>
@endsection
