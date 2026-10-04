<div class="v2-pinned-card" data-pin-key="<?php echo e($key); ?>" data-empty-text="<?php echo e(translate('Hover any item and tap the pin to add a shortcut here.')); ?>">
    <div class="v2-pinned-header">
        <span class="v2-pinned-icon"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></span>
        <span><?php echo e(translate('Pinned')); ?></span>
    </div>
    <div class="v2-pinned-list"></div>
</div>
<?php /**PATH /home/foodcol2/portal.foodcollections.com/resources/views/layouts/admin/partials/_v2_pinned_card.blade.php ENDPATH**/ ?>