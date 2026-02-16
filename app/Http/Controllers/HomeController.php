<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $mostBorrowedBooks = Book::withCount('borrows')
        ->orderByDesc('borrows_count')
        ->take(5)
        ->get();


        if ($user->role === 'admin') {
            $totalBorrowedBooks = Borrow::where('status', 'approved')->count();
            $totalUsers = User::where('role', '!=', 'admin')->count();
            $books = Book::latest()->take(5)->get();
            $pendingBorrows = Borrow::where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->get();
            $totalBooks = Book::count();
            $mostBorrowedBook = Borrow::select('book_id', DB::raw('COUNT(*) as borrow_count'))
                ->groupBy('book_id')
                ->orderByDesc('borrow_count')
                ->with('book') 
                ->first();
            $mostCategory = Book::select('category', DB::raw('COUNT(*) as total'))
                ->groupBy('category')
                ->orderByDesc('total')
                ->first();

            return view('home', compact(
            'totalBorrowedBooks', 
            'totalUsers', 
            'books', 
            'pendingBorrows',
            'totalBooks',
            'mostBorrowedBook',
            'mostCategory',
            'mostBorrowedBooks'));
        }

        $newestBooks = Book::latest()->take(2)->get();
        return view('home', compact('mostBorrowedBooks','newestBooks'));
    }

    
}
