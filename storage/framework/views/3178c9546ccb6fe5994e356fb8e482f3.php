<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Profile</div>

                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" value="<?php echo e($user->firstname); ?>" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" value="<?php echo e($user->lastname); ?>" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Profile Photo</label>
                            <input type="file" name="profile_photo" class="form-control">
                            <?php if($user->profile_photo): ?>
                                <img src="<?php echo e(asset('storage/' . $user->profile_photo)); ?>" alt="Profile Photo" class="img-thumbnail mt-2" width="150">
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Student ID (Only applicable for PSU students)</label>
                            <input type="text" name="student_id" class="form-control" value="<?php echo e($user->student_id); ?>">
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" value="<?php echo e($user->address); ?>">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                        <a href="<?php echo e(url('/home')); ?>" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\GE Folder\library-management\resources\views/profile/edit.blade.php ENDPATH**/ ?>