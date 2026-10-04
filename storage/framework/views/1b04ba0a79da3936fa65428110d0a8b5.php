<div class="card-header border-0 order-header-shadow">
    <h5 class="card-title d-flex justify-content-between">
        <span>
            <?php echo e(translate('most rated')); ?><?php if(Config::get('module.current_module_type') == 'food'): ?>
                <?php echo e(translate('Food')); ?>

            <?php else: ?>
                <?php echo e(translate('messages.Items')); ?>

            <?php endif; ?>
        </span>
    </h5>
    <?php ($params = session('dash_params')); ?>
    <?php if($params['zone_id'] != 'all'): ?>
    <?php else: ?>
    <?php endif; ?>
    <a href="<?php echo e(route('admin.item.list')); ?>" class="fz-12px font-medium text-006AE5"><?php echo e(translate('View all')); ?></a>
</div>

<div class="card-body">
    <?php if(count($top_rated_foods) > 0): ?>
        <div class="rated--products">
            <?php $__empty_1 = true; $__currentLoopData = $top_rated_foods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('admin.item.view', [$item['id']])); ?>">
                    <div class="rated-media d-flex align-items-center">
                        <img src="<?php echo e($item['image_full_url'] ?? asset('public/assets/admin/img/100x100/2.png')); ?>"
                            class="onerror-image"
                            data-onerror-image="<?php echo e(asset('public/assets/admin/img/100x100/2.png')); ?>"
                            alt="<?php echo e(Str::limit($item->name ?? translate('messages.Item deleted!'), 20, '...')); ?>">
                        <span class="line--limit-1 w-0 flex-grow-1 text-hover--primary" title="<?php echo e($item?->name); ?>">
                            <?php echo e(Str::limit($item->name ?? translate('messages.Item deleted!'), 20, '...')); ?>

                        </span>
                        <div>
                            <span class="text-FF6D6D"><?php echo e($item['rating_count']); ?> <i class="tio-heart"></i></span>
                        </div>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="empty--data d-flex flex-column align-items-center justify-content-center h-100 w-100">
            <img src="<?php echo e(asset('/public/assets/admin/img/no-items.png')); ?>" alt="public">
            <h5 class="secondary-clr">
                <?php echo e(translate('No stores available')); ?>

            </h5>
        </div>
    <?php endif; ?>







</div>
<?php /**PATH /home/foodcol2/portal.foodcollections.com/resources/views/admin-views/partials/_top-rated-foods.blade.php ENDPATH**/ ?>