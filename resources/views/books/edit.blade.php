@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-warning">✏ Edit Book</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Error!</strong> Please check your input:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm p-4">
        <form method="POST" action="{{ route('books.update', $book->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Book Title:</label>
                <input type="text" name="title" class="form-control" value="{{ $book->title }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Author:</label>
                <input type="text" name="author" class="form-control" value="{{ $book->author }}" required>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" name="category" class="form-control" value="{{ old('category', $book->category ?? '') }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Publication Year:</label>
                <input type="number" name="year" class="form-control" value="{{ $book->year }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Quantity:</label>
                <input type="number" name="quantity" class="form-control" value="{{ $book->quantity }}" required>
            </div>

            <div class="mb-3">
                <label for="cover" class="form-label">Book Cover:</label>
                @if ($book->cover)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $book->cover) }}" alt="Book Cover" style="max-height: 120px;">
                    </div>
                @endif

                <input type="file" name="cover" class="form-control" accept="image/*">
                <small class="text-muted">Leave empty to keep the current cover.</small>
            </div>

            <button type="submit" class="btn btn-warning w-100">✔ Update Book</button>
        </form>
    </div>

    <hr>


</div>
@endsection
