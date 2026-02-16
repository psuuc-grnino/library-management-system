<?php $__env->startSection('content'); ?>
<div class="container col-xxl-6 px-4">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">

        <div class="col-lg-6">
            <div class="card shadow-lg p-4">
                 <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3 text-center">Welcome Back!</h1>
            <p class="lead text-center">Log in to continue managing your books.</p>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="mb-3">
                            <label for="email" class="form-label"><?php echo e(__('Email Address')); ?></label>
                            <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autofocus>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label"><?php echo e(__('Password')); ?></label>
                            <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="remember"><?php echo e(__('Remember Me')); ?></label>
                        </div>

                        <button type="submit" class="btn btn-success w-100 btn-lg"><?php echo e(__('Login')); ?></button>

                        <div class="text-center mt-3">
                            <?php if(Route::has('password.request')): ?>
                                <a class="text-decoration-none" href="<?php echo e(route('password.request')); ?>"><?php echo e(__('Forgot Your Password?')); ?></a>
                            <?php endif; ?>
                        </div>

                        
                        <div class="text-center mt-3">
                            <p>Don't have yet an account? <a href="<?php echo e(route('register')); ?>" class="text-decoration-none">Sign Up</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-10 col-sm-8 col-lg-6">
            <img src="<?php echo e(asset('images/login-image.jpg')); ?>" class="d-block mx-lg-auto img-fluid rounded-3 shadow" alt="Login Image" width="700" height="300" loading="lazy">
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\acer user\Downloads\library-management\resources\views/auth/login.blade.php ENDPATH**/ ?>