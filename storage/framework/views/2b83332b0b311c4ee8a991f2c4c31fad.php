<div class="position-relative flex-shrink-0 <?php echo e($wrapperClass ?? ''); ?>"
     style="width:<?php echo e($size ?? 40); ?>px;height:<?php echo e($size ?? 40); ?>px;">
    <img <?php if(!empty($imgId)): ?> id="<?php echo e($imgId); ?>" <?php endif; ?>
         class="onerror-image w-100 h-100 <?php echo e($imgClass ?? 'rounded-circle aspect-1-1 object-cover'); ?>"
         width="<?php echo e($size ?? 40); ?>" height="<?php echo e($size ?? 40); ?>"
         data-onerror-image="<?php echo e($placeholder ?? asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
         src="<?php echo e($imageUrl ?? ($placeholder ?? asset('public/assets/admin/img/160x160/img1.jpg'))); ?>"
         alt="<?php echo e($alt ?? 'Image Description'); ?>">
    <?php if(!empty($proStatus) && \App\CentralLogics\Helpers::get_business_settings('pro_member_status') == 1): ?>
        <img width="<?php echo e($badgeSize ?? 14); ?>" height="<?php echo e($badgeSize ?? 14); ?>"
             src="<?php echo e(asset('public/assets/admin/img/subscriber-icon.png')); ?>"
             alt="Pro" data-toggle="tooltip" title="<?php echo e(translate('Pro customer')); ?>"
             class="rounded-circle position-absolute end-cus-0 top-0">
    <?php endif; ?>
</div>
<?php /**PATH /home/foodcol2/portal.foodcollections.com/resources/views/partials/_user-avatar.blade.php ENDPATH**/ ?>