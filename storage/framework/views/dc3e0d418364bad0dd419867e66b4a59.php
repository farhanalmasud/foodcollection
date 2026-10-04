<?php
    use App\CentralLogics\Helpers;

    $current_module_id   = Config::get('module.current_module_id');
    $current_module_type = Config::get('module.current_module_type');
    $is_food      = $current_module_type === 'food';
    $is_pharmacy  = $current_module_type === 'pharmacy';
    $is_ecommerce = $current_module_type === 'ecommerce';
    $is_grocery   = $current_module_type === 'grocery';
    $is_parcel    = $current_module_type === 'parcel';
    // BOGO bundles items and Happy Hour discounts a store's own prices, so both need a module
    // type with a line-item cart. Read from config/module.php beside stock and add_on, where
    // every other per-type rule lives, so the sidebar and the route guard cannot disagree about
    // which modules the screens exist for.
    $promotion_capable = (bool) config('module.'.$current_module_type.'.promotions');
    // Bundles carry their own admin switch and per-module tick list, so the sidebar asks the
    // same class the controller and the customer scope ask rather than repeating its rules.
    $bundle_capable = \App\Support\Promotion\BundleSettings::allowsModule($current_module_id);
    $can_parcel   = Helpers::module_permission_check('parcel');
    $can_sales_gate = $is_parcel ? $can_parcel : Helpers::module_permission_check('order');

    $reels_enabled = addon_published_status('ReelsModule')
        && Helpers::module_permission_check('reels')
        && (\Modules\ReelsModule\Support\ReelModuleConfig::isAllowedType($current_module_type) ?? false);

    // Per-module label overrides (food uses "restaurants" / "Food" terminology)
    $vendor_label           = $is_food ? translate('messages.restaurants') : translate('messages.Stores');
    $vendor_section_label   = $is_food ? translate('messages.restaurants') : translate('messages.Stores');
    $add_vendor_label       = $is_food ? translate('Add new restaurant') : translate('messages.Add store');
    $new_vendors_label      = $is_food ? translate('messages.New restaurants') : translate('messages.New stores');
    $recommended_label      = $is_food ? translate('Recommended restaurants') : translate('Recommended store');
    $item_setup_label       = $is_food ? translate('Food setup') : translate('Product setup');
    $item_gallery_label     = $is_food ? translate('Food gallery') : translate('Product gallery');
    $item_request_label     = $is_food ? translate('New food request') : translate('New item request');
    $item_campaign_label    = $is_food ? translate('messages.Food campaigns') : translate('Item campaigns');

    // Determine active rail section + active item from current request path
    $req = request()->path();
    $is = function($pat) use ($req) { return \Illuminate\Support\Str::is($pat, $req); };

    $active_section = 'dashboard';
    if ($is_parcel && ($is('admin/parcel/settings*') || $is('admin/parcel/cancellation-settings*'))) $active_section = 'parcel_settings';
    elseif ($is('admin/pos*') || $is('admin/order*') || $is('admin/refund/*') || $is('admin/parcel/orders/*') || $is('admin/parcel/details/*') || $is('admin/parcel/dispatch/*') || $is('admin/transactions/parcel/order/details/*') || $is('admin/transactions/order/details/*')) $active_section = 'sales';
    elseif ($is('admin/category*') || $is('admin/attribute*') || $is('admin/unit*') || $is('admin/item*') || $is('admin/addon*') || $is('admin/brand*') || $is('admin/common-condition*') || $is('admin/parcel/category*') || $is('admin/report/stock-report*') || $is('admin/store-category*')) $active_section = 'catalog';
    elseif ($is('admin/store*')) $active_section = 'vendors';
    elseif ($is('admin/flash-sale*') || $is('admin/campaign*') || $is('admin/banner*') || $is('admin/promotional-banner*') || $is('admin/coupon*') || $is('admin/notification*') || $is('admin/advertisement*') || $is('admin/reels*') || $is('admin/bogo-offer*') || $is('admin/happy-hour*') || $is('admin/bundle*')) $active_section = 'marketing';
?>

