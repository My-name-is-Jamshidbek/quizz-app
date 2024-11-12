<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    protected $fillable = [
        'option_id', 'question_id', 'user_id'
    ];

    public function body($option_id) {
        return Option::where('id', $option_id)->firstOrFail();
    }

    public function option() {
        return $this->belongsTo(Option::class);
    }

    public function question() {
        return $this->belongsTo(Question::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
