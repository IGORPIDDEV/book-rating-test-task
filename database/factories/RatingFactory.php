<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    protected $model = Rating::class;

    public function definition()
    {
        return [
            'book_id' => Book::factory(),
            'user_id' => User::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
        ];
    }
}
