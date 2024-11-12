<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    public function definition(): array
    {

        // Create an array with 5 random elements
        
        return [
            'user_id' => User::factory(),
            'category' => Category::factory(),
            'slug'=> $this->faker->slug(3),
            'created_date' => $this->faker->dateTimeBetween('-1 Week', '+1 week'),
            'featured' => $this->faker->boolean(25)
        ];
    }
}
