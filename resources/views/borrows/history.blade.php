@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Borrowed History</h2>

    <form method="GET" action="{{ route('borrows.history') }}" class="mb-3 d-flex" role="search">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Search by Student ID or Book Title">
        <button type="submit" class="btn btn-success">Search</button>
    </form>

    @if($history->count() > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Book Title</th>
                    <th>Borrowed Time</th>
                    <th>Returned Time</th>
                    <th>Overdue</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($history as $record)
                    <tr>
                        <td>{{ $record->user->student_id ?? 'N/A' }}</td>
                        <td>{{ $record->book->title ?? 'N/A' }}</td>
                        <td>{{ $record->created_at->format('M d, Y h:i A') }}</td>
                        <td>
                            {{ $record->returned_at ? \Carbon\Carbon::parse($record->returned_at)->format('M d, Y h:i A') : 'Not Returned' }}
                        </td>
                        <td>
                            @if($record->isOverdue)
                                <span class="text-danger fw-bold">Yes - Consequences Apply</span>
                            @else
                                <span class="text-success">No</span>
                            @endif
                        </td>
                        <td>
                            @if ($record->status === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif ($record->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif ($record->status === 'returned')
                                <span class="badge bg-info text-dark">Returned</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($record->status) }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No borrow history found.</p>
    @endif
</div>
@endsection
