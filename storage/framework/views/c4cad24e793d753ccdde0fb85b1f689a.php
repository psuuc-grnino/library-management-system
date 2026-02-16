<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
</head>
<body>
    <h1>Edit Book</h1>
    <form method="POST" action="/books/<?php echo e($book->id); ?>">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        
        <label>Title:</label>
        <input type="text" name="title" value="<?php echo e($book->title); ?>" required><br>

        <label>Author:</label>
        <input type="text" name="author" value="<?php echo e($book->author); ?>" required><br>

        <label>Year:</label>
        <input type="number" name="year" value="<?php echo e($book->year); ?>" required><br>

        <label>Quantity:</label>
        <input type="number" name="quantity" value="<?php echo e($book->quantity); ?>" required><br>

        <button type="submit">Update Book</button>
    </form>
</body>
</html>
<?php /**PATH C:\Users\acer user\library-management\resources\views/books/edit.blade.php ENDPATH**/ ?>