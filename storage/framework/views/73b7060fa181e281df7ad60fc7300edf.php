<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-success">Library Books</h1>
         <?php if(auth()->guard()->check()): ?>
            <?php if(auth()->user()->role === 'admin'): ?>
                <a href="<?php echo e(route('books.create')); ?>" class="btn btn-outline-success">➕Add New Book</a>
            <?php endif; ?>
        <?php endif; ?>                                   
    </div>

    <div class="row">
        <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row g-3 align-items-center">
                            <h5 class="card-title"> <?php echo e($book->title); ?></h5>
                            <div class="col-md-3 text-center">
                                <?php if($book->cover): ?>
                                    <img src="<?php echo e(asset('storage/' . $book->cover)); ?>" alt="Book Cover" width="80">
                                <?php else: ?>
                                    <div class="text-muted">No cover</div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-9">
                                <p class="card-text"> ✍ <strong>Author:</strong> <?php echo e($book->author); ?></p>
                                <p class="card-text"> 📚 <strong>Category:</strong> <?php echo e($book->category); ?></p>
                                <p class="card-text"> 📅 <strong>Year:</strong> <?php echo e($book->year); ?></p>
                                <p class="card-text"> 📦 <strong>Available Copies:</strong> 
                                    <span class="badge bg-success"><?php echo e($book->quantity); ?></span>
                                </p>
                            </div>
                            <?php if(auth()->guard()->check()): ?>
                                <?php if(auth()->user()->role === 'user'): ?>
                                    <?php
                                        $borrowed = auth()->user()->borrows
                                            ? auth()->user()->borrows->where('book_id', $book->id)->where('returned_at', null)->first()
                                            : null;
                                    ?>
                                    <?php if(!$borrowed && $book->quantity > 0): ?>
                                        <form action="<?php echo e(url('/books/'.$book->id.'/borrow')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-primary w-100 mt-2">📖 Borrow</button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <hr>


</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\GE Folder\library-management\resources\views/books/index.blade.php ENDPATH**/ ?>