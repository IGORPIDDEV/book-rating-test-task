<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\RatingRequest;
use App\Services\RatingService;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    protected $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    public function create(RatingRequest $request, $bookId)
    {
        $validatedData = $request->validated();
        $this->ratingService->createRating($validatedData, $bookId);
        return redirect()->route('books.show', $bookId)->with('success', 'Rating created successfully.');
    }

}
