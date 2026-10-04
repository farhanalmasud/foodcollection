<div class="footer">
    <div class="d-flex justify-content-between align-items-baseline flex-wrap gap-2">
        <div class="text-md-start">
            <p class="font-size-sm mb-0">
                &copy; <?php echo e(\App\CentralLogics\Helpers::get_business_settings('business_name')); ?>. <span
                    class="d-none d-sm-inline-block"><?php echo e(\App\CentralLogics\Helpers::get_business_settings('footer_text')); ?></span>
            </p>
        </div>
        <div class="">
            <div class="d-flex justify-content-end">
                <ul class="list-inline list-separator list-separator-before text-left">
                    <?php if(\App\CentralLogics\Helpers::module_permission_check('settings')): ?>
                    <li class="list-inline-item">
                        <a class="list-separator-link" href="<?php echo e(route('admin.business-settings.business-setup')); ?>"><?php echo e(translate('Business setup')); ?></a>
                    </li>
                    <?php endif; ?>

                    <?php if(\App\CentralLogics\Helpers::module_permission_check('profile')): ?>
                    <li class="list-inline-item">
                        <a class="list-separator-link" href="<?php echo e(route('admin.settings')); ?>"><?php echo e(translate('messages.Profile')); ?></a>
                    </li>
                    <?php endif; ?>

                    <li class="list-inline-item">
                        <a class="list-separator-link" href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(translate('messages.home')); ?></a>
                    </li>
                    <li class="list-inline-item d-inline-block">
                        <label class="badge badge-soft-primary m-0">
                            <?php echo e(translate('messages.Software version')); ?> : <?php echo e(env('SOFTWARE_VERSION')); ?>

                        </label>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/foodcol2/portal.foodcollections.com/resources/views/layouts/admin/partials/_footer.blade.php ENDPATH**/ ?>