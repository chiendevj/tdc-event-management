@extends('layouts.app')

@section('title', 'Đăng ký')

@section('content')
    <div class="background-tdc-attendence">
        <div class="attendence-box">
            <h1 class="attendence-form-title"><span>Đăng ký</span> </br> tham gia sự kiện</h1>
            <div class="container mx-auto md:w-[50%] form-attendence">
                <div class="line">
                    <div class="line-left"></div>
                    <div class="circle"></div>
                    <div class="line-right"></div>
                </div>
                @if (session('success'))
                    <div class="bg-green-100 text-green-700 p-4 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif
                <h2 class="attent-title">
                    {{ $event->name }}
                </h2>
                <form action="{{ route('submit.register') }}" method="post">
                    @csrf
                    <div class="mt-4">
                        <label for="">Mã số sinh viên <span>*</span></label>
                        <input type="text" name="student_id" placeholder="Nhập mã số sinh viên của bạn">
                        <p id="studentIdError" class="block text-[12px] text-red-500"></p>
                    </div>
                    <div class="mt-4 name_block">
                        <label for="">Họ và tên <span>*</span> </label>
                        <input type="text" readonly name="fullname" placeholder="Nhập họ và tên của bạn">
                        <p id="fullnameError" class="block text-[12px] text-red-500"></p>
                    </div>
                    <div class="mt-4 birthday_block">
                        <label for="">Ngày sinh <span>*</span> </label>
                        <input type="text" readonly name="birthday" placeholder="Nhập ngày sinh của bạn">
                    </div>
                    <div class="mt-4 class_block">
                        <label for="">Lớp <span>*</span></label>
                        <input type="text" readonly name="class" placeholder="Nhập lớp của bạn">
                        <p id="classError" class="block text-[12px] text-red-500"></p>
                    </div>
                    <div class="mt-4 question_block">
                        <label for="">Hãy đặt câu hỏi hay vấn đề mà bạn quan tâm về sự kiện này</label>
                        <textarea type="text" name="question" placeholder="" class="border-b border-solid outline-none"></textarea>
                    </div>
                    <div class="mt-4">
                        <input type="hidden" name="event_id" value="{{ $event['id'] }}">
                        <button class="btn-confirm-info" type="button">Xác minh thông tin</button>
                        <button class="btn-cancel-confirm hidden" type="button">Thông tin không chính xác ?</button>
                        <button class="btn-attended hidden" type="submit">Gửi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // Lấy các input từ DOM
        const fullnameInput = document.querySelector('input[name="fullname"]');
        const birthdayInput = document.querySelector('input[name="birthday"]');
        const studentIdInput = document.querySelector('input[name="student_id"]');
        const classInput = document.querySelector('input[name="class"]');
        const fullnameError = document.getElementById('fullnameError');
        const studentIdError = document.getElementById('studentIdError');
        const classError = document.getElementById('classError');
        const nameBlock = document.querySelector('.name_block');
        const classBlock = document.querySelector('.class_block');
        const birthdayBlock = document.querySelector('.birthday_block');
        const btnConfirmInfo = document.querySelector('.btn-confirm-info');
        const btnCancelConfirm = document.querySelector('.btn-cancel-confirm');
        const questionBlock = document.querySelector('.question_block');
        let checkInfor = false;

        // Định nghĩa các biểu thức regex và thông báo lỗi
        const regexPatterns = {
            fullname: /^[a-zA-ZÀ-ỹ\s]+$/u,
            studentId: /^\d{5}[A-Z][A-Z]\d{4}$/,
            class: /^[A-Z][A-Z]\d{2}[A-Z][A-Z]\d{2}$/
        };

        const errorMessages = {
            fullname: 'Họ và tên không hợp lệ. Vui lòng chỉ nhập chữ cái và dấu cách.',
            studentId: 'Mã số sinh viên không hợp lệ. Vui lòng chỉ nhập chữ cái và số.',
            class: 'Lớp không hợp lệ. Vui lòng chỉ nhập chữ cái và số.'
        };


        document.querySelector('form').addEventListener('submit', function(event) {

            if (!studentIdInput.value || !fullnameInput.value || !classInput.value) {
                event.preventDefault();
                fullnameError.innerHTML = "Vui lòng nhập họ và tên";
                fullnameInput.style.borderBottom = '1px solid red';

                studentIdError.innerHTML = "Vui lòng nhập mã số sinh viên";
                studentIdInput.style.borderBottom = '1px solid red';

                classError.innerHTML = "Vui lòng nhập lớp";
                classInput.style.borderBottom = '1px solid red';
                return;
            }
        });

        // Function kiểm tra hợp lệ của mỗi trường
        function validateSubmit(input, regexPattern, errorMessage, errorElement) {
            const isValid = regexPattern.test(input.value);
            errorElement.innerHTML = (isValid ? '' : errorMessage);
            input.style.borderBottom = isValid ? '' : '1px solid red';
        }

        function validateInput(input, regexPattern, errorMessage, errorElement) {
            if (input.value === '') {
                errorElement.innerHTML = '';
                input.style.borderBottom = '1px solid #ccc'; // Khôi phục lại viền mặc định
                return;
            }

            const isValid = regexPattern.test(input.value);
            errorElement.innerHTML = (isValid ? '' : errorMessage);
            input.style.borderBottom = isValid ? '' : '1px solid red';
        }

        // Sự kiện input cho fullname
        fullnameInput.addEventListener('input', function() {
            validateInput(this, regexPatterns.fullname, errorMessages.fullname, fullnameError);
        });

        // Sự kiện input cho studentId
        studentIdInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
            validateInput(this, regexPatterns.studentId, errorMessages.studentId, studentIdError);
        });

        // Sự kiện input cho class
        classInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
            validateInput(this, regexPatterns.class, errorMessages.class, classError);
        });

        // Sự kiện click cho nút xác minh thông tin
        btnConfirmInfo.addEventListener('click', function(studentId) {
            if (!checkInfor) {
                if (studentIdInput.value !== '') {
                    const url = '{{ route('students.get', ':studentId') }}'.replace(':studentId', studentIdInput
                        .value);
                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                        console.log(data)
                            if (data.status === 'success') {
                                checkInfor = true;
                                fullnameInput.value = data.data.fullname;
                                classInput.value = data.data.classname;
                                birthdayInput.value = data.data.birth;
                                nameBlock.classList.add('confirmed');
                                classBlock.classList.add('confirmed');
                                birthdayBlock.classList.add('confirmed');
                                btnConfirmInfo.textContent = 'Đây là thông tin của bạn ?';
                                btnCancelConfirm.classList.remove('hidden');
                            } else {
                                studentIdError.innerHTML = "Mã số sinh viên không tồn tại";
                                studentIdInput.style.borderBottom = '1px solid red';
                                checkInfor = false;
                            }
                        });
                } else {
                    studentIdError.innerHTML = "Vui lòng nhập mã số sinh viên";
                    studentIdInput.style.borderBottom = '1px solid red';
                }
            } else {
                document.querySelector('.btn-attended').classList.remove('hidden');
                btnCancelConfirm.classList.add('hidden');
                btnConfirmInfo.classList.add('hidden');
                questionBlock.classList.add('confirmed');
                checkInfor = false;
            }
        });

        // Sự kiện click cho nút hủy xác minh thông tin
        btnCancelConfirm.addEventListener('click', function() {
            fullnameInput.value = '';
            classInput.value = '';
            birthdayInput.value = '';
            nameBlock.classList.remove('confirmed');
            classBlock.classList.remove('confirmed');
            birthdayBlock.classList.remove('confirmed');
            questionBlock.classList.remove('confirmed');
            btnConfirmInfo.textContent = 'Xác minh thông tin';
            btnCancelConfirm.classList.add('hidden');
            checkInfor = false;
        });
    </script>
@endsection
