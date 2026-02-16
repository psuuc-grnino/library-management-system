<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>My Borrow History</h1>

    <form action="<?php echo e(route('borrows.userHistory')); ?>" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by book title..." value="<?php echo e(request('search')); ?>">
            <button class="btn btn-success" type="submit">Search</button>
        </div>
    </form>


    <?php if($borrows->isEmpty()): ?>
        <p>You have no borrow history yet.</p>
    <?php else: ?>
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
                <?php $__currentLoopData = $borrows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($borrow->book->title); ?></td>
                    <td><?php echo e($borrow->borrowed_at->format('M d, Y h:i A')); ?></td>
                    <td>
                        <?php if($borrow->returned_at): ?>
                            <?php echo e($borrow->returned_at->format('M d, Y h:i A')); ?>

                        <?php else: ?>
                            <span class="text-warning">Not returned</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e(ucfirst($borrow->status)); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\GE Folder\library-management\resources\views/borrows/user-history.blade.php ENDPATH**/ ?>