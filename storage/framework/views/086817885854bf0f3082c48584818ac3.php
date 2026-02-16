<!DOCTYPE html>
<html>
<head>
    <title>My Borrowed Books</title>
</head>
<body>
    <h1>My Borrowed Books</h1>
    <a href="/">Back to Books</a>
    <ul>
        <?php $__currentLoopData = $borrows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <?php echo e($borrow->book->title); ?> by <?php echo e($borrow->book->author); ?> (Borrowed on: <?php echo e($borrow->borrowed_at); ?>)
                <?php if(!$borrow->returned_at): ?>
                    <form action="/books/<?php echo e($borrow->book->id); ?>/return" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit">Return</button>
                    </form>
                <?php else: ?>
                    <span>Returned on: <?php echo e($borrow->returned_at); ?></span>
                <?php endif; ?>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</body>
</html>
<?php /**PATH C:\Users\acer user\library-management\resources\views/borrows/index.blade.php ENDPATH**/ ?>