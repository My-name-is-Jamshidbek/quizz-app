<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Option;
use App\Models\Result;
use App\Models\Question;
use App\Models\Quiz;

class CheckResultsController extends Controller
{
    public function check($res, Option $opt)
    {
        $result = Result::where('id', $res)->firstOrFail();
        $result->update(['result' => $result->result + 10]);
        return response()->json(['message' => $result]);
    }

    public function finish($res, $quiz_id)
    {
        $quiz = Quiz::find($quiz_id);
        foreach ($quiz->questions as $question) {
            $question->answered = false;
            $question->save();
        }
        $res = Result::find($res);
        return view('resultView', [
            'res' => $res,
            'quiz' => $quiz,
        ]);
    }

    public function answer($question_id)
    {
            $question = Question::find($question_id);
            $question->answered = 1;
            $question->save();
            return response()->json(['message' => $question_id]);
    }

    public function preCheck($question_id)
    {
        $question = Question::find($question_id)->firstOrFail();
        if ($question->answered == false) {
            return response()->json(['message' => true]);
        }
    }

    public function addPointsToResult($res, Option $opt)
    {
        $result = Result::where('id', $res)->firstOrFail();
        $result->update(['result' => $result->result + 10]);
        return response()->json(['message' => $result]);
    }

    public function quizHasStarted($result_id) {
       $result = Result::where('id', $result_id)->firstOrFail();
       $result->quizHasStarted = true;
       $result->save();
       return response()->json(['message' => $result]);
    }
}
