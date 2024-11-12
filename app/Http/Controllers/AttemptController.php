<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttemptController extends Controller
{
    public function store() {

                    dd(App\Models\Attempt::where('user_id', auth()->user()->id)->firstOrFail()->answers()->create([
                        'body' => $option->body,
                        'question_id' => $question->id
                    ]))

    }
}