<aside id="v2-shell" class="v2-shell" data-workspace="module" data-active-section="<?php echo e($active_section); ?>">
    <div id="v2-rail" class="v2-rail v2-rail--module" role="navigation" aria-label="Sections">
        <div class="v2-rail-scope v2-rail-scope--module d-none">MODULE</div>
        <div class="v2-rail-btns">
            <button class="v2-rail-btn <?php echo e($active_section==='dashboard' ? 'is-active' : ''); ?>" data-section="dashboard" data-label="<?php echo e(translate('Dashboard')); ?>" aria-label="<?php echo e(translate('Dashboard')); ?>">
                <i data-lucide="gauge"></i>
                <span class="v2-pin-dot"></span>
            </button>
            <?php if($can_sales_gate || Helpers::module_permission_check('pos')): ?>
                <button class="v2-rail-btn <?php echo e($active_section==='sales' ? 'is-active' : ''); ?>" data-section="sales" data-label="<?php echo e(translate('Sales')); ?>" aria-label="<?php echo e(translate('Sales')); ?>">
                    <i data-lucide="shopping-bag"></i>
                    <span class="v2-pin-dot"></span>
                </button>
            <?php endif; ?>
            <?php if(Helpers::module_permission_check('category') || Helpers::module_permission_check('category') || Helpers::module_permission_check('category') || Helpers::module_permission_check('item') || Helpers::module_permission_check('addon') || Helpers::module_permission_check('category') || Helpers::module_permission_check('category') || ($is_parcel && Helpers::module_permission_check('parcel'))): ?>
                <button class="v2-rail-btn <?php echo e($active_section==='catalog' ? 'is-active' : ''); ?>" data-section="catalog" data-label="<?php echo e(translate('Catalog')); ?>" aria-label="<?php echo e(translate('Catalog')); ?>">
                    <i data-lucide="package"></i>
                    <span class="v2-pin-dot"></span>
                </button>
            <?php endif; ?>
            <?php if(!$is_parcel && Helpers::module_permission_check('store')): ?>
                <button class="v2-rail-btn <?php echo e($active_section==='vendors' ? 'is-active' : ''); ?>" data-section="vendors" data-label="<?php echo e(translate('messages.Stores')); ?>" aria-label="<?php echo e(translate('messages.Stores')); ?>">
                    <i data-lucide="store"></i>
                    <span class="v2-pin-dot"></span>
                </button>
            <?php endif; ?>
            <?php if($is_parcel && $can_parcel): ?>
                <button class="v2-rail-btn <?php echo e($active_section==='parcel_settings' ? 'is-active' : ''); ?>" data-section="parcel_settings" data-label="<?php echo e(translate('Delivery settings')); ?>" aria-label="<?php echo e(translate('Delivery settings')); ?>">
                    <i data-lucide="truck"></i>
                    <span class="v2-pin-dot"></span>
                </button>
            <?php endif; ?>
            <?php if(Helpers::module_permission_check('campaign') || Helpers::module_permission_check('banner') || Helpers::module_permission_check('coupon') || Helpers::module_permission_check('notification') || Helpers::module_permission_check('coupon')): ?>
                <button class="v2-rail-btn <?php echo e($active_section==='marketing' ? 'is-active' : ''); ?>" data-section="marketing" data-label="<?php echo e(translate('Marketing')); ?>" aria-label="<?php echo e(translate('Marketing')); ?>">
                    <i data-lucide="megaphone"></i>
                    <span class="v2-pin-dot"></span>
                </button>
            <?php endif; ?>
        </div>
        <div class="v2-rail-bottom">
            <button class="v2-rail-btn v2-rail-profile" id="v2-rail-profile" aria-haspopup="menu" aria-expanded="false" aria-label="<?php echo e(auth('admin')->user()->f_name ?? 'Admin'); ?>">
                <span class="v2-avatar"><?php echo e(strtoupper(substr(auth('admin')->user()->f_name ?? 'A', 0, 1) . substr(auth('admin')->user()->l_name ?? '', 0, 1))); ?></span>
            </button>
        </div>
    </div>

    <aside id="v2-panel" class="v2-panel" aria-label="<?php echo e(translate('Section navigation')); ?>">
        <div class="v2-panel-content" data-panel="dashboard" <?php if($active_section!=='dashboard'): ?> hidden <?php endif; ?>>
            <div class="v2-panel-header">
                <div class="v2-panel-title">
                    <span class="name"><?php echo e(translate('Dashboard')); ?></span>
                    <span class="v2-module-tag"><i data-lucide="layout-grid"></i><?php echo e(Config::get('module.current_module_name') ?? translate('Module')); ?></span>
                </div>
                <div class="v2-panel-subtitle"><?php echo e(translate('Module overview, key metrics, and quick links')); ?></div>
            </div>
            <div class="v2-panel-body">
                <?php echo $__env->make('layouts.admin.partials._v2_pinned_card', ['key' => 'module::dashboard'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div class="v2-group">
                    <div class="v2-group-items">
                        <a class="v2-nav-item <?php echo e($is('admin') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.dashboard')); ?>?module_id=<?php echo e($current_module_id); ?>" data-id="dash-overview">
                            <span class="v2-dot v2-dot--blue"></span>
                            <span class="v2-label"><?php echo e(translate('Module overview')); ?></span>
                            <button type="button" class="v2-pin" data-pin="dash-overview" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <?php if($can_sales_gate || Helpers::module_permission_check('pos')): ?>
        <div class="v2-panel-content" data-panel="sales" <?php if($active_section!=='sales'): ?> hidden <?php endif; ?>>
            <div class="v2-panel-header">
                <div class="v2-panel-title">
                    <span class="name"><?php echo e(translate('Sales')); ?></span>
                    <span class="v2-module-tag"><i data-lucide="layout-grid"></i><?php echo e(Config::get('module.current_module_name') ?? translate('Module')); ?></span>
                </div>
                <div class="v2-panel-subtitle"><?php echo e(translate('POS, all order states, and refund management')); ?></div>
            </div>
            <div class="v2-panel-body">
                <?php echo $__env->make('layouts.admin.partials._v2_pinned_card', ['key' => 'module::sales'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <?php if(!$is_parcel && Helpers::module_permission_check('pos')): ?>
                <div class="v2-group">
                    <button type="button" class="v2-group-header" data-group-toggle="sl-pos">
                        <span><?php echo e(translate('Point of sale')); ?></span>
                        <i data-lucide="chevron-down" class="v2-chev"></i>
                    </button>
                    <div class="v2-group-items">
                        <a class="v2-nav-item <?php echo e($is('admin/pos*') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.pos.index')); ?>" data-id="pos-new">
                            <span class="v2-dot v2-dot--green"></span>
                            <span class="v2-label"><?php echo e(translate('New sale')); ?></span>
                            <button type="button" class="v2-pin" data-pin="pos-new" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if($can_sales_gate): ?>
                <div class="v2-group">
                    <button type="button" class="v2-group-header" data-group-toggle="sl-orders">
                        <span><?php echo e(translate('messages.Orders')); ?></span>
                        <i data-lucide="chevron-down" class="v2-chev"></i>
                    </button>
                    <div class="v2-group-items">
                        <?php
                            if ($is_parcel) {
                                $order_items = [
                                    ['key' => 'or-all',  'route' => route('admin.parcel.orders', ['all']),              'label' => translate('All'),             'pat' => 'admin/parcel/orders/all',        'count' => $count_all,       'dot' => 'blue'],
                                    ['key' => 'or-pen',  'route' => route('admin.parcel.orders', ['pending']),          'label' => translate('Pending'),         'pat' => 'admin/parcel/orders/pending',    'count' => $count_pending,   'dot' => 'amber'],
                                    ['key' => 'or-acc',  'route' => route('admin.parcel.orders', ['accepted']),         'label' => translate('Accepted'),        'pat' => 'admin/parcel/orders/accepted',   'count' => $count_accepted,  'dot' => 'blue'],
                                    ['key' => 'or-prc',  'route' => route('admin.parcel.orders', ['processing']),       'label' => translate('Processing'),      'pat' => 'admin/parcel/orders/processing', 'count' => $count_processing,'dot' => 'violet'],
                                    ['key' => 'or-otw',  'route' => route('admin.parcel.orders', ['item_on_the_way']),  'label' => translate('messages.Order on the way'),'pat' => 'admin/parcel/orders/item_on_the_way', 'count' => $count_otw, 'dot' => 'amber'],
                                    ['key' => 'or-del',  'route' => route('admin.parcel.orders', ['delivered']),        'label' => translate('Delivered'),       'pat' => 'admin/parcel/orders/delivered',  'count' => $count_delivered, 'dot' => 'green'],
                                    ['key' => 'or-can',  'route' => route('admin.parcel.orders', ['canceled']),         'label' => translate('Canceled'),        'pat' => 'admin/parcel/orders/canceled',   'count' => $count_canceled,  'dot' => 'rose'],
                                    ['key' => 'or-fail', 'route' => route('admin.parcel.orders', ['failed']),           'label' => translate('Payment failed'),  'pat' => 'admin/parcel/orders/failed',     'count' => $count_failed,    'dot' => 'rose'],
                                    ['key' => 'or-off',  'route' => route('admin.order.offline_verification_list', ['all']), 'label' => translate('Offline payments'), 'pat' => 'admin/order/offline/payment/list*', 'count' => $count_offline, 'dot' => 'gray'],
                                ];
                            } else {
                                $order_items = [
                                    ['key' => 'or-all',  'route' => route('admin.order.list', ['all']),       'label' => translate('All'),             'pat' => 'admin/order/list/all',        'count' => $count_all,       'dot' => 'blue'],
                                    ['key' => 'or-sch',  'route' => route('admin.order.list', ['scheduled']), 'label' => translate('Scheduled'),       'pat' => 'admin/order/list/scheduled',  'count' => $count_scheduled, 'dot' => 'violet'],
                                    ['key' => 'or-pen',  'route' => route('admin.order.list', ['pending']),   'label' => translate('Pending'),         'pat' => 'admin/order/list/pending',    'count' => $count_pending,   'dot' => 'amber'],
                                    ['key' => 'or-acc',  'route' => route('admin.order.list', ['accepted']),  'label' => translate('Accepted'),        'pat' => 'admin/order/list/accepted',   'count' => $count_accepted,  'dot' => 'blue'],
                                    ['key' => 'or-prc',  'route' => route('admin.order.list', ['processing']),'label' => translate('Processing'),      'pat' => 'admin/order/list/processing', 'count' => $count_processing,'dot' => 'violet'],
                                    ['key' => 'or-otw',  'route' => route('admin.order.list', ['item_on_the_way']), 'label' => translate('messages.Order on the way'), 'pat' => 'admin/order/list/item_on_the_way', 'count' => $count_otw, 'dot' => 'amber'],
                                    ['key' => 'or-del',  'route' => route('admin.order.list', ['delivered']), 'label' => translate('Delivered'),       'pat' => 'admin/order/list/delivered',  'count' => $count_delivered, 'dot' => 'green'],
                                    ['key' => 'or-can',  'route' => route('admin.order.list', ['canceled']),  'label' => translate('Canceled'),        'pat' => 'admin/order/list/canceled',   'count' => $count_canceled,  'dot' => 'rose'],
                                    ['key' => 'or-fail', 'route' => route('admin.order.list', ['failed']),    'label' => translate('Payment failed'),  'pat' => 'admin/order/list/failed',     'count' => $count_failed,    'dot' => 'rose'],
                                    ['key' => 'or-ref',  'route' => route('admin.order.list', ['refunded']),  'label' => translate('Refunded'),        'pat' => 'admin/order/list/refunded',   'count' => $count_refunded,  'dot' => 'rose'],
                                    ['key' => 'or-off',  'route' => route('admin.order.offline_verification_list', ['all']), 'label' => translate('Offline payments'), 'pat' => 'admin/order/offline/payment/list*', 'count' => $count_offline, 'dot' => 'gray'],
                                ];
                            }
                        ?>
                        <?php $__currentLoopData = $order_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a class="v2-nav-item <?php echo e($is($oi['pat']) ? 'is-active' : ''); ?>" href="<?php echo e($oi['route']); ?>" data-id="<?php echo e($oi['key']); ?>">
                                <span class="v2-dot v2-dot--<?php echo e($oi['dot']); ?>"></span>
                                <span class="v2-label"><?php echo e($oi['label']); ?></span>
                                <span class="v2-count"><?php echo e($oi['count']); ?></span>
                                <button type="button" class="v2-pin" data-pin="<?php echo e($oi['key']); ?>" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <?php if($is_parcel): ?>
                <div class="v2-group">
                    <button type="button" class="v2-group-header" data-group-toggle="sl-dispatch">
                        <span><?php echo e(translate('messages.dispatch')); ?></span>
                        <i data-lucide="chevron-down" class="v2-chev"></i>
                    </button>
                    <div class="v2-group-items">
                        <a class="v2-nav-item <?php echo e($is('admin/parcel/dispatch/searching_for_deliverymen') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.parcel.list', ['searching_for_deliverymen'])); ?>" data-id="pa-un">
                            <span class="v2-dot v2-dot--amber"></span>
                            <span class="v2-label"><?php echo e(translate('messages.Unassigned orders')); ?></span>
                            <span class="v2-count"><?php echo e($count_unassigned ?? 0); ?></span>
                            <button type="button" class="v2-pin" data-pin="pa-un" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                        <a class="v2-nav-item <?php echo e($is('admin/parcel/dispatch/on_going') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.parcel.list', ['on_going'])); ?>" data-id="pa-on">
                            <span class="v2-dot v2-dot--green"></span>
                            <span class="v2-label"><?php echo e(translate('Ongoing orders')); ?></span>
                            <span class="v2-count"><?php echo e($count_ongoing ?? 0); ?></span>
                            <button type="button" class="v2-pin" data-pin="pa-on" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                    </div>
                </div>

                <?php endif; ?>

                <?php if(!$is_parcel): ?>
                <div class="v2-group">
                    <button type="button" class="v2-group-header" data-group-toggle="sl-refunds">
                        <span><?php echo e(translate('Refunds')); ?></span>
                        <i data-lucide="chevron-down" class="v2-chev"></i>
                    </button>
                    <div class="v2-group-items">
                        <a class="v2-nav-item <?php echo e($is('admin/refund/*') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.refund.refund_attr', ['requested'])); ?>" data-id="rf-req">
                            <span class="v2-dot v2-dot--amber"></span>
                            <span class="v2-label"><?php echo e(translate('Refund requests')); ?></span>
                            <span class="v2-count"><?php echo e($count_refund_req); ?></span>
                            <button type="button" class="v2-pin" data-pin="rf-req" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if($is_parcel && $can_parcel): ?>
        <div class="v2-panel-content" data-panel="parcel_settings" <?php if($active_section!=='parcel_settings'): ?> hidden <?php endif; ?>>
            <div class="v2-panel-header">
                <div class="v2-panel-title">
                    <span class="name"><?php echo e(translate('Delivery settings')); ?></span>
                    <span class="v2-module-tag"><i data-lucide="layout-grid"></i><?php echo e(Config::get('module.current_module_name') ?? translate('Module')); ?></span>
                </div>
                <div class="v2-panel-subtitle"><?php echo e(translate('Parcel delivery configuration and cancellation policy')); ?></div>
            </div>
            <div class="v2-panel-body">
                <?php echo $__env->make('layouts.admin.partials._v2_pinned_card', ['key' => 'module::parcel_settings'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div class="v2-group">
                    <div class="v2-group-items">
                        <a class="v2-nav-item <?php echo e($is('admin/parcel/settings*') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.parcel.settings')); ?>" data-id="pa-set">
                            <span class="v2-dot v2-dot--gray"></span>
                            <span class="v2-label"><?php echo e(translate('Parcel settings')); ?></span>
                            <button type="button" class="v2-pin" data-pin="pa-set" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                        <a class="v2-nav-item <?php echo e($is('admin/parcel/cancellation-settings') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.parcel.cancellationSettings')); ?>" data-id="pa-can">
                            <span class="v2-dot v2-dot--rose"></span>
                            <span class="v2-label"><?php echo e(translate('Cancellation setup')); ?></span>
                            <button type="button" class="v2-pin" data-pin="pa-can" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if(Helpers::module_permission_check('category') || Helpers::module_permission_check('category') || Helpers::module_permission_check('category') || Helpers::module_permission_check('item') || Helpers::module_permission_check('addon') || Helpers::module_permission_check('category') || Helpers::module_permission_check('category') || ($is_parcel && Helpers::module_permission_check('parcel'))): ?>
        <div class="v2-panel-content" data-panel="catalog" <?php if($active_section!=='catalog'): ?> hidden <?php endif; ?>>
            <div class="v2-panel-header">
                <div class="v2-panel-title">
                    <span class="name"><?php echo e(translate('Catalog')); ?></span>
                    <span class="v2-module-tag"><i data-lucide="layout-grid"></i><?php echo e(Config::get('module.current_module_name') ?? translate('Module')); ?></span>
                </div>
                <div class="v2-panel-subtitle"><?php echo e($is_parcel ? translate('Parcel category configuration') : translate('Categories, attributes, units, and items')); ?></div>
            </div>
            <div class="v2-panel-body">
                <?php echo $__env->make('layouts.admin.partials._v2_pinned_card', ['key' => 'module::catalog'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <?php if($is_parcel && Helpers::module_permission_check('parcel')): ?>
                <div class="v2-group">
                    <button type="button" class="v2-group-header" data-group-toggle="cat-pa">
                        <span><?php echo e(translate('Parcel categories')); ?></span>
                        <i data-lucide="chevron-down" class="v2-chev"></i>
                    </button>
                    <div class="v2-group-items">
                        <a class="v2-nav-item <?php echo e($is('admin/parcel/category*') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.parcel.category.index')); ?>" data-id="pa-cs">
                            <span class="v2-dot v2-dot--blue"></span>
                            <span class="v2-label"><?php echo e(translate('Category setup')); ?></span>
                            <button type="button" class="v2-pin" data-pin="pa-cs" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(!$is_parcel): ?>
                <?php if(Helpers::module_permission_check('category') || (!$is_food && Helpers::module_permission_check('category')) || (!$is_food && Helpers::module_permission_check('category')) || (($is_ecommerce || $is_grocery) && Helpers::module_permission_check('category')) || ($is_pharmacy && Helpers::module_permission_check('category'))): ?>
                <div class="v2-group">
                    <button type="button" class="v2-group-header" data-group-toggle="cat-setup">
                        <span><?php echo e(translate('Setup')); ?></span>
                        <i data-lucide="chevron-down" class="v2-chev"></i>
                    </button>
                    <div class="v2-group-items">
                        <?php if(Helpers::module_permission_check('category')): ?>
                            <button type="button" class="v2-nav-parent <?php echo e($is('admin/category*') ? 'is-open' : ''); ?>" data-parent-toggle="cat-cats">
                                <span class="v2-dot v2-dot--blue"></span>
                                <span class="v2-label"><?php echo e(translate('Categories')); ?></span>
                                <i data-lucide="chevron-right" class="v2-chev"></i>
                            </button>
                            <div class="v2-nav-children" <?php if(!$is('admin/category*')): ?> hidden <?php endif; ?>>
                                <a class="v2-nav-item <?php echo e(request()->input('position') == 0 && $is('admin/category/add') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.category.add', ['position' => 0])); ?>">
                                    <span class="v2-dot v2-dot--gray"></span><span class="v2-label"><?php echo e(translate('messages.Category')); ?></span>
                                </a>
                                <a class="v2-nav-item <?php echo e(request()->input('position') == 1 && $is('admin/category/add') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.category.add', ['position' => 1])); ?>">
                                    <span class="v2-dot v2-dot--gray"></span><span class="v2-label"><?php echo e(translate('Subcategory')); ?></span>
                                </a>
                                <a class="v2-nav-item <?php echo e($is('admin/category/bulk-import') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.category.bulk-import')); ?>">
                                    <span class="v2-dot v2-dot--gray"></span><span class="v2-label"><?php echo e(translate('Bulk import')); ?></span>
                                </a>
                                <a class="v2-nav-item <?php echo e($is('admin/category/bulk-export') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.category.bulk-export-index')); ?>">
                                    <span class="v2-dot v2-dot--gray"></span><span class="v2-label"><?php echo e(translate('Bulk export')); ?></span>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if(!$is_food && Helpers::module_permission_check('category')): ?>
                            <a class="v2-nav-item <?php echo e($is('admin/attribute*') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.attribute.add-new')); ?>" data-id="cat-attr">
                                <span class="v2-dot v2-dot--violet"></span>
                                <span class="v2-label"><?php echo e(translate('messages.attributes')); ?></span>
                                <button type="button" class="v2-pin" data-pin="cat-attr" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                            </a>
                        <?php endif; ?>

                        <?php if(Helpers::storeCategoryStatus() && Helpers::module_permission_check('category')): ?>
                            <a class="v2-nav-item <?php echo e($is('admin/store-category*') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.store-category.list')); ?>" data-id="cat-store-cat">
                                <span class="v2-dot v2-dot--blue"></span>
                                <span class="v2-label"><?php echo e(translate('Store categories')); ?></span>
                                <button type="button" class="v2-pin" data-pin="cat-store-cat" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                            </a>
                        <?php endif; ?>

                        <?php if(!$is_food && Helpers::module_permission_check('category')): ?>
                            <a class="v2-nav-item <?php echo e($is('admin/unit*') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.unit.index')); ?>" data-id="cat-units">
                                <span class="v2-dot v2-dot--amber"></span>
                                <span class="v2-label"><?php echo e(translate('messages.units')); ?></span>
                                <button type="button" class="v2-pin" data-pin="cat-units" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                            </a>
                        <?php endif; ?>

                        <?php if(($is_ecommerce || $is_grocery) && Helpers::module_permission_check('category')): ?>
                            <a class="v2-nav-item <?php echo e($is('admin/brand*') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.brand.add')); ?>" data-id="cat-brand">
                                <span class="v2-dot v2-dot--rose"></span>
                                <span class="v2-label"><?php echo e(translate('messages.Brands')); ?></span>
                                <button type="button" class="v2-pin" data-pin="cat-brand" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                            </a>
                        <?php endif; ?>

                        <?php if($is_pharmacy && Helpers::module_permission_check('category')): ?>
                            <a class="v2-nav-item <?php echo e($is('admin/common-condition*') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.common-condition.add')); ?>" data-id="cat-cc">
                                <span class="v2-dot v2-dot--amber"></span>
                                <span class="v2-label"><?php echo e(translate('Common conditions')); ?></span>
                                <button type="button" class="v2-pin" data-pin="cat-cc" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if($is_food && Helpers::module_permission_check('addon')): ?>
                <div class="v2-group">
                    <button type="button" class="v2-group-header" data-group-toggle="cat-addons">
                        <span><?php echo e(translate('Addons')); ?></span>
                        <i data-lucide="chevron-down" class="v2-chev"></i>
                    </button>
                    <div class="v2-group-items">
                        <a class="v2-nav-item <?php echo e($is('admin/addon/addon-category') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.addon.addon-category')); ?>" data-id="ad-cat">
                            <span class="v2-dot v2-dot--blue"></span><span class="v2-label"><?php echo e(translate('Addon category')); ?></span>
                            <button type="button" class="v2-pin" data-pin="ad-cat" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                        <a class="v2-nav-item <?php echo e(($is('admin/addon') || $is('admin/addon/edit/*')) ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.addon.add-new')); ?>" data-id="ad-list">
                            <span class="v2-dot v2-dot--green"></span><span class="v2-label"><?php echo e(translate('messages.list')); ?></span>
                            <button type="button" class="v2-pin" data-pin="ad-list" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                        <a class="v2-nav-item <?php echo e($is('admin/addon/bulk-import') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.addon.bulk-import')); ?>" data-id="ad-imp">
                            <span class="v2-dot v2-dot--gray"></span><span class="v2-label"><?php echo e(translate('Bulk import')); ?></span>
                        </a>
                        <a class="v2-nav-item <?php echo e($is('admin/addon/bulk-export') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.addon.bulk-export-index')); ?>" data-id="ad-exp">
                            <span class="v2-dot v2-dot--gray"></span><span class="v2-label"><?php echo e(translate('Bulk export')); ?></span>
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(Helpers::module_permission_check('item')): ?>
                <div class="v2-group">
                    <button type="button" class="v2-group-header" data-group-toggle="cat-items">
                        <span><?php echo e($is_food ? translate('messages.Food management') : translate('Product management')); ?></span>
                        <i data-lucide="chevron-down" class="v2-chev"></i>
                    </button>
                    <div class="v2-group-items">
                        <a class="v2-nav-item <?php echo e($is('admin/item/add-new') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.item.add-new')); ?>" data-id="is-add">
                            <span class="v2-dot v2-dot--green"></span><span class="v2-label"><?php echo e(translate('Add new')); ?></span>
                            <button type="button" class="v2-pin" data-pin="is-add" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                        <a class="v2-nav-item <?php echo e(($is('admin/item/list*') || $is('admin/item/edit/*') || $is('admin/item/view/*')) ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.item.list')); ?>" data-id="is-list">
                            <span class="v2-dot v2-dot--blue"></span><span class="v2-label"><?php echo e(translate('messages.list')); ?></span>
                            <button type="button" class="v2-pin" data-pin="is-list" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                        <?php if(!$is_food && Helpers::module_permission_check('report')): ?>
                        <a class="v2-nav-item <?php echo e($is('admin/report/stock-report*') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.report.stock-report')); ?>" data-id="is-low">
                            <span class="v2-dot v2-dot--rose"></span><span class="v2-label"><?php echo e(translate('Low stock list')); ?></span>
                            <button type="button" class="v2-pin" data-pin="is-low" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                        <?php endif; ?>
                        <a class="v2-nav-item <?php echo e($is('admin/item/product-gallery') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.item.product_gallery')); ?>" data-id="is-gal">
                            <span class="v2-dot v2-dot--violet"></span><span class="v2-label"><?php echo e($item_gallery_label); ?></span>
                            <button type="button" class="v2-pin" data-pin="is-gal" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                        <?php if(Helpers::get_business_settings('product_approval')): ?>
                        <a class="v2-nav-item <?php echo e($is('admin/item/new/item/list') || $is('admin/item/requested/item/view/*') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.item.approval_list')); ?>" data-id="is-new">
                            <span class="v2-dot v2-dot--amber"></span><span class="v2-label"><?php echo e($item_request_label); ?></span>
                            <span class="v2-count"><?php echo e($count_new_items); ?></span>
                            <button type="button" class="v2-pin" data-pin="is-new" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                        <?php endif; ?>
                        <a class="v2-nav-item <?php echo e($is('admin/item/reviews') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.item.reviews')); ?>" data-id="is-rev">
                            <span class="v2-dot v2-dot--green"></span><span class="v2-label"><?php echo e(translate('messages.review')); ?></span>
                            <button type="button" class="v2-pin" data-pin="is-rev" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                        <a class="v2-nav-item <?php echo e($is('admin/item/bulk-import') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.item.bulk-import')); ?>" data-id="is-imp">
                            <span class="v2-dot v2-dot--gray"></span><span class="v2-label"><?php echo e(translate('Bulk import')); ?></span>
                        </a>
                        <a class="v2-nav-item <?php echo e($is('admin/item/bulk-export') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.item.bulk-export-index')); ?>" data-id="is-exp">
                            <span class="v2-dot v2-dot--gray"></span><span class="v2-label"><?php echo e(translate('Bulk export')); ?></span>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if(!$is_parcel && Helpers::module_permission_check('store')): ?>
        <div class="v2-panel-content" data-panel="vendors" <?php if($active_section!=='vendors'): ?> hidden <?php endif; ?>>
            <div class="v2-panel-header">
                <div class="v2-panel-title">
                    <span class="name"><?php echo e($vendor_section_label); ?></span>
                    <span class="v2-module-tag"><i data-lucide="layout-grid"></i><?php echo e(Config::get('module.current_module_name') ?? translate('Module')); ?></span>
                </div>
                <div class="v2-panel-subtitle"><?php echo e($is_food ? translate('Restaurants directory, onboarding, and bulk tools') : translate('Stores directory, onboarding, and bulk tools')); ?></div>
            </div>
            <div class="v2-panel-body">
                <?php echo $__env->make('layouts.admin.partials._v2_pinned_card', ['key' => 'module::vendors'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <div class="v2-group">
                    <button type="button" class="v2-group-header" data-group-toggle="v-dir">
                        <span><?php echo e(translate('Directory')); ?></span>
                        <i data-lucide="chevron-down" class="v2-chev"></i>
                    </button>
                    <div class="v2-group-items">
                        <a class="v2-nav-item <?php echo e(($is('admin/store/list*') || $is('admin/store/view/*') || $is('admin/store/edit/*')) ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.store.list')); ?>" data-id="v-list">
                            <span class="v2-dot v2-dot--blue"></span><span class="v2-label"><?php echo e($vendor_label); ?> <?php echo e(translate('list')); ?></span>
                            <button type="button" class="v2-pin" data-pin="v-list" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                        <a class="v2-nav-item <?php echo e($is('admin/store/add') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.store.add')); ?>" data-id="v-add">
                            <span class="v2-dot v2-dot--green"></span><span class="v2-label"><?php echo e($add_vendor_label); ?></span>
                            <button type="button" class="v2-pin" data-pin="v-add" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                        <a class="v2-nav-item <?php echo e($is('admin/store/pending-requests') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.store.pending-requests')); ?>" data-id="v-new">
                            <span class="v2-dot v2-dot--amber"></span><span class="v2-label"><?php echo e($new_vendors_label); ?></span>
                            <?php if($count_new_stores > 0): ?><span class="v2-count"><?php echo e($count_new_stores); ?></span><?php endif; ?>
                            <button type="button" class="v2-pin" data-pin="v-new" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                        <a class="v2-nav-item <?php echo e($is('admin/store/recommended-store') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.store.recommended_store')); ?>" data-id="v-rec">
                            <span class="v2-dot v2-dot--violet"></span><span class="v2-label"><?php echo e($recommended_label); ?></span>
                            <button type="button" class="v2-pin" data-pin="v-rec" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                    </div>
                </div>

                <?php if(Helpers::module_permission_check('store_bulk')): ?>
                <div class="v2-group">
                    <button type="button" class="v2-group-header" data-group-toggle="v-bulk">
                        <span><?php echo e(translate('Bulk')); ?></span>
                        <i data-lucide="chevron-down" class="v2-chev"></i>
                    </button>
                    <div class="v2-group-items">
                        <a class="v2-nav-item <?php echo e($is('admin/store/bulk-import') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.store.bulk-import')); ?>" data-id="v-imp">
                            <span class="v2-dot v2-dot--gray"></span><span class="v2-label"><?php echo e(translate('Bulk import')); ?></span>
                        </a>
                        <a class="v2-nav-item <?php echo e($is('admin/store/bulk-export') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.store.bulk-export-index')); ?>" data-id="v-exp">
                            <span class="v2-dot v2-dot--gray"></span><span class="v2-label"><?php echo e(translate('Bulk export')); ?></span>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if(Helpers::module_permission_check('campaign') || Helpers::module_permission_check('banner') || Helpers::module_permission_check('coupon') || Helpers::module_permission_check('notification') || Helpers::module_permission_check('coupon')): ?>
        <div class="v2-panel-content" data-panel="marketing" <?php if($active_section!=='marketing'): ?> hidden <?php endif; ?>>
            <div class="v2-panel-header">
                <div class="v2-panel-title">
                    <span class="name"><?php echo e(translate('Marketing')); ?></span>
                    <span class="v2-module-tag"><i data-lucide="layout-grid"></i><?php echo e(Config::get('module.current_module_name') ?? translate('Module')); ?></span>
                </div>
                <div class="v2-panel-subtitle"><?php echo e(translate('Campaigns, promotions, banners, and reels')); ?></div>
            </div>
            <div class="v2-panel-body">
                <?php echo $__env->make('layouts.admin.partials._v2_pinned_card', ['key' => 'module::marketing'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <?php if(!$is_parcel && Helpers::module_permission_check('campaign')): ?>
                <div class="v2-group">
                    <button type="button" class="v2-group-header" data-group-toggle="mk-camp">
                        <span><?php echo e(translate('campaigns')); ?></span>
                        <i data-lucide="chevron-down" class="v2-chev"></i>
                    </button>
                    <div class="v2-group-items">
                        <?php if(!$is_food && !$is_pharmacy): ?>
                        <a class="v2-nav-item <?php echo e($is('admin/flash-sale*') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.flash-sale.add-new')); ?>" data-id="mk-flash">
                            <span class="v2-dot v2-dot--rose"></span><span class="v2-label"><?php echo e(translate('Flash sales')); ?></span>
                            <button type="button" class="v2-pin" data-pin="mk-flash" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                        <?php endif; ?>
                        <button type="button" class="v2-nav-parent <?php echo e($is('admin/campaign*') ? 'is-open' : ''); ?>" data-parent-toggle="mk-camps">
                            <span class="v2-dot v2-dot--blue"></span><span class="v2-label"><?php echo e(translate('messages.campaigns')); ?></span>
                            <i data-lucide="chevron-right" class="v2-chev"></i>
                        </button>
                        <div class="v2-nav-children" <?php if(!$is('admin/campaign*')): ?> hidden <?php endif; ?>>
                            <a class="v2-nav-item <?php echo e($is('admin/campaign/basic/*') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.campaign.list', 'basic')); ?>">
                                <span class="v2-dot v2-dot--gray"></span><span class="v2-label"><?php echo e(translate('messages.Basic campaigns')); ?></span>
                            </a>
                            <a class="v2-nav-item <?php echo e($is('admin/campaign/item/*') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.campaign.list', 'item')); ?>">
                                <span class="v2-dot v2-dot--gray"></span><span class="v2-label"><?php echo e($item_campaign_label); ?></span>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(!$is_parcel && (Helpers::module_permission_check('coupon') || Helpers::module_permission_check('coupon'))): ?>
                <div class="v2-group">
                    <button type="button" class="v2-group-header" data-group-toggle="mk-promo">
                        <span><?php echo e(translate('Promotions')); ?></span>
                        <i data-lucide="chevron-down" class="v2-chev"></i>
                    </button>
                    <div class="v2-group-items">
                        <?php if(Helpers::module_permission_check('coupon')): ?>
                            <a class="v2-nav-item <?php echo e($is('admin/coupon*') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.coupon.add-new')); ?>" data-id="mk-coup">
                                <span class="v2-dot v2-dot--green"></span><span class="v2-label"><?php echo e(translate('messages.coupons')); ?></span>
                                <button type="button" class="v2-pin" data-pin="mk-coup" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                            </a>
                        <?php endif; ?>
                        
                        <?php if($promotion_capable && Helpers::module_permission_check('coupon')): ?>
                            <a class="v2-nav-item <?php echo e($is('admin/bogo-offer*') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.bogo-offer.list')); ?>" data-id="mk-bogo">
                                <span class="v2-dot v2-dot--green"></span><span class="v2-label"><?php echo e(translate('BOGO offer')); ?></span>
                                <button type="button" class="v2-pin" data-pin="mk-bogo" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                            </a>
                        <?php endif; ?>
                        <?php if($promotion_capable && Helpers::module_permission_check('coupon')): ?>
                            <a class="v2-nav-item <?php echo e($is('admin/happy-hour*') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.happy-hour.list')); ?>" data-id="mk-hh">
                                <span class="v2-dot v2-dot--amber"></span><span class="v2-label"><?php echo e(translate('Happy hour')); ?></span>
                                <button type="button" class="v2-pin" data-pin="mk-hh" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                            </a>
                        <?php endif; ?>
                        <?php if($bundle_capable && Helpers::module_permission_check('coupon')): ?>
                            <a class="v2-nav-item <?php echo e($is('admin/bundle*') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.bundle.list')); ?>" data-id="mk-bundle">
                                <span class="v2-dot v2-dot--green"></span><span class="v2-label"><?php echo e(translate('Bundle package')); ?></span>
                                <button type="button" class="v2-pin" data-pin="mk-bundle" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                            </a>
                        <?php endif; ?>
                        <?php if(Helpers::module_permission_check('coupon')): ?>
                            <?php
                                $ad_create_active = $is('admin/advertisement/create*');
                                $ad_requests_active = $is('admin/advertisement/requests*');
                                $ad_list_active = $is('admin/advertisement*') && !$ad_create_active && !$ad_requests_active;
                                $ad_any_active = $ad_create_active || $ad_requests_active || $ad_list_active;
                            ?>
                            <button type="button" class="v2-nav-parent <?php echo e($ad_any_active ? 'is-open is-active' : ''); ?>" data-parent-toggle="mk-ad">
                                <span class="v2-dot v2-dot--amber"></span><span class="v2-label"><?php echo e(translate('Advertisement')); ?></span>
                                <i data-lucide="chevron-right" class="v2-chev"></i>
                            </button>
                            <div class="v2-nav-children" <?php if(!$ad_any_active): ?> hidden <?php endif; ?>>
                                <a class="v2-nav-item <?php echo e($ad_create_active ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.advertisement.create')); ?>">
                                    <span class="v2-dot v2-dot--gray"></span><span class="v2-label"><?php echo e(translate('New advertisement')); ?></span>
                                </a>
                                <a class="v2-nav-item <?php echo e($ad_requests_active ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.advertisement.requestList')); ?>">
                                    <span class="v2-dot v2-dot--gray"></span><span class="v2-label"><?php echo e(translate('Advertisement requests')); ?></span>
                                </a>
                                <a class="v2-nav-item <?php echo e($ad_list_active ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.advertisement.index')); ?>">
                                    <span class="v2-dot v2-dot--gray"></span><span class="v2-label"><?php echo e(translate('Advertisement list')); ?></span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(Helpers::module_permission_check('banner')): ?>
                <div class="v2-group">
                    <button type="button" class="v2-group-header" data-group-toggle="mk-ban">
                        <span><?php echo e(translate('banners')); ?></span>
                        <i data-lucide="chevron-down" class="v2-chev"></i>
                    </button>
                    <div class="v2-group-items">
                        <?php if(!$is_parcel): ?>
                        <a class="v2-nav-item <?php echo e($is('admin/banner*') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.banner.add-new')); ?>" data-id="mk-bn">
                            <span class="v2-dot v2-dot--blue"></span><span class="v2-label"><?php echo e(translate('messages.banners')); ?></span>
                            <button type="button" class="v2-pin" data-pin="mk-bn" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                        <?php endif; ?>
                        <a class="v2-nav-item <?php echo e($is('admin/promotional-banner*') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.promotional-banner.add-new')); ?>" data-id="mk-obn">
                            <span class="v2-dot v2-dot--violet"></span><span class="v2-label"><?php echo e($is_parcel ? translate('Promotional banners') : translate('messages.Other banners')); ?></span>
                            <button type="button" class="v2-pin" data-pin="mk-obn" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(!$is_parcel && Helpers::module_permission_check('notification')): ?>
                <div class="v2-group">
                    <button type="button" class="v2-group-header" data-group-toggle="mk-comm">
                        <span><?php echo e(translate('Communication')); ?></span>
                        <i data-lucide="chevron-down" class="v2-chev"></i>
                    </button>
                    <div class="v2-group-items">
                        <a class="v2-nav-item <?php echo e($is('admin/notification*') ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.notification.add-new')); ?>" data-id="mk-pn">
                            <span class="v2-dot v2-dot--rose"></span><span class="v2-label"><?php echo e(translate('Push notification')); ?></span>
                            <button type="button" class="v2-pin" data-pin="mk-pn" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(!$is_parcel && $reels_enabled): ?>
                <div class="v2-group">
                    <button type="button" class="v2-group-header" data-group-toggle="mk-reels">
                        <span><?php echo e(translate('Reels management')); ?></span>
                        <i data-lucide="chevron-down" class="v2-chev"></i>
                    </button>
                    <?php
                        $reel_create_active = $is('admin/reels/create*');
                        $reel_list_active = $is('admin/reels*') && !$reel_create_active;
                    ?>
                    <div class="v2-group-items">
                        <a class="v2-nav-item <?php echo e($reel_create_active ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.reels.create')); ?>" data-id="rl-cr">
                            <span class="v2-dot v2-dot--rose"></span><span class="v2-label"><?php echo e(translate('Create reels')); ?></span>
                            <button type="button" class="v2-pin" data-pin="rl-cr" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                        <a class="v2-nav-item <?php echo e($reel_list_active ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.reels.index')); ?>" data-id="rl-ls">
                            <span class="v2-dot v2-dot--blue"></span><span class="v2-label"><?php echo e(translate('Reels list')); ?></span>
                            <button type="button" class="v2-pin" data-pin="rl-ls" title="<?php echo e(translate('Pin')); ?>"><?php echo $__env->make('layouts.admin.partials._v2_pin_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></button>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </aside>
</aside>

<?php echo $__env->make('layouts.admin.partials._v2_profile_pop', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('layouts.admin.partials._v2_sidebar_script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH /home/foodcol2/portal.foodcollections.com/resources/views/layouts/admin/partials/_sidebar_v2.blade.php ENDPATH**/ ?>