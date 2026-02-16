<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/')->with('error', 'Access Denied');
        }
    
        $books = Book::all(); 
        return view('books.create', compact('books')); 
    }
    
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'author' => 'required',
        'category' => 'required|string|max:255',
        'year' => ['required', 'integer', 'max:' . date('Y')],
        'quantity' => 'required|integer|min:1',
        'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $coverPath = null;

    if ($request->hasFile('cover')) {
        $coverPath = $request->file('cover')->store('covers', 'public');
    }

    Book::create([
        'title' => $request->title,
        'author' => $request->author,
        'category' => $request->category,
        'year' => $request->year,
        'quantity' => $request->quantity,
        'cover' => $coverPath,
    ]);

    return redirect()->route('books.create')->with('success', 'Book added successfully!');
}

    public function edit(Book $book)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/')->with('error', 'Access Denied');
        }
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'category' => 'required|string|max:255',
            'year' => ['required', 'integer', 'max:' . date('Y')],
            'quantity' => 'required|integer|min:1',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle cover upload
        if ($request->hasFile('cover')) {
            // Delete old cover if exists
            if ($book->cover && \Storage::disk('public')->exists($book->cover)) {
                \Storage::disk('public')->delete($book->cover);
            }

            // Upload new cover
            $coverPath = $request->file('cover')->store('covers', 'public');
            $book->cover = $coverPath;
        }

        // Update other fields
        $book->title = $request->title;
        $book->author = $request->author;
        $book->category = $request->category;
        $book->year = $request->year;
        $book->quantity = $request->quantity;

        $book->save();

        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }


    public function destroy(Book $book)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/')->with('error', 'Access Denied');
        }

        $hasPendingOrApproved = Borrow::where('book_id', $book->id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($hasPendingOrApproved) {
            return redirect()->route('books.index')->with('error', 'Cannot delete. There are pending or active borrow requests.');
        }

        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
    }

    public function returnBook($bookId)
{
    if (auth()->user()->role === 'admin') {
        $borrow = Borrow::where('book_id', $bookId)
            ->where('status', 'approved')
            ->first();
    } else {
        $borrow = Borrow::where('book_id', $bookId)
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->first();
    }

    if ($borrow) {
        $borrow->status = 'returned';
        $borrow->returned_at = now(); 
        $borrow->save();

        return response()->json(['status' => 'returned']);
    }

    return response()->json(['error' => 'Book not found or already returned'], 400);
}


}
