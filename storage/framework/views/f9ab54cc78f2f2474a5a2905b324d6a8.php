<!DOCTYPE html>
<html>
<head>
    <title>Add New Book</title>
</head>
<body>
    <h1>Add a New Book</h1>

    
    <?php if($errors->any()): ?>
        <div style="color: red;">
            <strong>Error!</strong> Please check your input.<br>
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    
    <form action="<?php echo e(route('books.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <label for="title">Title:</label>
        <input type="text" name="title" required>

        <label for="author">Author:</label>
        <input type="text" name="author" required>

        <label for="year">Year:</label>
        <input type="number" name="year" required>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" min="1" required>

        <button type="submit">Add Book</button>
    </form>

    <hr>

    <h2>Existing Books</h2>

    <ul>
        <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <strong><?php echo e($book->title); ?></strong> by <?php echo e($book->author); ?> (<?php echo e($book->year); ?>) - <strong>Qty: <?php echo e($book->quantity); ?></strong>
                
                
                <a href="<?php echo e(route('books.edit', $book->id)); ?>">Edit</a>

                
                <form action="<?php echo e(route('books.destroy', $book->id)); ?>" method="POST" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this book?');">Delete</button>
                </form>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    <hr>

    
    <button onclick="window.location.href='<?php echo e(route('books.index')); ?>'">Back to Library</button>
    <button onclick="window.location.href='<?php echo e(route('home')); ?>'">Back to Admin Dashboard</button>
</body>
</html>
<?php /**PATH C:\Users\acer user\library-management\resources\views/books/create.blade.php ENDPATH**/ ?>