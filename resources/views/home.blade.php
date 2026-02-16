@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(auth()->user()->role === 'admin')
                        <h3>Admin Dashboard</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    @auth
                                        @if(auth()->user()->role === 'admin')
                                            <a href="{{ route('books.create') }}" class="btn btn-outline-success">Add New Book</a>
                                            <a href="{{ route('books.create') }}#existing-books" class="btn btn-outline-success">Manage Books</a>
                                            <a href="{{ route('borrows.history') }}" class="btn btn-outline-success">Borrowed History</a>
                                            <a href="{{ route('users') }}" class="btn btn-outline-success">User Lists</a>
                                        @endif
                                    @endauth
                                </div>
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">📊 System Overview</h5>
                                        <p><strong>Total Books Registered:</strong> {{ $totalBooks }}</p>
                                        <p><strong>Total Books Borrowed:</strong> {{ $totalBorrowedBooks }}</p>
                                        <p><strong>Total Registered Users:</strong> {{ $totalUsers }}</p>
                                        <p><strong>Most Common Book Category:</strong> 
                                            {{ $mostCategory ? $mostCategory->category . ' (' . $mostCategory->total . ' books)' : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @if ($mostBorrowedBook && $mostBorrowedBook->book)
                            <div class="col-md-6">
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <h4 class="card-title">📚 Most Borrowed Book</h4>
                                            <div class="col-md-3 text-end">
                                                @if ($mostBorrowedBook->book->cover)
                                                    <img src="{{ asset('storage/' . $mostBorrowedBook->book->cover) }}"
                                                        alt="Book Cover"
                                                        class="img-fluid rounded"
                                                        style="max-height: 200px;">
                                                @else
                                                    <div class="text-muted">No cover</div>
                                                @endif
                                            </div>


                                            <div class="col-md-9">
                                                <p><strong>Title:</strong> {{ $mostBorrowedBook->book->title }}</p>
                                                <p><strong>Author:</strong> {{ $mostBorrowedBook->book->author }}</p>
                                                <p><strong>Category:</strong> {{ $mostBorrowedBook->book->category }}</p>
                                                <p><strong>Year:</strong> {{ $mostBorrowedBook->book->year }}</p>
                                                <p><strong>Borrow Count:</strong> {{ $mostBorrowedBook->borrow_count }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <h4 class="mt-4"><b>Pending Borrow Requests</b></h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Book Title</th>
                                    <th>Author</th>
                                    <th>Requested Date</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingBorrows as $borrow)
                                    <tr id="borrow-row-{{ $borrow->id }}">
                                        <td>{{ $borrow->user->student_id }}</td>
                                        <td>{{ $borrow->book->title }}</td>
                                        <td>{{ $borrow->book->author }}</td>
                                        <td>{{ $borrow->created_at->format('M d, Y h:i A') }}</td>
                                        <td>
                                            <form style="display: inline;" class="approve-form" data-id="{{ $borrow->id }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                            </form>
                                            <button class="btn btn-danger btn-sm reject-btn" data-id="{{ $borrow->id }}">Reject</button>
                                            <button class="btn btn-warning btn-sm return-btn" 
                                                data-id="{{ $borrow->book->id }}" 
                                                data-url="{{ route('books.return', $borrow->book->id) }}">
                                                Return
                                            </button>
                                        </td>
                                        <td>
                                            @if ($borrow->status === 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif ($borrow->status === 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif ($borrow->status === 'returned')
                                                <span class="badge bg-info text-dark">Returned</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($borrow->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    @else
                        <h3>User Dashboard</h3>
                        <div class="mt-4">
                            @php
                                $pendingBorrows = auth()->user()->borrows->where('status', 'pending');
                                $approvedBorrows = auth()->user()->borrows->where('status', 'approved');
                                $borrowedBooks = $approvedBorrows; 
                            @endphp
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card mb-4 shadow-sm">
                                        <div class="card-body">
                                            @if($pendingBorrows->count() > 0)
                                                <h5 class="text-success">📥 Pending Requests</h5>
                                                <ul class="mb-0">
                                                    @foreach($pendingBorrows as $borrow)
                                                        <li>{{ $borrow->book->title }} <span class="text-muted">(Pending Approval)</span></li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p class="text-muted">No pending borrow requests.</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        @foreach($newestBooks as $newestBook)
                                            <div class="col-md-6">
                                                <div class="card mb-4 shadow">
                                                    <div class="card-body">
                                                        <div class="row g-3 align-items-center">
                                                            <h5 class="card-title"><b>Newest Book</b></h5>
                                                            <div class="col-md-4 text-center">
                                                                @if ($newestBook->cover)
                                                                    <img src="{{ asset('storage/' . $newestBook->cover) }}"
                                                                        alt="Book Cover"
                                                                        class="img-fluid rounded"
                                                                        style="max-height: 120px;">
                                                                @else
                                                                    <div class="text-muted">No cover</div>
                                                                @endif
                                                            </div>

                                                            <div class="col-md-8">
                                                                <p class="card-text"><strong>Title:</strong> {{ $newestBook->title }}</p>
                                                                <p class="card-text"><strong>Author:</strong> {{ $newestBook->author }}</p>
                                                                <p class="card-text"><strong>Category:</strong> {{ $newestBook->category }}</p>
                                                                <p class="card-text">{{ Str::limit($newestBook->description, 100) }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    @if(isset($mostBorrowedBooks) && $mostBorrowedBooks->count())
                                        <div class="card shadow-sm mb-4">
                                            <div class="card-header">
                                                <h5><b>Most Borrowed Books</b></h5>
                                            </div>
                                            <div class="card-body">
                                                @foreach($mostBorrowedBooks->take(3) as $book)
                                                    <div class="mb-3 border-bottom d-flex">
                                                        <div>
                                                            <h6 class="mb-1">{{ $book->title }}</h6>
                                                            <p class="mb-1 text-muted">Author: {{ $book->author }}</p>
                                                            <p class="mb-0"><strong>Borrowed:</strong> {{ $book->borrows_count }} times</p>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                <a href="/my-borrow-history" class="btn btn-success">My Borrow History</a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if($borrowedBooks->count() > 0)
                                <h5><b>Approved Books</b></h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Approved Date</th>
                                            <th>Returned Date</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($borrowedBooks as $book)  
                                            <tr id="borrowed-book-{{ $book->book->id }}">
                                                <td>{{ $book->book->title }}</td>
                                                <td>{{ $book->book->author }}</td>
                                                <td>{{ $book->updated_at->format('M d, Y h:i A')}}</td>
                                                <td>
                                                    @if ($book->returned_at)
                                                        {{ \Carbon\Carbon::parse($book->returned_at)->format('M d, Y h:i A') }}
                                                    @else
                                                        <span class="text-danger">Not Returned</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No approved borrowed books yet.</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.return-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            let bookId = this.getAttribute('data-id');
            let apiUrl = this.getAttribute('data-url');
            let row = document.getElementById('borrowed-book-' + bookId) || document.getElementById('borrow-row-' + bookId);
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            Swal.fire({
                title: "Return Book?",
                text: "Are you sure you want to return this book?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ffc107",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, Return it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(apiUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                        },
                    }).then(response => response.json())
                    .then(data => {
                        if (data.status === "returned") {
                            Swal.fire("Returned!", "The book has been successfully returned.", "success");
                            setTimeout(() => { if (row) row.remove(); }, 2000);
                        } else {
                            Swal.fire("Error", data.error || "Something went wrong!", "error");
                        }
                    }).catch(error => {
                        Swal.fire("Error", "An error occurred while returning the book.", "error");
                    });
                }
            });
        });
    });

    // Reject Button
    document.querySelectorAll('.reject-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            let borrowId = this.getAttribute('data-id');
            let row = document.getElementById('borrow-row-' + borrowId);
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let apiUrl = `/borrows/${borrowId}/reject`;

            Swal.fire({
                title: "Reject Request?",
                text: "Are you sure you want to reject this borrow request?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, Reject it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(apiUrl, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                        },
                    }).then(response => response.json())
                    .then(data => {
                        if (data.status === "rejected") {
                            Swal.fire("Rejected!", "The borrow request has been rejected.", "success");
                            setTimeout(() => { if (row) row.remove(); }, 1500);
                        } else {
                            Swal.fire("Error", data.error || "Something went wrong!", "error");
                        }
                    }).catch(error => {
                        Swal.fire("Error", "An error occurred while rejecting the request.", "error");
                    });
                }
            });
        });
    });

    // Approve Form
    document.querySelectorAll('.approve-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            let borrowId = this.getAttribute('data-id');
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let apiUrl = `/borrows/${borrowId}/approve`;

            Swal.fire({
                title: "Approve Borrow Request?",
                text: "Are you sure you want to approve this borrow request?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, Approve it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(apiUrl, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "approved") {
                            Swal.fire("Approved!", "The borrow request has been approved.", "success");

                            // Disable the reject button
                            const rejectButton = document.querySelector(`.reject-btn[data-id="${borrowId}"]`);
                            if (rejectButton) {
                                rejectButton.setAttribute('disabled', 'true');
                                rejectButton.classList.remove('btn-danger');
                                rejectButton.classList.add('btn-secondary');
                                rejectButton.innerText = "Reject Disabled";
                            }

                        } else {
                            Swal.fire("Error", data.error || "Something went wrong!", "error");
                        }
                    })
                    .catch(() => {
                        Swal.fire("Error", "An error occurred while approving the request.", "error");
                    });
                }
            });
        });
    });
});
</script>

</script>
@endsection
