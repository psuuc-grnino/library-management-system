<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">📚 Add a New Book</h1>
        <a href="<?php echo e(route('books.index')); ?>" class="btn btn-outline-secondary">← Back to Library</a>
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
        <form action="<?php echo e(route('books.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label for="title" class="form-label">Book Title:</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="author" class="form-label">Author:</label>
                <input type="text" name="author" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" name="category" class="form-control" value="<?php echo e(old('category', $book->category ?? '')); ?>" required>
            </div>

            <div class="mb-3">
                <label for="year" class="form-label">Publication Year:</label>
                <input type="number" name="year" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity:</label>
                <input type="number" name="quantity" class="form-control" min="1" required>
            </div>

            <div class="mb-3">
                <label for="cover" class="form-label">Book Cover:</label>
                <input type="file" name="cover" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary w-100">➕ Add Book</button>
        </form>
    </div>
<br>
    <hr>

    <h2 id="existing-books" class="mt-4">📖 Manage Books</h2>
    <?php if($books->isEmpty()): ?>
        <p class="text-muted">No books available. Start adding books now!</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Year</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($book->title); ?></td>
                            <td><?php echo e($book->author); ?></td>
                            <td><?php echo e($book->category); ?></td>
                            <td><?php echo e($book->year); ?></td>
                            <td><?php echo e($book->quantity); ?></td>
                            <td>
                                <a href="<?php echo e(route('books.edit', $book->id)); ?>" class="btn btn-warning btn-sm">✏ Edit</a>
                                <form action="<?php echo e(route('books.destroy', $book->id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">🗑 Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <hr>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\acer user\Downloads\library-management\resources\views/books/create.blade.php ENDPATH**/ ?>