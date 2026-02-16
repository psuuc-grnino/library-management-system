@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-success">Library Books</h1>
         @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('books.create') }}" class="btn btn-outline-success">➕Add New Book</a>
            @endif
        @endauth                                   
    </div>

    <div class="row">
        @foreach ($books as $book)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row g-3 align-items-center">
                            <h5 class="card-title"> {{ $book->title }}</h5>
                            <div class="col-md-3 text-center">
                                @if ($book->cover)
                                    <img src="{{ asset('storage/' . $book->cover) }}" alt="Book Cover" width="80">
                                @else
                                    <div class="text-muted">No cover</div>
                                @endif
                            </div>

                            <div class="col-md-9">
                                <p class="card-text"> ✍ <strong>Author:</strong> {{ $book->author }}</p>
                                <p class="card-text"> 📚 <strong>Category:</strong> {{ $book->category }}</p>
                                <p class="card-text"> 📅 <strong>Year:</strong> {{ $book->year }}</p>
                                <p class="card-text"> 📦 <strong>Available Copies:</strong> 
                                    <span class="badge bg-success">{{ $book->quantity }}</span>
                                </p>
                            </div>
                            @auth
                                @if(auth()->user()->role === 'user')
                                    @php
                                        $borrowed = auth()->user()->borrows
                                            ? auth()->user()->borrows->where('book_id', $book->id)->where('returned_at', null)->first()
                                            : null;
                                    @endphp
                                    @if (!$borrowed && $book->quantity > 0)
                                        <form action="{{ url('/books/'.$book->id.'/borrow') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary w-100 mt-2">📖 Borrow</button>
                                        </form>
                                    @endif
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <hr>


</div>
@endsection
