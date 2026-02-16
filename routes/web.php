<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [BookController::class, 'index'])->name('books.index');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Auth::routes();

Route::middleware(['auth'])->group(function () {
    
    Route::middleware(['admin'])->group(function () {
        Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
        Route::post('/books', [BookController::class, 'store'])->name('books.store');
        Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    });

    Route::patch('/borrows/{id}/approve', [BorrowController::class, 'approve'])->name('borrows.approve');
    Route::patch('/borrows/{id}/reject', [BorrowController::class, 'reject'])->name('borrows.reject');
    Route::post('/books/{book}/borrow', [BorrowController::class, 'borrow'])->name('books.borrow');
    Route::post('/borrow/{borrow}/return', [BorrowController::class, 'return'])->name('books.return');
    Route::get('/my-borrows', [BorrowController::class, 'userBorrows'])->name('books.myBorrows');
    Route::post('/books/{book}/return', [BookController::class, 'returnBook'])->name('books.return');
    Route::post('/books/{id}/return', [BookController::class, 'returnBook'])->name('books.return');

    Route::middleware(['auth'])->group(function () {
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    });

    Route::get('/borrow-history', [BorrowController::class, 'history'])->name('borrows.history');
    Route::get('/admin/users', [UserController::class, 'index'])->name('users');

});
Route::patch('/borrows/{id}/reject', [BorrowController::class, 'reject'])->name('borrows.reject');


Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/most-borrowed', [BookController::class, 'mostBorrowedBooks'])->name('books.mostBorrowed');

Route::middleware(['auth'])->group(function () {
    Route::get('/my-borrow-history', [BorrowController::class, 'userHistory'])->name('borrows.userHistory');
});

