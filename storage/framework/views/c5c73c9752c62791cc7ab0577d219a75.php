<!DOCTYPE html>
<html>
<head>
    <title>Library Books</title>
</head>
<body>

    <h1>Library Books</h1>

    
    <?php if(auth()->guard()->check()): ?>
        <?php if(auth()->user()->role === 'admin'): ?>
            <a href="<?php echo e(route('books.create')); ?>" style="display: inline-block; padding: 10px; background: green; color: white; text-decoration: none; border-radius: 5px;">Add New Book</a>
        <?php endif; ?>
    <?php endif; ?>

    <ul>
        <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <strong><?php echo e($book->title); ?></strong> by <?php echo e($book->author); ?> (<?php echo e($book->year); ?>)  
                <br> 📚 Available Copies: <strong><?php echo e($book->quantity); ?></strong>
                
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->role === 'user'): ?>
                        <?php
                            $borrowed = auth()->user()->borrows
                                        ? auth()->user()->borrows->where('book_id', $book->id)->where('returned_at', null)->first()
                                        : null;
                        ?>

                        <?php if(!$borrowed && $book->quantity > 0): ?>
                            
                            <form action="<?php echo e(url('/books/'.$book->id.'/borrow')); ?>" method="POST" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <button type="submit" style="background: blue; color: white; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;">
                                    Borrow
                                </button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>

            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    <hr>

    
    <button onclick="window.location.href='<?php echo e(url('/home')); ?>'" style="padding: 10px; background: gray; color: white; border: none; border-radius: 5px; cursor: pointer;">
        Back to Home
    </button>

</body>
</html>
<?php /**PATH C:\Users\acer user\library-management\resources\views/books/index.blade.php ENDPATH**/ ?>