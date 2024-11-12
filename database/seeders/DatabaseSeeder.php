<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuestionType;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       // Question::factory(5)->create();
      //  for ($i = 0; $i < 5; $i++) {
         Quiz::factory(1)->create();
    //    }
         //Question::factory(200)->create();

        // QuestionType::factory(1)->create();

       // User::factory()->create([
      //      'name' => 'Test User',
     //       'email' => 'test@example.com',
     //   ]);
    }
}
