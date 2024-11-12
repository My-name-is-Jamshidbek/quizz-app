<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use App\Models\QuestionType;
use Symfony\Component\Console\Question\Question;
use App\Models\Quiz;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('body');
            $table->string('question_type');
            $table->boolean('answered')->default(false);
            $table->boolean('isOld')->default(false);
           // $table->boolean('right_option')->default(false);
            $table->foreignIdFor(Quiz::class);
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
