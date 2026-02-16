<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-warning">✏ Edit Book</h1>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <strong>Error!</strong> Please check your input:
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm p-4">
        <form method="POST" action="<?php echo e(route('books.update', $book->id)); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="mb-3">
                <label class="form-label">Book Title:</label>
                <input type="text" name="title" class="form-control" value="<?php echo e($book->title); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Author:</label>
                <input type="text" name="author" class="form-control" value="<?php echo e($book->author); ?>" required>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" name="category" class="form-control" value="<?php echo e(old('category', $book->category ?? '')); ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Publication Year:</label>
                <input type="number" name="year" class="form-control" value="<?php echo e($book->year); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Quantity:</label>
                <input type="number" name="quantity" class="form-control" value="<?php echo e($book->quantity); ?>" required>
            </div>

            <div class="mb-3">
                <label for="cover" class="form-label">Book Cover:</label>
                <?php if($book->cover): ?>
                    <div class="mb-2">
                        <img src="<?php echo e(asset('storage/' . $book->cover)); ?>" alt="Book Cover" style="max-height: 120px;">
                    </div>
                <?php endif; ?>

                <input type="file" name="cover" class="form-control" accept="image/*">
                <small class="text-muted">Leave empty to keep the current cover.</small>
            </div>

            <button type="submit" class="btn btn-warning w-100">✔ Update Book</button>
        </form>
    </div>

    <hr>


</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\GE Folder\library-management\resources\views/books/edit.blade.php ENDPATH**/ ?>