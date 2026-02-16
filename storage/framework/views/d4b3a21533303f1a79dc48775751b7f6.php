<?php $__env->startSection('content'); ?>
<div class="container">
    <h2 class="mb-4">Borrowed History</h2>

    <form method="GET" action="<?php echo e(route('borrows.history')); ?>" class="mb-3 d-flex" role="search">
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control me-2" placeholder="Search by Student ID or Book Title">
        <button type="submit" class="btn btn-success">Search</button>
    </form>

    <?php if($history->count() > 0): ?>
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
                <?php $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($record->user->student_id ?? 'N/A'); ?></td>
                        <td><?php echo e($record->book->title ?? 'N/A'); ?></td>
                        <td><?php echo e($record->created_at->format('M d, Y h:i A')); ?></td>
                        <td>
                            <?php echo e($record->returned_at ? \Carbon\Carbon::parse($record->returned_at)->format('M d, Y h:i A') : 'Not Returned'); ?>

                        </td>
                        <td>
                            <?php if($record->isOverdue): ?>
                                <span class="text-danger fw-bold">Yes - Consequences Apply</span>
                            <?php else: ?>
                                <span class="text-success">No</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($record->status === 'approved'): ?>
                                <span class="badge bg-success">Approved</span>
                            <?php elseif($record->status === 'pending'): ?>
                                <span class="badge bg-warning text-dark">Pending</span>
                            <?php elseif($record->status === 'returned'): ?>
                                <span class="badge bg-info text-dark">Returned</span>
                            <?php else: ?>
                                <span class="badge bg-secondary"><?php echo e(ucfirst($record->status)); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No borrow history found.</p>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\GE Folder\library-management\resources\views/borrows/history.blade.php ENDPATH**/ ?>