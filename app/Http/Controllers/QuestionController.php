<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionType;
use Illuminate\Http\Request;
use App\Models\Quiz;


class QuestionController extends Controller
{
    public function get() {
        return view('get_question');
    }

    public function create(Request $req) {
        //$question = new Question();
        $quiz = Quiz::where('id', $req->get('quizId'))->firstOrFail();
        $quiz->questions()->create([
            'quiz_id' => $req->get('quizId'),
            'body' => '32323',
            'question_type' => 'Multiple Choice',
            'slug' => '1221'
        ]);
    }
}
