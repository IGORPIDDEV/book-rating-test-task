<?php

namespace App\Services;

use App\Models\Rating;
use App\Models\Book;

class RatingService
{
    public function createRating($rating, $bookId)
    {
        $book = Book::findOrFail($bookId);
        $rating['user_id'] = auth()->id();
        return $book->ratings()->create($rating);
    }
}
