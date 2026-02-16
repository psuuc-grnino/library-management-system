<?php $__env->startSection('content'); ?>
<div class="container">
    <h2 class="mb-4">User Lists</h2>

    <form method="GET" action="<?php echo e(route('users.index')); ?>" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control" placeholder="Search by name, student ID, or email">
            <button type="submit" class="btn btn-success">Search</button>
        </div>
    </form>

    <?php if($users->count()): ?>
        <table class="table table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Profile Photo</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Contact Number</th>
                    <th>Status</th>      
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <?php if($user->profile_photo): ?>
                                <img src="<?php echo e(asset('storage/' . $user->profile_photo)); ?>" alt="Profile" width="60" height="60" class="rounded-circle">
                            <?php else: ?>
                                <img src="<?php echo e(asset('default-profile.png')); ?>" alt="Default" width="60" height="60" class="rounded-circle">
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($user->student_id ?? 'N/A'); ?></td>
                        <td><?php echo e(($user->firstname ?? '') . ' ' . ($user->lastname ?? '')); ?></td>
                        <td><?php echo e($user->email ?? 'N/A'); ?></td>
                        <td><?php echo e($user->address ?? 'N/A'); ?></td>
                        <td><?php echo e($user->contact_number ?? 'N/A'); ?></td>    
                        <td><?php echo e($user->psu_status ?? 'N/A'); ?></td>   
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No users found.</p>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\GE Folder\library-management\resources\views/users.blade.php ENDPATH**/ ?>