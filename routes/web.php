<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookController::class, 'index'])->name('books.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::post('/books/{book}/rate', [RatingController::class, 'create'])->name('rating.create');
});

Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');


require __DIR__.'/auth.php';
