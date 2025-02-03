<?php

use App\Http\Controllers\OAuth2Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\CheckResultsController;


//Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/', [OAuth2Controller::class, 'login'])->name('home');

Route::get('oauth-login-student',[OAuth2Controller::class,'loginStudent'])->name('oauth-login-student');
Route::get('callback/student',[OAuth2Controller::class,'callStudent'])->name('call-student');

Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');

Route::get('/show/{quiz_id}', [QuizController::class, 'show'])->name('quiz.show')->middleware('auth');
Route::get('/ask', [QuestionController::class, 'get'])->name('question.ask');
Route::post('/create', [QuestionController::class, 'create'])->name('question.create');

Route::post('/check/{id}', [CheckResultsController::class, 'check'])->name('check');
Route::post('/precheck/{id}', [CheckResultsController::class, 'preCheck'])->name('pre_check');

Route::post('/answer/{id}', [CheckResultsController::class, 'answer'])->name('make_answered');
Route::post('/addpoints/{id}', [CheckResultsController::class, 'addPointsToResult'])->name('add_points');
Route::post('/started/{id}', [CheckResultsController::class, 'quizHasStarted'])->name('quizHasStarted');

//Route::get('/language/{locale}', function($locale) {
 //   if(array_key_exists($locale, config('app.supported_locales'))) {
 //       session()->put('locale', $locale);
//    }
//    return redirect()->back();
//})->name('language.switch');

//Route::post('/attempt', [AttemptController::class, 'store'])->name('attempt');

Route::get('/finish/{id}/{quiz_id}', [CheckResultsController::class, 'finish'])->name('finish');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
  //  Route::get('/dashboard', function () {
   //     return view('dashboard');
 //   })->name('dashboard');
});
