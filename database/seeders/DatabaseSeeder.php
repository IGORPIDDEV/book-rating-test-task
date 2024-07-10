<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Rating;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::factory(10)->create();
        Book::factory(10)->create()->each(function ($book) {
            Rating::factory(5)->create(['book_id' => $book->id]);
        });
    }
}
