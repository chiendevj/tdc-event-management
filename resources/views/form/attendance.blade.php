@extends('layouts.app')

@section('title', $event['name'] . '| Event Zone FIT-TDC')

@section('content')
    <div class="background-tdc-attendence mt_container">
        <div class="attendence-box">
            <h1 class="attendence-form-title"><span>Điểm danh</span> </br> tham gia sự kiện</h1>
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
                    {{ $event['name'] }}
                </h2>
                <form action="{{ route('submit.attendance') }}" method="post">
                    @csrf
                    <div class="mt-4 info">
                        <label for="">Mã số sinh viên <span>*</span></label>
                        <input type="text" name="student_id" placeholder="Nhập mã số sinh viên của bạn">
                        <p id="studentIdError" class="block text-[12px] text-red-500"></p>
                    </div>
                    <div class="mt-4 name_block info">
                        <label for="">Họ và tên <span>*</span></label>
                        <input type="text" readonly name="fullname" placeholder="Nhập họ và tên của bạn">
                        <p id="fullnameError" class="block text-[12px] text-red-500"></p>
                    </div>
                    <div class="mt-4 birthday_block info">
                        <label for="">Ngày sinh <span>*</span> </label>
                        <input type="text" readonly name="birthday" placeholder="Nhập ngày sinh của bạn">
                    </div>
                    <div class="mt-4 class_block info">
                        <label for="">Lớp <span>*</span></label>
                        <input type="text" readonly name="class" placeholder="Nhập lớp của bạn">
                        <p id="classError" class="block text-[12px] text-red-500"></p>
                    </div>
                    <div class="question-component">
                        @if ($questions)
                            @foreach ($questions as $question)
                                <div class="question-item {{ $question->require ? 'question-item-required' : '' }}">
                                    <div class="question">{{ $question->text }} <span
                                            class="require-question {{ $question->require ? '' : 'hidden' }}">*</span></div>
                                    <input type="hidden" id="form_id" name="form_id" value="{{ $question->form_id }}">
                                    <input type="hidden" id="question_id"
                                        name="questions[{{ $question->id }}][question_id]" value="{{ $question->id }}">
                                    @if ($question->type === 'radio' || $question->type === 'checkbox')
                                        <div class="answers">
                                            @foreach ($question->answers as $answer)
                                                <div class="answer">
                                                    <input class="type-question" type="{{ $question->type }}"
                                                        name="questions[{{ $question->id }}][answers][]"
                                                        id="answer_{{ $answer->id }}" value="{{ $answer->id }}">
                                                    <label for="answer_{{ $answer->id }}">{{ $answer->text }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <!-- Hiển thị input text nếu câu hỏi là dạng trả lời ngắn -->
                                    @if ($question->type === 'text')
                                        <div class="answers">
                                            <input class="type-question answer-text" type="text"
                                                name="questions[{{ $question->id }}][answer_text]"
                                                id="answer_text_{{ $question->id }}" value="">
                                        </div>
                                    @endif

                                    <p class="required-message hidden text-[12px] text-red-500 pt-[12px]"><i
                                            class="fa-regular fa-circle-exclamation pr-2"></i> Đây ra một câu hỏi bắt buộc
                                    </p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="mt-4 info">
                        <input type="hidden" name="event_id" value="{{ $event['id'] }}">
                        <input type="hidden" name="code" value="{{ $event['code'] }}">
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
        const studentIdInput = document.querySelector('input[name="student_id"]');
        const classInput = document.querySelector('input[name="class"]');
        const birthdayInput = document.querySelector('input[name="birthday"]');
        const studentIdError = document.getElementById('studentIdError');
        const nameBlock = document.querySelector('.name_block');
        const classBlock = document.querySelector('.class_block');
        const birthdayBlock = document.querySelector('.birthday_block');
        const btnConfirmInfo = document.querySelector('.btn-confirm-info');
        const btnCancelConfirm = document.querySelector('.btn-cancel-confirm');
        const questionComponent = document.querySelector('.question-component');
        questionComponent.style.display = 'none'
        let checkInfor = false;


        // Định nghĩa các biểu thức regex và thông báo lỗi
        const regexPatterns = {
            studentId: /^\d{5}[A-Z][A-Z]\d{4}$/,
        };

        const errorMessages = {
            studentId: 'Mã số sinh viên không hợp lệ. Vui lòng chỉ nhập chữ cái và số.'
        };


        document.querySelector('form').addEventListener('submit', function(event) {

            if (!studentIdInput.value) {
                event.preventDefault();

                studentIdError.innerHTML = "Vui lòng nhập mã số sinh viên";
                studentIdInput.style.borderBottom = '1px solid red';

                return;
            }

            validateRequireQuestion(event);

        });

        //Check require question
        function validateRequireQuestion(event) {
            let isValid = true;
            let questionItemsRequired = document.querySelectorAll('.question-item-required');

            questionItemsRequired.forEach(function(questionItem) {
                console.log("question", questionItem);

                let inputs = questionItem.querySelectorAll('.type-question')
                console.log(inputs);

                let hasAnswer = false;

                inputs.forEach(function(input) {
                    if (input.type == 'radio' || input.type == 'checkbox') {
                        if (input.checked) {
                            hasAnswer = true;
                        }
                    } else if (input.type == 'text' && input.value.trim() != '') {
                        hasAnswer = true;
                    }
                });

                let errorMessage = questionItem.querySelector('.required-message');
                console.log(errorMessage);
                console.log(hasAnswer);



                if (!hasAnswer) {
                    errorMessage.classList.remove('hidden');
                    isValid = false;
                } else {
                    errorMessage.classList.add('hidden')
                    isValid = true;
                }
            });

            if (isValid == false) {
                event.preventDefault();
            }
        }

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

        // Sự kiện input cho studentId
        studentIdInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
            validateInput(this, regexPatterns.studentId, errorMessages.studentId, studentIdError);
        });

        // Sự kiện click cho nút xác minh thông tin
        btnConfirmInfo.addEventListener('click', function(studentId) {
            if (!checkInfor) {
                if (studentIdInput.value !== '') {
                    checkInfor = true;
                    const url = '{{ route('students.get', ':studentId') }}'.replace(':studentId', studentIdInput
                        .value);
                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
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
                questionComponent.style.display = 'flex'
                document.querySelector('.btn-attended').classList.remove('hidden');
                btnCancelConfirm.classList.add('hidden');
                btnConfirmInfo.classList.add('hidden');
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
            btnConfirmInfo.textContent = 'Xác minh thông tin';
            btnCancelConfirm.classList.add('hidden');
            checkInfor = false;
        });
    </script>
@endsection
