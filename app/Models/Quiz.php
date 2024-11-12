<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Quiz extends Model
{
    protected $fillable = [
        'user_id', 'slug', 'category', 'created_date', 'featured'
    ];

    use HasFactory;
    public function category() {
        return $this->belongsTo(Category::class, 'category');
    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopePublished($query)
    {
        return $query->where('created_date', '<=', Carbon::now());
    }


    public function questions(){
        return $this->hasMany(Question::class);
       // return Question::where('quiz_id', $quiz)->paginate(1);
    }

    public function participants() {
        return $this->hasMany(User::class);
    }

    public function getMaxResult() {
        return count($this->questions) * 10;
    }
}
