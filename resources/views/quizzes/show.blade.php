<!DOCTYPE html>
<html lang="uz">
@vite('resources/css/quiz.css')

<x-app-layout>
    <body>
        <div class="wrapper">
            <div class="container">
                <div class="carousel-container">
                    <div class="quiz-container" id="quiz1">
                        @foreach ($questions as $question)
                            <div class="quiz-header">
                                <h2 class="header-txt">{{ $quiz->slug }} Quiz 1</h2>
                            </div>
                            <div class="quiz-body">

                                <h2 id="question">{{ strip_tags($question->body) }}</h2>

                                @if ($question->question_type == 'multiple_choice')
                                    @foreach ($question->options as $option)
                                        <ul>
                                            <li id = "option_{{ $option->id }}">
                                                <input type="checkbox" id = "answer_{{ $option->id }}" />
                                                <label for="a"
                                                    id="option_{{ $option->id }}_text">{{ strip_tags($option->body) }}</label>
                                            </li>
                                        </ul>
                                    @endforeach
                                @elseif ($question->question_type == 'singular_choice')
                                    @foreach ($question->options as $option)
                                        <ul>
                                            <li id = "option_{{ $option->id }}">
                                                <input type="radio" id = "answer_{{ $option->id }}"
                                                    name = "answer_radio_field" />
                                                <label for="a"
                                                    id="option_{{ $option->id }}_text">{{ strip_tags($option->body) }}</label>
                                            </li>
                                        </ul>
                                    @endforeach
                                @else
                                    <ul>
                                        <li id = 'inp_text'><input name="answer" id="text_input" class="answer"
                                                type="text" placeholder="Submit your answer here!">
                                        </li>
                                    </ul>
                                @endif
                            </div>
                            <div class="quiz-footer">
                                <div class="quiz-details">
                                    <p>{{ request()->get('page') ?? '1' }} of {{ count($quiz->questions) }}</p>
                                </div>
                                @if (end($questions) === true)
                                    <button id="btn"
                                        onclick="checkResult({{ auth()->user() }}, {{ $question->options }}, {{ $quiz }}, {{ $question }}, {{ $result }}, {{ $question->getRightOptionsNum($question->id) }}, {{ $quiz->questions }})">Submit</button>
                                @else
                                    @if (count($quiz->questions) > 1)
                                        <a id = "button_href"><button id="btn"
                                                onclick="checkResult({{ auth()->user() }}, {{ $question->options }}, {{ $quiz }}, {{ $question }}, {{ $result }}, {{ $question->getRightOptionsNum($question->id) }}, {{ $quiz->questions }})">Submit</button></a>
                                    @else
                                        <a id = "button_href"><button id="btn"
                                                onclick="checkResult({{ auth()->user() }}, {{ $question->options }}, {{ $quiz }}, {{ $question }}, {{ $result }}, {{ $question->getRightOptionsNum($question->id) }}, {{ $quiz->questions }})">Submit</button></a>
                                    @endif
                                @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="carousel-controls">
                {{ $questions->links() }}
            </div>
        </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
            function checkResult(user, options, quiz, question, result, rightOptionNum, questions_quiz) {
                const data = {
                    key: 'smth'
                }
                axios.post(`{{ route('make_answered', '') }}/${question.id}`, data, {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        console.log(response.data);
                    })
                    .catch(error => {
                        console.error('Error:', error.response.data);
                    });
                if (document.querySelector('#btn').innerHTML === 'Finish') {
                    document.querySelector('#btn').disabled = false;
                } else {
                    document.querySelector('#btn').disabled = true;
                }
                let optionChecked;
                let mainResponse;
                options.some(opt => {
                    optionChecked = opt.id;
                    if (document.getElementById('answer_' + opt.id).checked) {
                        if (question.question_type === 'singular_choice' && opt.right_option === 1) {
                            if (question.answered == false) {
                                axios.post(`{{ route('check', '') }}/${result.id}`, data, {
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
                                        }
                                    })
                                    .then(response => {

                                    })
                                    .catch(error => {
                                        console.error('Error:', error.response.data);
                                    });
                            }
                        }
                        colorResults(options);
                        return true;
                    }
                })
                if (question.question_type === 'multiple_choice') {
                    let step = 0;
                    options.every(opt => {
                        if (document.getElementById('answer_' + opt.id).checked && opt.right_option === 1) {
                            step += 1;
                            return true;
                        } else if (document.getElementById('answer_' + opt.id).checked && opt
                            .right_option === 0) {

                            return false;
                        } else if (document.getElementById('answer_' + opt.id).checked === false && opt
                            .right_option ===
                            1) {
                            return false;
                        }
                    })
                    console.log(step + 'step');
                    if (step === rightOptionNum && question.answered == false) {
                        axios.post(`{{ route('add_points', '') }}/${result.id}`, data, {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
                        }
                    })
                    .then(response => {

                        console.log(response.data);
                    })
                    .catch(error => {
                        console.error('Error:', error.response.data);
                    });
                    
            }
        
            
                    }
                    colorResults(options);
                   
                                   
                
                if (questions_quiz.length === 1 || questions_quiz[questions_quiz.length - 1].id === question.id) {
                    document.querySelector('#btn').innerHTML = 'Finish'
                    document.querySelector('#btn').disabled = false;
                    document.querySelector('#btn').onclick = function() {
                        document.querySelector('#button_href').href = '/finish' + '/' + result.id + '/' + quiz
                            .id
                    };
                }
                if (question.question_type === 'closed_question' && question.answered == false) {
                    console.log(question.answer);
                    if (document.getElementById('text_input').value == question.answer) {
                        document.getElementById('inp_text').style.border = '2px solid #81C784';
                        axios.post(`{{ route('add_points', '') }}/${result.id}`, data, {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
                        }
                    })
                    .then(response => {

                        console.log(response.data);
                    })
                    .catch(error => {
                        console.error('Error:', error.response.data);
                    });
            }
          else {
                        document.getElementById('inp_text').style.border = '2px solid #DC143C'
                    }
                return false;
            }
        }
            
            function colorResults(options) {
                options.forEach(opt => {
                    if (opt.right_option === 1) {
                        document.getElementById('option_' + opt.id).classList.add('bg-green-300',
                            'text-white');
                    } else {
                        document.getElementById('option_' + opt.id).classList.add('bg-red-300',
                            'text-white');
                    }
                });
            }
    
        </script>
    </body>
</x-app-layout>
