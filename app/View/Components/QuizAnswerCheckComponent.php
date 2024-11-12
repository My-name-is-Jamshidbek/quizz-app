<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Http\Request;

class QuizAnswerCheckComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
//
    }
    public function check($options, $quiz) {
        dd('jje');

        foreach($options as $option) {

        auth()->user()->choices()->create([
            'user_id' => auth()->user()->id,
            'question_id' =>
        ])
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        //return view('components.quiz-answer-check-component');
        return view('quizzes.show');
    }
}
