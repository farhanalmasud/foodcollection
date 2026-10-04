<?php
    use App\CentralLogics\Helpers;
    $admin_user = auth('admin')->user();
?>
<div class="v2-profile-pop" id="v2-profile-pop" role="menu">
    <div class="v2-profile-pop-head">
        <span class="v2-avatar v2-avatar--lg"><?php echo e(strtoupper(substr($admin_user->f_name ?? 'A', 0, 1) . substr($admin_user->l_name ?? '', 0, 1))); ?></span>
        <div class="v2-meta">
            <div class="v2-name"><?php echo e(trim(($admin_user->f_name ?? '') . ' ' . ($admin_user->l_name ?? '')) ?: 'Admin'); ?></div>
            <div class="v2-email"><?php echo e($admin_user->email ?? ''); ?></div>
        </div>
    </div>
    <?php if(Helpers::module_permission_check('profile')): ?>
    <a class="v2-profile-pop-item" href="<?php echo e(route('admin.settings')); ?>">
        <i data-lucide="user-cog"></i><span><?php echo e(translate('Profile settings')); ?></span>
    </a>
    <?php endif; ?>
    <button type="button" class="v2-profile-pop-item v2-profile-pop-item--danger log-out">
        <i data-lucide="log-out"></i><span><?php echo e(translate('Log out')); ?></span>
    </button>
</div>
<?php /**PATH /home/foodcol2/portal.foodcollections.com/resources/views/layouts/admin/partials/_v2_profile_pop.blade.php ENDPATH**/ ?>