<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Quiz;
use Carbon\Carbon;
use App\Models\Result;

class QuizController extends Controller
{
    public function index() {

           // $quiz = Quiz::create(
       //         [
       //             'user_id' => 1,
        //            'slug' => fake()->slug(),
        //            'category' => 'Algebra',
        //            'created_date' => Carbon::now(),
        //            'featured' => true,
        //        ]
         //       );

       //         for ($i = 0; $i< 10; $i++) {
       //             $quiz->questions->
         //       }

        return view('quizzes.index', [
            'quizzes' => [],
        ]);
    }

    public function show($quiz) {
      //  $rightOptions = 0;
        $questions = Question::where('quiz_id', $quiz)->where('answered',0)->take(1)->get();
        //dd(auth()->user()->results);

     //   foreach($quiz->questions as $question) {
  ///          if ($question->right_option) {
  //              $rightOptions++;
   //         }
   //     }
       // dd($questions);
        //dd('dssd');
        //dd(Question::where('category',  $quiz->category))->firstOrFail();
      //  $result = Result::where('quiz_id', $quiz)->where('user_id', auth()->user()->id, )->firstOrFail();
        $quiz = Quiz::where('id', $quiz)->firstOrFail();
        if (Result::where('quiz_id', $quiz->id)->where('user_id', auth()->user()->id, )->exists()) {

            $result = Result::where('quiz_id', $quiz->id)->where('user_id', auth()->user()->id, )->orderBy('id', 'desc')->first();
            if ($result->isOld === 1) {
               // dd('wqwq');
                $result = auth()->user()->results()->create([
                    'quiz_id' => $quiz->id,
                    'user_id' => auth()->user()->id,
                ]);

             }

        } else {
            $result = auth()->user()->results()->create([
                   'quiz_id' => $quiz->id,
                   'user_id' => auth()->user()->id,
               ]);
            }




     // $result = auth()->user()->results()->create([
     //       'quiz_id' => $quiz->id,
     //       'user_id' => auth()->user()->id,
     //   ]);
      //  $quiz->participants()->create([
     //      'user_id' => auth()->user()->id
     //   ]);
       // $attempt = new Attempt();
     //   $attempt->quiz_id = $quiz->id;
      //  $attempt->user_id = auth()->user()->id;
      //  $attempt->save();

      //  dd(auth()->user()->takenQuizzes());

       // auth()->user()->takenQuizzes()->create([
      //      $quiz
      //  ]);
        // foreach($quiz->questions as $question) {
        //dd($question);
       // }
       //dd($quiz->questions);
        return view('quizzes.show', [
            'questions' => $quiz->questions()->simplePaginate(1),
        //  'questions' => $questions,
            'quiz' => $quiz,
            'result' => $result
         //   'attempt' => $attempt
        ]);
    }
}
