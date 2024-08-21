@extends('layouts.admin')

@section('title', 'Question')

@section('content')
    <div class="container mx-auto w-[92%] md:w-[50%]">
        @include('components.admin.nav-qr-question', ['id' => $id])
    </div>
    @if (!$form_id)
        <div class="container mx-auto w-[92%] md:w-[60%]  h-[600px] form-question">
            <form action="{{ route('event.store.form') }}" method="post">
                @method('POST')
                @csrf
                <input type="hidden" name="event_id" value="{{ $id }}">
                <button type="submit" class="create_form">
                    <img src="{{ asset('assets/images/question.png') }}" alt="">
                    <h2>Tạo câu hỏi</h2>
                </button>
            </form>
        </div>
    @else
        <div class="container mx-auto w-[92%] md:w-[60%] min-h-[600px] form-question">
            {{-- Function of form question --}}
            <div class="form-function">
                {{-- <div class="btn-function btn-save-all">Lưu tất cả</div> --}}
                <a href="{{route('event.statistic.form', ['id' => $id])}}" class="btn-function btn-statistical" title="Thống kê các phản hồi của sinh viên"><i class="fa-light fa-chart-simple"></i></a>
                <a href="{{route('event.export.form', ['id' => $id])}}" class="btn-function btn-export" title="Xuất các phản hồi của sinh viên"><i class="fa-light fa-file-excel"></i></a>
                <a href="{{route('event.delete.form', ['id' => $id])}}" class="btn-function btn-delete-all" title="Xóa tất cả câu hỏi và phản hồi" onClick="confirm('Bạn có muốn xóa tất cả câu hỏi và mọi thứ liên quan?')"><i class="fa-light fa-trash-can"></i></a>
            </div>
            {{-- Form title --}}
            <div class="form-title">
                <h2>{{$event_name}}</h2>
                <input type="hidden" name="form_id" id="form_id" value="{{ $form_id}}">
                <hr>
            </div>
            {{-- Form content --}}
            <div id="question-wrapper" class="question-wrapper">
                @if ($questions && $questions->isNotEmpty())
                    @foreach ($questions as $question)
                        <div class="form-item" data-question-id="{{ $question->id }}">
                            <div class="grid grid-cols-1 md:grid-cols-12 md:gap-5">
                                <div class="md:col-span-8">
                                    <div class="input-question">
                                        <input class="item-input" type="text" value="{{ $question->text }}"
                                            placeholder="Câu hỏi">
                                        <div class="input-line-1"></div>
                                        <div class="input-line"></div>
                                    </div>
                                </div>
                                <div class="md:col-span-4">
                                    <div class="custom-select-wrapper">
                                        <div class="custom-select">
                                            <div class="selected-item">
                                                <!-- Hiển thị loại câu hỏi -->
                                                @if ($question->type == 'radio')
                                                    <i class="fa-regular fa-circle-dot"></i> Trắc nghiệm
                                                @elseif($question->type == 'checkbox')
                                                    <i class="fa-regular fa-square-check"></i> Hộp kiểm
                                                @elseif($question->type == 'text')
                                                    <i class="fa-solid fa-align-left"></i> Trả lời
                                                @endif
                                                <div class="icon-dropdown"><i class="fa-solid fa-angle-down"></i></div>
                                            </div>
                                            <ul class="options">
                                                <li data-value="radio"
                                                    class="{{ $question->type == 'radio' ? 'active-item' : '' }}"><i
                                                        class="fa-regular fa-circle-dot"></i> Trắc nghiệm</li>
                                                <li data-value="checkbox"
                                                    class="{{ $question->type == 'checkbox' ? 'active-item' : '' }}"><i
                                                        class="fa-regular fa-square-check"></i> Hộp kiểm</li>
                                                <li data-value="text"
                                                    class="{{ $question->type == 'text' ? 'active-item' : '' }}"><i
                                                        class="fa-solid fa-align-left"></i> Trả lời</li>
                                            </ul>
                                        </div>
                                        <input type="hidden" name="selected_option" id="selected_option"
                                            value="{{ $question->type }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Hiển thị các tùy chọn trả lời -->
                            <div class="item-options">
                                <div class="options-question"
                                    style="display: {{ $question->type == 'text' ? 'none' : 'flex' }}">
                                    @foreach ($question->answers as $answer)
                                        <div class="option">
                                            <div class="input-type">
                                                <input type="{{ $question->type }}" name="input-type" disabled>
                                            </div>
                                            <div class="input-content">
                                                <input type="text" value="{{ $answer->text }}"
                                                    data-answer-id ="{{ $answer->id }}" placeholder="Tùy chọn 1">
                                                <div class="input-line-1"></div>
                                                <div class="input-line"></div>
                                            </div>
                                            <i class="fa-solid fa-xmark cursor-pointer"></i>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="option" id="add-option"
                                    style="display: {{ $question->type == 'text' ? 'none' : 'flex' }}">
                                    <div class="input-type">
                                        <input type="{{ $question->type }}" name="input-type" id="" disabled>
                                    </div>
                                    <div class="add-option">Thêm tùy chọn</div>
                                </div>

                                <div class="option answer-text"
                                    style="display: {{ $question->type == 'text' ? 'block' : 'none' }}">
                                    <div class="input-content border">
                                        <input type="text" placeholder="Câu trả lời" disabled>
                                        <div class="input-line-1"></div>
                                        <div class="input-line"></div>
                                    </div>
                                </div>

                            </div>
                            <div class="p-3"></div>
                            <hr>
                            {{-- Setting item --}}
                            <div class="setting-item">
                                <div class="item-left">
                                    {{-- <button class="btn-question btn-question-save" title="Lưu câu hỏi"><i
                                            class="fa-regular fa-floppy-disk"></i></button> --}}
                                    <button class="btn-question btn-question-edit" title="Sửa câu hỏi"><i
                                            class="fa-solid fa-pencil"></i></button>
                                </div>
                                <div class="item-right">
                                    <div class="delete" title="Xóa">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </div>
                                    <div class="border-left"></div>
                                    <div class="required-item">
                                        <span>Bắt buộc </span>
                                        <label class="switch flex">
                                            <input type="checkbox" {{ $question->require ? 'checked' : '' }}
                                                name="require-question" id="require-question">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                @endif
            </div>

            {{-- Form content add new --}}
            <div id="add-question" class="add-question">
                <span>Thêm câu hỏi</span>
                <i class="fa-solid fa-plus"></i>
            </div>

            <!-- Template cho form content mới -->
            <template id="form-content-template">
                <div class="form-item new-item">
                    <div class="grid grid-cols-1 md:grid-cols-12 md:gap-5">
                        <div class="md:col-span-8">
                            {{-- Question --}}
                            <div class="input-question">
                                <input class="item-input" type="text" placeholder="Câu hỏi">
                                <div class="input-line-1"></div>
                                <div class="input-line"></div>
                            </div>
                        </div>
                        <div class="md:col-span-4">
                            {{-- Select type answer --}}
                            <div class="custom-select-wrapper">
                                <div class="custom-select">
                                    <div class="selected-item"><i class="fa-regular fa-circle-dot"></i>Trắc nghiệm
                                        <div class="icon-dropdown"><i class="fa-solid fa-angle-down"></i></div>
                                    </div>
                                    <ul class="options">
                                        <li data-value="radio" class="active-item"><i
                                                class="fa-regular fa-circle-dot"></i>Trắc
                                            nghiệm</li>
                                        <li data-value="checkbox"><i class="fa-regular fa-square-check"></i> Hộp kiểm</li>
                                        <li data-value="text"><i class="fa-solid fa-align-left"></i> Trả lời</li>
                                    </ul>
                                </div>
                                <input type="hidden" name="selected_option" id="selected_option" value="radio">
                            </div>
                        </div>
                    </div>
                    {{-- Input anwer option --}}
                    <div class="item-options">
                        <div class="options-question">
                            <div class="option">
                                <div class="input-type">
                                    <input type="radio" name="input-type" id="" disabled>
                                </div>
                                <div class="input-content">
                                    <input type="text" placeholder="Tùy chọn 1">
                                    <div class="input-line-1"></div>
                                    <div class="input-line"></div>
                                </div>
                                <i class="fa-solid fa-xmark cursor-pointer"></i>
                            </div>
                        </div>
                        <div class="option" id="add-option">
                            <div class="input-type">
                                <input type="radio" name="input-type" id="" disabled>
                            </div>
                            <div class="add-option">Thêm tùy chọn</div>
                        </div>
                        <div class="option answer-text" style="display: none;">
                            <div class="input-content border">
                                <input type="text" placeholder="Câu trả lời" disabled>
                                <div class="input-line-1"></div>
                                <div class="input-line"></div>
                            </div>
                        </div>
                    </div>
                    <div class="p-3"></div>
                    <hr>
                    {{-- Setting item --}}
                    <div class="setting-item">
                        <div class="item-left">
                            <button class="btn-question btn-question-save" title="Lưu câu hỏi"><i
                                    class="fa-regular fa-floppy-disk"></i></button>
                            {{-- <button class="btn-question btn-question-edit" title="Sửa câu hỏi"><i
                                    class="fa-solid fa-pencil"></i></button> --}}
                        </div>
                        <div class="item-right">
                            <div class="delete" title="Xóa">
                                <i class="fa-regular fa-trash-can"></i>
                            </div>
                            <div class="border-left"></div>
                            <div class="required-item">
                                <span>Bắt buộc </span>
                                <label class="switch flex">
                                    <input type="checkbox" name="require-question" id="require-question">
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    @endif


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 
            if (document.querySelectorAll('.form-item')) {
                const formItems = document.querySelectorAll('.form-item');
                formItems.forEach(item => {
                    handleCustomSelect(item);
                });
            }
            //Add new Question
            const addQuestionBtn = document.getElementById('add-question');
            const questionWrapper = document.getElementById('question-wrapper');
            const questionTemplate = document.getElementById('form-content-template').innerHTML;
            const loading = `<div role="status">
                            <svg aria-hidden="true" class="inline w-4 h-4 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                            <span class="sr-only">Loading...</span>
                        </div>`
            //Add new question function
            addQuestionBtn.addEventListener('click', function() {
                const newQuestionContent = document.createElement('div');
                newQuestionContent.innerHTML = questionTemplate;
                questionWrapper.appendChild(newQuestionContent);

                // Handle the custom select for newly added questions only
                const newFormItems = questionWrapper.querySelectorAll('.form-item.new-item');
                newFormItems.forEach(item => {
                    handleCustomSelect(item);
                    // Remove the 'new-item' class after handling to avoid reapplying the handler
                    item.classList.remove('new-item');
                });
            });

            // Save question item use ajax
            questionWrapper.addEventListener('click', function(event) {

                if (event.target.closest('.btn-question-save')) {
                    saveQuestion(event);
                } else if (event.target.closest('.btn-question-edit')) {
                    editQuestion(event);
                } else if (event.target.closest('.delete')) {
                    deleteQuestion(event);
                }
            });

            // Save a question
            async function saveQuestion(event) {
                const questionItem = event.target.closest('.form-item');
                const btnSaveQuestion = event.target.closest('.btn-question-save');
                const questionData = {
                    text: questionItem.querySelector('.input-question input[type="text"]')
                        .value,
                    type: questionItem.querySelector('#selected_option').value,
                    answers: Array.from(questionItem.querySelectorAll(
                        '.options-question input[type="text"]')).map(option => option
                        .value),
                    require: questionItem.querySelector('#require-question').checked,
                    form_id: document.querySelector('#form_id').value,
                };


                try {
                    btnSaveQuestion.innerHTML = loading;
                    const url = "{{ route('event.store.question') }}"
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(questionData),
                    })

                    const result = await response.json();
                    if (result.success) {
                        questionItem.setAttribute('data-question-id', result.question_id);
                        showQuestion(questionItem);
                        questionItem.style.border = '1px solid #38bdf8';
                        btnSaveQuestion.innerHTML = `<i class="fa-solid fa-floppy-disk"></i>`
                    } else {
                        alert('Failed to save the question.');
                    }
                } catch (error) {
                    console.error('Error saving question:', error);
                }
            }

            // Edit question
            async function editQuestion(event) {
                const questionItem = event.target.closest('.form-item');
                const btnEditQuestion = event.target.closest('.btn-question-edit');
                const answerComponent = questionItem.querySelector('.options-question');
                const questionId = questionItem.dataset.questionId;

                const questionData = {
                    text: questionItem.querySelector('.input-question input[type="text"]').value,
                    type: questionItem.querySelector('#selected_option').value,
                    answers: Array.from(questionItem.querySelectorAll(
                        '.options-question input[type="text"]')).map(option => {
                        return {
                            id: option.dataset.answerId,
                            text: option.value
                        };
                    }),
                    require: questionItem.querySelector('#require-question').checked,
                    form_id: document.querySelector('#form_id').value,
                };

                console.log("Edit", questionData);

                try {
                    btnEditQuestion.innerHTML = loading;
                    const url = "{{ route('event.update.question', ['id' => ':id']) }}".replace(':id',
                        questionId)
                    const response = await fetch(url, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify(questionData),
                    })

                    const result = await response.json();
                    if (result.success) {
                        showQuestion(questionItem);
                        questionItem.style.border = '1px solid #4ade80';
                        btnEditQuestion.innerHTML = `<i class="fa-solid fa-pencil"></i>`
                    } else {
                        alert('Failed to edit the question.');
                    }
                } catch (error) {
                    console.error('Error edit question:', error);
                }
            }


            // Show question
            async function showQuestion(questionItem) {
                const questionId = questionItem.dataset.questionId;
                const url = "{{ route('event.show.question', ['id' => ':id']) }}".replace(':id', questionId);

                try {
                    const response = await fetch(url);
                    const result = await response.json();

                    // Kiểm tra nếu có dữ liệu câu hỏi
                    if (result) {
                        const question = result;
                        questionItem.setAttribute('data-question-id', question.id);
                        const answersHtml = question.answers.map(answer => `
                        <div class="option">
                            <div class="input-type">
                                <input type="${question.type}" name="input-type" disabled>
                            </div>
                            <div class="input-content">
                                <input type="text" value="${answer.text}" data-answer-id="${answer.id}" placeholder="Tùy chọn">
                                <div class="input-line-1"></div>
                                <div class="input-line"></div>
                            </div>
                            <i class="fa-solid fa-xmark cursor-pointer"></i>
                        </div>
                        `).join('');

                        const questionHtml = `
                            <div class="grid grid-cols-1 md:grid-cols-12 md:gap-5">
                                <div class="md:col-span-8">
                                    <div class="input-question">
                                        <input class="item-input" type="text" value="${question.text}" placeholder="Câu hỏi">
                                        <div class="input-line-1"></div>
                                        <div class="input-line"></div>
                                    </div>
                                </div>
                                <div class="md:col-span-4">
                                    <div class="custom-select-wrapper">
                                        <div class="custom-select">
                                            <div class="selected-item">
                                                ${question.type == 'radio' ? '<i class="fa-regular fa-circle-dot"></i> Trắc nghiệm' : ''}
                                                ${question.type == 'checkbox' ? '<i class="fa-regular fa-square-check"></i> Hộp kiểm' : ''}
                                                ${question.type == 'text' ? '<i class="fa-solid fa-align-left"></i> Trả lời' : ''}
                                                <div class="icon-dropdown"><i class="fa-solid fa-angle-down"></i></div>
                                            </div>
                                            <ul class="options">
                                                <li data-value="radio" class="${question.type == 'radio' ? 'active-item' : ''}">
                                                    <i class="fa-regular fa-circle-dot"></i> Trắc nghiệm
                                                </li>
                                                <li data-value="checkbox" class="${question.type == 'checkbox' ? 'active-item' : ''}">
                                                    <i class="fa-regular fa-square-check"></i> Hộp kiểm
                                                </li>
                                                <li data-value="text" class="${question.type == 'text' ? 'active-item' : ''}">
                                                    <i class="fa-solid fa-align-left"></i> Trả lời
                                                </li>
                                            </ul>
                                        </div>
                                        <input type="hidden" name="selected_option" id="selected_option" value="${question.type}">
                                    </div>
                                </div>
                            </div>
                            <div class="item-options">
                                <div class="options-question" style="display: ${question.type == 'text' ? 'none' : 'flex'}">
                                    ${answersHtml}
                                </div>
                                <div class="option" id="add-option" style="display: ${question.type == 'text' ? 'none' : 'flex'}">
                                    <div class="input-type">
                                        <input type="radio" name="input-type" disabled>
                                    </div>
                                    <div class="add-option">Thêm tùy chọn</div>
                                </div>
                                <div class="option answer-text" style="display: ${question.type == 'text' ? 'block' : 'none'}">
                                    <div class="input-content border">
                                        <input type="text" placeholder="Câu trả lời" disabled>
                                        <div class="input-line-1"></div>
                                        <div class="input-line"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3"></div>
                            <hr>
                            <div class="setting-item">
                                <div class="item-left">
                                    <button class="btn-question btn-question-edit" title="Sửa câu hỏi">
                                        <i class="fa-solid fa-pencil"></i>
                                    </button>
                                </div>
                                <div class="item-right">
                                    <div class="delete" title="Xóa">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </div>
                                    <div class="border-left"></div>
                                    <div class="required-item">
                                        <span>Bắt buộc</span>
                                        <label class="switch flex">
                                            <input type="checkbox" ${question.require ? 'checked' : ''} name="require-question" id="require-question">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                    `;

                    questionItem.innerHTML = questionHtml;
                    } else {
                        questionItem.innerHTML = '<p>Lỗi khi tải câu hỏi.</p>';
                    }
                } catch (error) {
                    console.error('Lỗi khi tải câu hỏi:', error);
                    questionItem.innerHTML = '<p>Lỗi khi tải câu hỏi.</p>';
                }
            }


            //Delete question
            async function deleteQuestion(event) {
                const questionItem = event.target.closest('.form-item');
                const questionId = questionItem.dataset.questionId;
                const btnDeleteQuestion = questionItem.querySelector('.delete');
                const confirmed = confirm("Bạn có chắc chắn muốn xóa câu hỏi này không?");
                if (confirmed) {
                    try {
                        btnDeleteQuestion.innerHTML = loading;
                        const url = "{{ route('event.delete.question', ['id' => ':id']) }}".replace(':id',
                            questionId);
                        const response = await fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                            },
                        });

                        const result = await response.json();
                        if (result.success) {
                            questionItem.remove();
                        }

                    } catch (error) {
                        console.error('Error deleting question: ', error)
                    }
                }
            }


            // Function to handle the custom select behavior
            function handleCustomSelect(item) {
                const wrapper = item.querySelector('.custom-select-wrapper');
                const customSelect = wrapper.querySelector('.custom-select');
                const selectedItem = wrapper.querySelector('.selected-item');
                const options = wrapper.querySelectorAll('.options li');
                const hiddenInput = wrapper.querySelector('input[type="hidden"]');
                const inputTypes = item.querySelectorAll('input[name="input-type"]');
                const answerContainer = item.querySelector('.options-question');
                const addOption = item.querySelector('#add-option');
                const itemAnswers = item.querySelector('.item-options');
                const addNewOptiton = item.querySelector('#add-option');
                const answerText = itemAnswers.querySelector('.answer-text') ?? null;

                let typeAnswerValue = 'radio';
                let numberOption = 2;

                selectedItem.addEventListener('click', function() {
                    customSelect.classList.toggle('active');
                });



                //Select type of answer and set type answer
                options.forEach(option => {
                    option.addEventListener('click', function() {
                        typeAnswerValue = this.getAttribute('data-value');
                        const text = this.innerHTML;

                        options.forEach(opt => opt.classList.remove('active-item'));
                        this.classList.add('active-item');
                        selectedItem.innerHTML = text +
                            ' <div class="icon-dropdown"><i class="fa-solid fa-angle-down"></i></div>';
                        hiddenInput.value = typeAnswerValue;

                        // Create answer type input text
                        if (typeAnswerValue == 'text') {
                            answerText.style.display = 'flex';
                            answerContainer.style.display = 'none';
                            addOption.style.display = 'none';


                        } else {

                            if (answerText) {
                                answerText.style.display = 'none';
                            }
                            answerContainer.style.display = 'flex';
                            addOption.style.display = 'flex';
                            updateInputTypes(item);
                        }

                        customSelect.classList.remove('active');
                    });
                });

                //Add new answer
                addNewOptiton.addEventListener('click', function() {
                    const optionQuestionElement = document.createElement('div');
                    optionQuestionElement.classList.add('option');
                    optionQuestionElement.innerHTML = `
                        <div class="input-type">
                            <input type="radio" name="input-type" id="" disabled>
                        </div>
                        <div class="input-content">
                            <input type="text" placeholder="Tùy chọn ${numberOption}">
                            <div class="input-line-1"></div>
                            <div class="input-line"></div>
                        </div>
                        <i class="fa-solid fa-xmark cursor-pointer" ></i>`;
                    numberOption++;
                    answerContainer.appendChild(optionQuestionElement);

                    // Update type for all input types including newly added ones
                    updateInputTypes(item);
                });

                answerContainer.addEventListener('click', function(event) {
                    if (event.target.classList.contains('fa-xmark')) {
                        numberOption--;
                        deleteAnswer(event.target);
                    }
                });

                //Update answer type
                function updateInputTypes(item) {
                    const inputTypes = item.querySelectorAll('input[name="input-type"]');
                    inputTypes.forEach(inputType => {
                        if (typeAnswerValue !== "text") {
                            inputType.setAttribute('type', typeAnswerValue);
                        }
                    });
                }

                //Delete answer
                function deleteAnswer(target) {
                    const optionElement = target.closest('.option')
                    if (optionElement) {
                        optionElement.remove();
                    }
                }

                // Close select option answer
                document.addEventListener('click', function(e) {
                    if (!wrapper.contains(e.target)) {
                        customSelect.classList.remove('active');
                    }
                });
            }


        });
    </script>
@endsection
