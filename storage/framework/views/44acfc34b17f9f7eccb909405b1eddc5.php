<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo e(translate('messages.error')); ?> 404 | <?php echo e(\App\CentralLogics\Helpers::get_business_settings('business_name', false)??'6amMart'); ?></title>

    <link rel="shortcut icon" href="favicon.ico">

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&amp;display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin')); ?>/css/vendor.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin')); ?>/vendor/icon-set/style.css">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/button-icons.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/theme.minc619.css?v=1.0')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/buttons.css')); ?>">
</head>

<body>

<div class="container">
    <div class="footer-height-offset d-flex justify-content-center align-items-center flex-column">
        <div class="row align-items-sm-center w-100">
            <div class="col-sm-6">
                <div class="text-center text-sm-right mr-sm-4 mb-5 mb-sm-0">
                    <img class="w-60 w-sm-100 mx-auto mw-15rem"
                         src="<?php echo e(asset('public/assets/admin')); ?>/svg/illustrations/think.svg" alt="Image Description">
                </div>
            </div>

            <div class="col-sm-6 col-md-4 text-center text-sm-left">
                <h1 class="display-1 mb-0">404</h1>
                <p class="lead"><?php echo e(translate('messages.Sorry, the page you are looking for could not be found.')); ?></p>
                
                <?php
                    $dashboardRoute = auth('vendor')->check() ? 'vendor.dashboard' : 'admin.dashboard';
                ?>
                <a class="btn btn-primary" href="<?php echo e(app('router')->has($dashboardRoute) ? route($dashboardRoute) : url('/')); ?>"><i class="tio-dashboard-outlined"></i> <?php echo e(translate('Dashboard')); ?></a>
            </div>
        </div>
    </div>
</div>

<div class="footer text-center">
    <ul class="list-inline list-separator">
        <?php if(app('router')->has('contact-us')): ?>
            <li class="list-inline-item">
                <a class="list-separator-link" target="_blank" href="<?php echo e(route('contact-us')); ?>"><?php echo e(\App\CentralLogics\Helpers::get_business_settings('business_name', false)??'6amMart'); ?> <?php echo e(translate('messages.Support')); ?></a>
            </li>
        <?php endif; ?>
    </ul>
</div>


<script src="<?php echo e(asset('public/assets/admin')); ?>/js/theme.min.js"></script>
</body>

</html>
<?php /**PATH /home/foodcol2/portal.foodcollections.com/resources/views/errors/404.blade.php ENDPATH**/ ?>