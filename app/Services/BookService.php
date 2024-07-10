<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    public function getBooks($sort)
    {
        $query = Book::query();

        switch ($sort) {
            case 'rating':
                $query->withCount('ratings as average_rating')
                      ->orderBy('average_rating', 'desc');
                break;

            case 'title':
                $query->orderBy('title');
                break;

            case 'latest':
            default:
                $query->latest();
                break;
        }

        return $query->limit(10)->get();
    }

    public function searchBooks($query)
    {
        return Book::where('title', 'like', "%$query%")
            ->orWhere('author', 'like', "%$query%")
            ->get();
    }

    public function getAverageRating(Book $book)
    {
        return $book->ratings()->avg('rating');
    }

    public function rateBook(Book $book, $rating, $comment = null)
    {
        $book->ratings()->create([
            'user_id' => auth()->id(),
            'rating' => $rating,
            'comment' => $comment
        ]);
    }

    public function getOtherBooks($bookId)
    {
        return Book::where('id', '!=', $bookId)->latest()->take(5)->get();
    }

    public function storeBook($request)
    {
        return Book::create($request);
    }
}
