<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><?php echo e(__('Dashboard')); ?></div>

                <div class="card-body">
                    <?php if(session('status')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(auth()->user()->role === 'admin'): ?>
                        <h3>Admin Dashboard</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <?php if(auth()->guard()->check()): ?>
                                        <?php if(auth()->user()->role === 'admin'): ?>
                                            <a href="<?php echo e(route('books.create')); ?>" class="btn btn-outline-success">Add New Book</a>
                                            <a href="<?php echo e(route('books.create')); ?>#existing-books" class="btn btn-outline-success">Manage Books</a>
                                            <a href="<?php echo e(route('borrows.history')); ?>" class="btn btn-outline-success">Borrowed History</a>
                                            <a href="<?php echo e(route('users')); ?>" class="btn btn-outline-success">User Lists</a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">📊 System Overview</h5>
                                        <p><strong>Total Books Registered:</strong> <?php echo e($totalBooks); ?></p>
                                        <p><strong>Total Books Borrowed:</strong> <?php echo e($totalBorrowedBooks); ?></p>
                                        <p><strong>Total Registered Users:</strong> <?php echo e($totalUsers); ?></p>
                                        <p><strong>Most Common Book Category:</strong> 
                                            <?php echo e($mostCategory ? $mostCategory->category . ' (' . $mostCategory->total . ' books)' : 'N/A'); ?>

                                        </p>
                                    </div>
                                </div>
                            </div>

                            <?php if($mostBorrowedBook && $mostBorrowedBook->book): ?>
                            <div class="col-md-6">
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <h4 class="card-title">📚 Most Borrowed Book</h4>
                                            <div class="col-md-3 text-end">
                                                <?php if($mostBorrowedBook->book->cover): ?>
                                                    <img src="<?php echo e(asset('storage/' . $mostBorrowedBook->book->cover)); ?>"
                                                        alt="Book Cover"
                                                        class="img-fluid rounded"
                                                        style="max-height: 200px;">
                                                <?php else: ?>
                                                    <div class="text-muted">No cover</div>
                                                <?php endif; ?>
                                            </div>


                                            <div class="col-md-9">
                                                <p><strong>Title:</strong> <?php echo e($mostBorrowedBook->book->title); ?></p>
                                                <p><strong>Author:</strong> <?php echo e($mostBorrowedBook->book->author); ?></p>
                                                <p><strong>Category:</strong> <?php echo e($mostBorrowedBook->book->category); ?></p>
                                                <p><strong>Year:</strong> <?php echo e($mostBorrowedBook->book->year); ?></p>
                                                <p><strong>Borrow Count:</strong> <?php echo e($mostBorrowedBook->borrow_count); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
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
                                <?php $__currentLoopData = $pendingBorrows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id="borrow-row-<?php echo e($borrow->id); ?>">
                                        <td><?php echo e($borrow->user->student_id); ?></td>
                                        <td><?php echo e($borrow->book->title); ?></td>
                                        <td><?php echo e($borrow->book->author); ?></td>
                                        <td><?php echo e($borrow->created_at->format('M d, Y h:i A')); ?></td>
                                        <td>
                                            <form style="display: inline;" class="approve-form" data-id="<?php echo e($borrow->id); ?>">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                            </form>
                                            <button class="btn btn-danger btn-sm reject-btn" data-id="<?php echo e($borrow->id); ?>">Reject</button>
                                            <button class="btn btn-warning btn-sm return-btn" 
                                                data-id="<?php echo e($borrow->book->id); ?>" 
                                                data-url="<?php echo e(route('books.return', $borrow->book->id)); ?>">
                                                Return
                                            </button>
                                        </td>
                                        <td>
                                            <?php if($borrow->status === 'approved'): ?>
                                                <span class="badge bg-success">Approved</span>
                                            <?php elseif($borrow->status === 'pending'): ?>
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            <?php elseif($borrow->status === 'returned'): ?>
                                                <span class="badge bg-info text-dark">Returned</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary"><?php echo e(ucfirst($borrow->status)); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                    <?php else: ?>
                        <h3>User Dashboard</h3>
                        <div class="mt-4">
                            <?php
                                $pendingBorrows = auth()->user()->borrows->where('status', 'pending');
                                $approvedBorrows = auth()->user()->borrows->where('status', 'approved');
                                $borrowedBooks = $approvedBorrows; 
                            ?>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card mb-4 shadow-sm">
                                        <div class="card-body">
                                            <?php if($pendingBorrows->count() > 0): ?>
                                                <h5 class="text-success">📥 Pending Requests</h5>
                                                <ul class="mb-0">
                                                    <?php $__currentLoopData = $pendingBorrows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li><?php echo e($borrow->book->title); ?> <span class="text-muted">(Pending Approval)</span></li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            <?php else: ?>
                                                <p class="text-muted">No pending borrow requests.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <?php $__currentLoopData = $newestBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $newestBook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-md-6">
                                                <div class="card mb-4 shadow">
                                                    <div class="card-body">
                                                        <div class="row g-3 align-items-center">
                                                            <h5 class="card-title"><b>Newest Book</b></h5>
                                                            <div class="col-md-4 text-center">
                                                                <?php if($newestBook->cover): ?>
                                                                    <img src="<?php echo e(asset('storage/' . $newestBook->cover)); ?>"
                                                                        alt="Book Cover"
                                                                        class="img-fluid rounded"
                                                                        style="max-height: 120px;">
                                                                <?php else: ?>
                                                                    <div class="text-muted">No cover</div>
                                                                <?php endif; ?>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <p class="card-text"><strong>Title:</strong> <?php echo e($newestBook->title); ?></p>
                                                                <p class="card-text"><strong>Author:</strong> <?php echo e($newestBook->author); ?></p>
                                                                <p class="card-text"><strong>Category:</strong> <?php echo e($newestBook->category); ?></p>
                                                                <p class="card-text"><?php echo e(Str::limit($newestBook->description, 100)); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <?php if(isset($mostBorrowedBooks) && $mostBorrowedBooks->count()): ?>
                                        <div class="card shadow-sm mb-4">
                                            <div class="card-header">
                                                <h5><b>Most Borrowed Books</b></h5>
                                            </div>
                                            <div class="card-body">
                                                <?php $__currentLoopData = $mostBorrowedBooks->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="mb-3 border-bottom d-flex">
                                                        <div>
                                                            <h6 class="mb-1"><?php echo e($book->title); ?></h6>
                                                            <p class="mb-1 text-muted">Author: <?php echo e($book->author); ?></p>
                                                            <p class="mb-0"><strong>Borrowed:</strong> <?php echo e($book->borrows_count); ?> times</p>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                <a href="/my-borrow-history" class="btn btn-success">My Borrow History</a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php if($borrowedBooks->count() > 0): ?>
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
                                        <?php $__currentLoopData = $borrowedBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                                            <tr id="borrowed-book-<?php echo e($book->book->id); ?>">
                                                <td><?php echo e($book->book->title); ?></td>
                                                <td><?php echo e($book->book->author); ?></td>
                                                <td><?php echo e($book->updated_at->format('M d, Y h:i A')); ?></td>
                                                <td>
                                                    <?php if($book->returned_at): ?>
                                                        <?php echo e(\Carbon\Carbon::parse($book->returned_at)->format('M d, Y h:i A')); ?>

                                                    <?php else: ?>
                                                        <span class="text-danger">Not Returned</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p>No approved borrowed books yet.</p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\acer user\Downloads\library-management\resources\views/home.blade.php ENDPATH**/ ?>