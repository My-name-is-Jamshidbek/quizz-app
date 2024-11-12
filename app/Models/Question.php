<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_id', 'question_type', 'body', 'slug', 'answered', 'answer'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function questionType()
    {
        return $this->has(QuestionType::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function rightOptions()
    {
        return $this->hasMany(RightOptions::class);
    }

    public function answers()
    {
        return $this->hasMany(Option::class);
    }

    public function getRightOptionsNum($question_id)
    {
        $rightOptions = 0;
        $question = Question::find($question_id)->firstOrFail();
      //  dd(count($question->options));
        foreach ($question->options as $option) {
         //   dd($option);
            if ($option->get('right_option')) {
                $rightOptions+=1;
            }
        }
       // dd($rightOptions);
        return $rightOptions;
    }
}
