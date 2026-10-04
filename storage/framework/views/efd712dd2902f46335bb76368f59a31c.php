<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?></title>

    <link rel="shortcut icon" href="<?php echo e(asset('public/assets/installation')); ?>/assets/img/favicon.svg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo e(asset('public/assets/installation')); ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/installation')); ?>/assets/css/style.css">
</head>

<body>
<section style="background-image: url('<?php echo e(asset('public/assets/installation')); ?>/assets/img/page-bg.png')"
         class="w-100 min-vh-100 bg-img position-relative py-5">

    <div class="logo">
        <img src="<?php echo e(asset('public/assets/installation')); ?>/assets/img/favicon.svg" alt="">
    </div>

    <div class="custom-container">
        
        <?php $__currentLoopData = session('toastr::messages', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $installerMessage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="alert alert-<?php echo e(($installerMessage['type'] ?? 'info') === 'error' ? 'danger' : ($installerMessage['type'] ?? 'info')); ?> alert-dismissible fade show mt-3 mb-0" role="alert">
                <?php echo $installerMessage['message']; ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show mt-3 mb-0" role="alert">
                <?php echo session('error'); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mt-3 mb-0" role="alert">
                <?php echo session('success'); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        
        <?php if(isset($errors) && $errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show mt-3 mb-0" role="alert">
                <ul class="mb-0 ps-3">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $installerError): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($installerError); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?>

        <footer class="footer py-3 mt-4">
            <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 align-items-center">
                <div class="footer-logo">
                    <img src="<?php echo e(asset('public/assets/installation')); ?>/assets/img/logo.svg" alt="">
                </div>
                <p class="copyright-text mb-0">© <?php echo e(date("Y")); ?> | All Rights Reserved</p>
            </div>
        </footer>
    </div>
</section>
</body>

<script src="<?php echo e(asset('public/assets/installation')); ?>/assets/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo e(asset('public/assets/installation')); ?>/assets/js/script.js"></script>

</html>
<?php /**PATH /home/foodcol2/portal.foodcollections.com/resources/views/layouts/blank.blade.php ENDPATH**/ ?>