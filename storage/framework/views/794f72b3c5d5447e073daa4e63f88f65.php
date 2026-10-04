<div class="card-header border-0 order-header-shadow">
    <h5 class="card-title d-flex justify-content-between">
        <?php echo e(translate('most popular')); ?> <?php if(Config::get('module.current_module_type') == 'food'): ?>
            <?php echo e(translate('messages.restaurants')); ?>

        <?php else: ?>
            <?php echo e(translate('messages.Stores')); ?>

        <?php endif; ?>
    </h5>
    <?php ($params = session('dash_params')); ?>
    <?php if($params['zone_id'] != 'all'): ?>
    <?php else: ?>
    <?php endif; ?>
    <a href="<?php echo e(route('admin.store.list')); ?>" class="fz-12px font-medium text-006AE5"><?php echo e(translate('View all')); ?></a>

</div>

<div class="card-body">

    <?php if(count($popular) > 0): ?>
        <ul class="most-popular">
            <?php $__currentLoopData = $popular; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="cursor-pointer redirect-url" data-url="<?php echo e(route('admin.store.view', $item->store_id)); ?>">
                    <div class="img-container">
                        <img class="onerror-image"
                            data-onerror-image="<?php echo e(asset('public/assets/admin/img/100x100/1.png')); ?>"
                            src="<?php echo e($item->store['logo_full_url'] ?? asset('public/assets/admin/img/100x100/1.png')); ?>"
                            alt="<?php echo e(translate('Store')); ?>" title="<?php echo e($item?->store?->name); ?>">
                        <a href="<?php echo e(route('admin.store.view', $item->store_id)); ?>">
                            <span class="text-hover--primary ml-2" title="<?php echo e($item?->store?->name); ?>">
                                <?php echo e(Str::limit($item->store->name ?? translate('messages.Store deleted'), 20, '...')); ?>

                            </span>
                        </a>
                    </div>
                    <div>
                        <span class="text-FF6D6D"><?php echo e($item['count']); ?> <i class="tio-heart"></i></span>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php else: ?>
        <div class="empty--data d-flex flex-column align-items-center justify-content-center h-100 w-100">
            <img src="<?php echo e(asset('/public/assets/admin/img/no-store.png')); ?>" alt="public">
            <h5 class="secondary-clr">
                <?php echo e(translate('No stores available')); ?>

            </h5>
        </div>
    <?php endif; ?>


</div>
<?php /**PATH /home/foodcol2/portal.foodcollections.com/resources/views/admin-views/partials/_popular-restaurants.blade.php ENDPATH**/ ?>