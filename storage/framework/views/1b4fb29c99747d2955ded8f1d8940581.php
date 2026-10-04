<div class="card-header border-0 order-header-shadow">
    <h5 class="card-title d-flex justify-content-between">
        <?php echo e(translate('top selling stores')); ?>

    </h5>
    <?php ($params = session('dash_params')); ?>
    <?php if($params['zone_id'] != 'all'): ?>
    <?php else: ?>
    <?php endif; ?>
    <a href="<?php echo e(route('admin.store.list')); ?>" class="fz-12px font-medium text-006AE5"><?php echo e(translate('View all')); ?></a>
</div>

<div class="card-body __top-resturant-card">

    <?php if(count($top_restaurants) > 0): ?>
        <div class="__top-resturant">
            <?php $__currentLoopData = $top_restaurants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('admin.store.view', $item->id)); ?>">
                    <div class="position-relative overflow-hidden">
                        <img class="onerror-image"
                            data-onerror-image="<?php echo e(asset('public/assets/admin/img/100x100/1.png')); ?>"
                            src="<?php echo e($item['logo_full_url'] ?? asset('public/assets/admin/img/100x100/1.png')); ?>"
                            title="<?php echo e($item?->name); ?>">
                        <h5 class="info m-0">
                            <?php echo e(translate('Order')); ?>:  <?php echo e($item['order_count']); ?>

                        </h5>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="empty--data d-flex flex-column align-items-center justify-content-center h-100 w-100">
            <img src="<?php echo e(asset('/public/assets/admin/img/no-store.png')); ?>" alt="public">
            <h5 class="secondary-clr">
                <?php echo e(translate('No stores available')); ?>

            </h5>
        </div>
    <?php endif; ?>

</div>
<?php /**PATH /home/foodcol2/portal.foodcollections.com/resources/views/admin-views/partials/_top-restaurants.blade.php ENDPATH**/ ?>