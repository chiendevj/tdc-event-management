@extends('layouts.admin')

@section('title', 'Statistical')

@section('content')
    <div class="container mx-auto w-[92%] md:w-[50%]">
        @include('components.admin.nav-qr-question', ['id' => $id])
    </div>
    <div class="container mx-auto w-[92%] md:w-[50%]">
        <h1 class="statistic-title">Thống kê</h1>
        <hr>
        <h2 class="event-title">{{ $event_name }}</h2>
    </div>
    <div class="container mx-auto w-[92%] md:w-[60%]  min-h-[600px]">
        <div class="form-statistic">
            @foreach ($statistics as $statistic)
                <div class="statistic-item">
                    <div class="question-content">{{ $statistic['question']['text'] }}</div>
                    <div class="quantity-answer">{{ $statistic['response_count'] }} câu trả lời</div>
                    @if ($statistic['question']['type'] != 'text')
                        <div class="chart-container">
                            <canvas id="chart_{{ $statistic['question']['id'] }}"></canvas>
                        </div>
                    @else
                        <div class="answers-component" id="question_{{ $statistic['question']['id'] }}">
                        </div>
                    @endif
                </div>
            @endforeach

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statisticsData = @json($statistics);

            statisticsData.forEach(statistic => {
                var ctx = document.getElementById(`chart_${statistic.question.id}`);
                if (statistic.question.type == 'radio') {
                    var chart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: statistic.answers.map(answer => answer.text),
                            datasets: [{
                                label: '# of Votes',
                                data: Object.values(statistic.answers_counts),
                                backgroundColor: [
                                    'rgb(255, 99, 132)',
                                    'rgb(54, 162, 235)',
                                    'rgb(255, 206, 86)',
                                    'rgb(75, 192, 192)',
                                    'rgb(153, 102, 255)',
                                    'rgb (255, 159, 64)'
                                ],
                                borderColor: [
                                    'rgb(255, 99, 132)',
                                    'rgb(54, 162, 235)',
                                    'rgb(255, 206, 86)',
                                    'rgb(75, 192, 192)',
                                    'rgb(153, 102, 255)',
                                    'rgb(255, 159, 64)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'right',
                                },
                                tooltip: {
                                    callbacks: {
                                        // label: function(tooltipItem) {
                                        //     return tooltipItem.label + ': ' + tooltipItem.raw +
                                        //         ' lựa chọn';
                                        // }
                                        label: function(tooltipItem) {
                                            // Lấy tổng số của tất cả các giá trị
                                            var total = tooltipItem.dataset.data.reduce((sum,
                                                value) => sum + value, 0);

                                            // Tính phần trăm của giá trị hiện tại
                                            var percentage = ((tooltipItem.raw / total) * 100)
                                                .toFixed(2);

                                            // Trả về label và phần trăm
                                            return tooltipItem.label + ': ' + tooltipItem.raw +
                                                ' (' + percentage + '%)';
                                        }
                                    }
                                }
                            }
                        }
                    });
                } else if (statistic.question.type == 'checkbox') {
                    var lineChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: statistic.answers.map(answer => answer.text),
                            datasets: [{
                                labels: 'hello',
                                data: Object.values(statistic.answers_counts),
                                backgroundColor: 'rgb(54, 162, 235)',
                                borderColor: 'rgb(54, 162, 235)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            indexAxis: 'y',
                            plugins: {
                                legend: {
                                    display: false,
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            // Lấy tổng số của tất cả các giá trị
                                            var total = tooltipItem.dataset.data.reduce((sum,
                                                value) => sum + value, 0);

                                            // Tính phần trăm của giá trị hiện tại
                                            var percentage = ((tooltipItem.raw / total) * 100)
                                                .toFixed(2);

                                            // Trả về label và phần trăm
                                            return tooltipItem.label + ': ' + tooltipItem.raw +
                                                ' (' + percentage + '%)';
                                        }
                                    }
                                }
                            },

                        }
                    });
                } else {
                    console.log(statistic.text_responses);

                    const answerComponent = document.getElementById(`question_${statistic.question.id}`);
                    statistic.text_responses.forEach(answerValue => {
                        const answer = document.createElement('div');
                        answer.classList.add('answer');
                        answer.innerHTML = answerValue;
                        answerComponent.appendChild(answer);

                    });

                }


            });

        });
    </script>
@endsection
