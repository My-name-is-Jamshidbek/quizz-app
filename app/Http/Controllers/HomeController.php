<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;


class HomeController extends Controller
{
    public function index() {

        //$categories = Category::take(value: '*')->get();
        return view('home', [
            'featuredQuizzes' => Quiz::latest(column: 'created_date')->take(value: 3)->get()
        ]);
    }
}
