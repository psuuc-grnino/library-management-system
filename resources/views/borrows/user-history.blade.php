@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Borrow History</h1>

    <form action="{{ route('borrows.userHistory') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by book title..." value="{{ request('search') }}">
            <button class="btn btn-success" type="submit">Search</button>
        </div>
    </form>


    @if($borrows->isEmpty())
        <p>You have no borrow history yet.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Book</th>
                    <th>Borrowed At</th>
                    <th>Returned At</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($borrows as $borrow)
                <tr>
                    <td>{{ $borrow->book->title }}</td>
                    <td>{{ $borrow->borrowed_at->format('M d, Y h:i A') }}</td>
                    <td>
                        @if($borrow->returned_at)
                            {{ $borrow->returned_at->format('M d, Y h:i A')}}
                        @else
                            <span class="text-warning">Not returned</span>
                        @endif
                    </td>
                    <td>{{ ucfirst($borrow->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
