<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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
                        <a href="<?php echo e(route('books.create')); ?>" class="btn btn-primary">Add New Book</a>
                        
                        <h4 class="mt-4">Recently Added Books</h4>
                        <ul>
                            <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li><?php echo e($book->title); ?> by <?php echo e($book->author); ?> (<?php echo e($book->year); ?>)</li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <li>No books added yet.</li>
                            <?php endif; ?>
                        </ul>
                    
                    <?php else: ?>
                        <h3>User Dashboard</h3>
                        
                        
                        <a href="<?php echo e(route('books.index')); ?>" class="btn btn-success mb-3">Explore Books</a>

                        
                        <div class="mt-4">
                            <h4>Borrowed Books</h4>
                            <?php
                                // Filter only books that are not returned
                                $activeBorrows = $user->borrows->whereNull('returned_at');
                            ?>

                            <?php if($activeBorrows->count() > 0): ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $activeBorrows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($borrow->book->title); ?></td>
                                                <td><?php echo e($borrow->book->author); ?></td>
                                                <td>
                                                    <form action="<?php echo e(route('books.return', $borrow->book->id)); ?>" method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="btn btn-warning btn-sm">Return</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p>You haven't borrowed any books yet.</p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\acer user\library-management\resources\views/home.blade.php ENDPATH**/ ?>