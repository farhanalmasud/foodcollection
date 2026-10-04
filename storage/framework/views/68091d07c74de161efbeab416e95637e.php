
<?php
    // strip_tags + decode: a handful of titles arrive pre-escaped, and Blade
    // escapes the crumb again on the way out.
    $bcx_trail = app(\App\Services\System\BreadcrumbService::class)
        ->trail(trim(html_entity_decode(strip_tags($__env->yieldContent('title')), ENT_QUOTES)));
?>

<?php if(count($bcx_trail) > 1): ?>
    <nav class="bcx container-fluid" aria-label="<?php echo e(translate('Breadcrumb')); ?>">
        <div class="bcx__scroll">
            <ol class="bcx__list">
                <?php $__currentLoopData = $bcx_trail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bcx_index => $bcx_crumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="bcx__item">
                        <?php if($bcx_crumb['current']): ?>
                            <span class="bcx__current" aria-current="page"><?php echo e($bcx_crumb['label']); ?></span>
                        <?php elseif($bcx_crumb['url']): ?>
                            <a class="bcx__link" href="<?php echo e($bcx_crumb['url']); ?>">
                                <?php if($bcx_index === 0): ?>
                                    <i class="tio-home-outlined bcx__home" aria-hidden="true"></i>
                                <?php endif; ?>
                                <span><?php echo e($bcx_crumb['label']); ?></span>
                            </a>
                        <?php elseif($bcx_crumb['panel']): ?>
                            
                            <button type="button" class="bcx__step" data-bc-panel="<?php echo e($bcx_crumb['panel']); ?>"
                                title="<?php echo e(translate('Open this section in the sidebar')); ?>">
                                <?php echo e($bcx_crumb['label']); ?>

                            </button>
                        <?php else: ?>
                            
                            <span class="bcx__text"><?php echo e($bcx_crumb['label']); ?></span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ol>
        </div>
    </nav>
<?php endif; ?>
<?php /**PATH /home/foodcol2/portal.foodcollections.com/resources/views/partials/_breadcrumb.blade.php ENDPATH**/ ?>