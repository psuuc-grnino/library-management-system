<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    public function borrow(Book $book)
    {
        $user = Auth::user();

        // dito e check transaction ng borrow books
        $alreadyBorrowed = Borrow::where('book_id', $book->id)
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved']) 
            ->exists();

        if ($alreadyBorrowed) {
            return redirect('/')->with('error', 'You have already borrowed or requested this book.');
        }

        if ($book->quantity > 0) {
            // pending req
            Borrow::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'borrowed_at' => now(),
                'status' => 'pending', 
            ]);

            return redirect('/')->with('success', 'Your request has been submitted. Please wait for admin approval.');
        }

        return redirect('/')->with('error', 'This book is out of stock.');
    }

    public function returnBook(Book $book)
    {
        $borrow = Borrow::where('book_id', $book->id)
                        ->where('user_id', auth()->id())
                        ->whereIn('status', ['approved', 'pending'])
                        ->first();
    
        if (!$borrow) {
            \Log::error('Return failed: No borrow record found for book_id ' . $book->id . ' and user_id ' . auth()->id());
            return response()->json(['error' => 'Borrow record not found'], 404);
        }
    
        $borrow->status = 'returned';
        $borrow->returned_at = now(); 
        $borrow->save();

        $book->quantity += 1;
        $book->save();
    
        return response()->json(['status' => 'returned']);
    }
    

        public function approve($id)
    {
        $borrow = Borrow::findOrFail($id);
        $borrow->status = 'approved';
        $borrow->save();

        return response()->json(['status' => 'approved']);
    }

    public function reject($id)
    {
        $borrow = Borrow::findOrFail($id);
        $borrow->status = 'rejected';
        $borrow->save();
    
        return response()->json(['status' => 'rejected']);
    }

public function userBorrows()
{
    $borrows = Borrow::with('book')
        ->where('user_id', Auth::id())
        ->get()
        ->map(function ($borrow) {
            $dueDate = $borrow->borrowed_at->copy()->addDays(3);
            $borrow->isOverdue = now()->greaterThan($dueDate) && $borrow->status === 'approved';
            $borrow->due_date = $dueDate->toDateString();
            return $borrow;
        });

    return view('borrows.index', compact('borrows'));
}


    public function pendingRequests()
    {
        $pendingBorrows = Borrow::where('status', 'pending')->get();
        return view('admin.pending_requests', compact('pendingBorrows'));
    }

    //admin view - user borrowed books history    
    public function history(Request $request)
    {
        $search = $request->input('search');

        $history = Borrow::with(['user', 'book'])
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('student_id', 'like', "%{$search}%");
                })->orWhereHas('book', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('borrows.history', compact('history', 'search'));
    }

    public function userHistory(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');

        $borrows = Borrow::where('user_id', $user->id)
            ->whereHas('book', function ($query) use ($search) {
                if ($search) {
                    $query->where('title', 'like', '%' . $search . '%');
                }
            })
            ->with('book')
            ->orderByDesc('borrowed_at')
            ->get();

        return view('borrows.user-history', compact('borrows'));
    }

}
