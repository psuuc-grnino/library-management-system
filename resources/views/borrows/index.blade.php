@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">My Borrowed Books</h1>
        <a href="/" class="btn btn-outline-secondary">← Back to Books</a>
    </div>

    @if ($borrows->isEmpty())
        <div class="alert alert-info text-center">
            <h4>No borrowed books found.</h4>
            <p>Browse the collection and borrow your first book!</p>
            <a href="/" class="btn btn-primary">Explore Books</a>
        </div>
    @else
        <div class="row">
            @foreach ($borrows as $borrow)
                @php
                    $isOverdue = !$borrow->returned_at && $borrow->borrowed_at->diffInDays(now()) > 3;
                @endphp

                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm mb-4 border 
                        {{ $isOverdue ? 'border-danger' : 'border-success' }}">
                        <div class="card-body">
                            <h5 class="card-title text-dark">{{ $borrow->book->title }}</h5>
                            <p class="card-text text-muted">
                                <strong>Author:</strong> {{ $borrow->book->author }} <br>
                                <strong>Borrowed on:</strong> {{ $borrow->borrowed_at->format('F j, Y') }}
                            </p>

                            @if ($isOverdue)
                                <div class="alert alert-warning p-2">
                                    <strong>⚠️ Overdue:</strong> Please return this book. Borrowing exceeds 3 days.
                                </div>
                            @endif

                            @if (!$borrow->returned_at)
                                <form action="/books/{{ $borrow->book->id }}/return" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100">Return Book</button>
                                </form>
                            @else
                                <p class="text-success">
                                    <strong>Returned on:</strong> {{ $borrow->returned_at->format('F j, Y') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
