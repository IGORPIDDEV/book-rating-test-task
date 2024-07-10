<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index(Request $request)
    {
        $sort = $request->input('sort', 'latest');

        if ($this->shouldRedirectForEmptySearch($request)) {
            return redirect()->route('books.index', ['sort' => $sort]);
        }

        $books = $request->has('search')
            ? BookResource::collection($this->bookService->searchBooks($request->get('search')))->toArray($request)
            : BookResource::collection($this->bookService->getBooks($sort))->toArray($request);

        return view('books.index', compact('books'));
    }

    public function show(Request $request, Book $book)
    {
        $averageRating = $this->bookService->getAverageRating($book);
        $otherBooks = BookResource::collection($this->bookService->getOtherBooks($book->id))->toArray($request);
        return view('books.show', compact('book', 'averageRating', 'otherBooks'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(BookRequest $request)
    {
        $validatedData = $request->validated();
        $this->bookService->storeBook($validatedData);
        return redirect()->route('books.index');
    }

    private function shouldRedirectForEmptySearch(Request $request)
    {
        return $request->has('search') && trim($request->get('search')) === '';
    }
}
