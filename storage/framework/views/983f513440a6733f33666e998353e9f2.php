<?php
    use App\CentralLogics\Helpers;

    $current_module_id   = Config::get('module.current_module_id');
    $current_module_type = Config::get('module.current_module_type');
    $current_module_name = Config::get('module.current_module_name');
    $current_module_icon = Config::get('module.current_module_icon');
    $admin_user          = auth('admin')->user();
    $local               = session()->has('local') ? session('local') : null;
    $lang                = Helpers::get_business_settings('system_language');

    $modules = app(\App\Services\System\ModuleService::class)->switcherModules($admin_user?->zone_id);

    // Helpers::admin_workspace_for_path() is the single source of truth for
    // which tab is active — the sidebar shell and the breadcrumb read the same
    // rules, so all three stay in step.
    $workspace         = Helpers::admin_workspace_for_path();
    $is_settings_path  = $workspace === 'settings';
    $is_users_path     = $workspace === 'users';
    $is_dispatch_path  = $workspace === 'dispatch';
    $is_reports_path   = $workspace === 'reports';
    $is_finance_path   = $workspace === 'finance';
    $is_module_path    = $workspace === 'module';

    $unread_messages = \App\Models\Conversation::whereUserType('admin')->whereHas('last_message', function ($q) {
        $q->whereColumn('conversations.sender_id', 'messages.sender_id');
    })->where('unread_message_count', '>', 0)->count();

    $safety_count = 0; $latest_safety = null;
    $ride_share_module_id = Helpers::ride_share_module_id() ?? 0;
    if (addon_published_status('RideShare')) {
        $safety_q = \Modules\RideShare\Entities\TripManagement\RideSafetyAlert::where('status', 'pending');
        $safety_count = $safety_q->count();
        $latest_safety = $safety_count > 0 ? $safety_q->latest()->first() : null;
    }

    $url_users    = Helpers::users_workspace_landing_url();
    $url_finance  = Helpers::finance_workspace_landing_url();
    $url_reports  = Helpers::reports_workspace_landing_url();
    $url_dispatch = route('admin.dispatch.dashboard');
    $url_settings = Helpers::settings_workspace_landing_url();
    $url_module   = route('admin.dashboard') . '?module_id=' . $current_module_id;
?>

<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

<script>
(function () {
    try {
        var saved = localStorage.getItem('v2_mode_v1');
        var isPos = /^\/?admin\/pos(\/|$)/.test(window.location.pathname);
        var mode = isPos ? 'compact' : (saved === 'compact' ? 'compact' : 'pinned');
        document.body.classList.remove('v2-mode-pinned', 'v2-mode-compact');
        document.body.classList.add('v2-mode-' + mode);
    } catch (e) {}
})();
</script>

<?php echo $__env->make('layouts.admin.partials._v2_tour', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<header class="v2-topbar" role="banner">
    <a class="v2-brand" href="<?php echo e(route('admin.dashboard')); ?>">
        <img class="v2-brand-mark" src="<?php echo e(\App\CentralLogics\Helpers::logoFullUrl()); ?>" alt="Logo" onerror="this.src='<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>'">
    </a>

    <button type="button" class="v2-mode-btn v2-mobile-toggle" id="v2-mobile-toggle" aria-label="<?php echo e(translate('Toggle navigation drawer')); ?>">
        <i data-lucide="menu"></i>
    </button>
    <?php if($layout_features['compact_mode_toggle'] ?? true): ?>
    <button type="button" class="v2-mode-btn v2-desktop-only" id="v2-mode-btn"
            title="<?php echo e(translate('Collapse sidebar')); ?>" aria-label="<?php echo e(translate('Collapse sidebar')); ?>"
            aria-controls="v2-panel" aria-pressed="false">
        <?php echo $__env->make('layouts.admin.partials._v2_mode_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </button>
    <?php endif; ?>

    <nav class="v2-topnav" id="v2-topnav" aria-label="<?php echo e(translate('Workspaces')); ?>">
        <?php if(Helpers::admin_can_access_workspace('module')): ?>
        <a class="v2-ws-tab v2-ws-tab--module <?php echo e($is_module_path ? 'is-active' : ''); ?>" href="<?php echo e($url_module); ?>">
            <i data-lucide="package" class="v2-ws-ico"></i>
            <span><?php echo e(translate('Module')); ?></span>
            <?php if($is_module_path && $current_module_name): ?>
                <span class="v2-module-pill">
                    <i data-lucide="layout-grid"></i><?php echo e($current_module_name); ?>

                </span>
            <?php endif; ?>
        </a>
        <?php endif; ?>
        <?php if(Helpers::admin_can_access_workspace('users')): ?>
        <a class="v2-ws-tab <?php echo e($is_users_path ? 'is-active' : ''); ?>" href="<?php echo e($url_users); ?>">
            <i data-lucide="users" class="v2-ws-ico"></i>
            <span><?php echo e(translate('Users')); ?></span>
        </a>
        <?php endif; ?>
        <?php if(Helpers::admin_can_access_workspace('finance')): ?>
        <a class="v2-ws-tab <?php echo e($is_finance_path ? 'is-active' : ''); ?>" href="<?php echo e($url_finance); ?>">
            <i data-lucide="wallet" class="v2-ws-ico"></i>
            <span><?php echo e(translate('Finance')); ?></span>
        </a>
        <?php endif; ?>
        <?php if(Helpers::admin_can_access_workspace('reports')): ?>
        <a class="v2-ws-tab <?php echo e($is_reports_path ? 'is-active' : ''); ?>" href="<?php echo e($url_reports); ?>">
            <i data-lucide="bar-chart-3" class="v2-ws-ico"></i>
            <span><?php echo e(translate('Reports')); ?></span>
        </a>
        <?php endif; ?>
        <?php if(Helpers::admin_can_access_workspace('dispatch')): ?>
        <a class="v2-ws-tab <?php echo e($is_dispatch_path ? 'is-active' : ''); ?>" href="<?php echo e($url_dispatch); ?>">
            <i data-lucide="route" class="v2-ws-ico"></i>
            <span><?php echo e(translate('dispatch')); ?></span>
        </a>
        <?php endif; ?>
        <?php if(Helpers::admin_can_access_workspace('settings')): ?>
        <a class="v2-ws-tab <?php echo e($is_settings_path ? 'is-active' : ''); ?>" href="<?php echo e($url_settings); ?>">
            <i data-lucide="settings-2" class="v2-ws-ico"></i>
            <span><?php echo e(translate('Settings')); ?></span>
        </a>
        <?php endif; ?>
    </nav>

    <div class="v2-topbar-spacer"></div>

    <button type="button" class="v2-topbar-search" data-toggle="modal" data-target="#staticBackdrop" aria-label="<?php echo e(translate('Search')); ?>">
        <i data-lucide="search"></i>
        <span class="v2-search-placeholder"><?php echo e(translate('Search by keyword')); ?></span>
        <kbd>Ctrl+K</kbd>
    </button>

    <div class="v2-topbar-actions">
        <button type="button" class="v2-icon-btn v2-mobile-only-search" data-toggle="modal" data-target="#staticBackdrop" aria-label="<?php echo e(translate('Search')); ?>">
            <i data-lucide="search"></i>
        </button>

        <?php if($lang): ?>
            <div class="v2-lang-wrap">
                <button type="button" class="v2-icon-btn" id="v2-lang-btn" aria-haspopup="menu" aria-expanded="false" aria-label="<?php echo e(translate('Language')); ?>">
                    <i data-lucide="globe"></i>
                </button>
                <div class="v2-lang-pop" id="v2-lang-pop" role="menu">
                    <div class="v2-lang-pop-head"><?php echo e(translate('Language')); ?></div>
                    <?php $__currentLoopData = $lang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(($data['status'] ?? 0) == 1): ?>
                            <a class="v2-lang-item <?php echo e(($data['code'] === $local) || (!$local && ($data['default'] ?? false) === true) ? 'is-active' : ''); ?>" href="<?php echo e(route('admin.lang', [$data['code']])); ?>">
                                <span class="v2-lang-code"><?php echo e(strtoupper($data['code'])); ?></span>
                                <span class="v2-lang-name"><?php echo e(ucfirst($data['name'] ?? $data['code'])); ?></span>
                                <i data-lucide="check" class="v2-lang-check"></i>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if(\App\CentralLogics\Helpers::module_permission_check('customer_management')): ?>
        <a href="<?php echo e(route('admin.message.list')); ?>" class="v2-icon-btn" aria-label="<?php echo e(translate('messages.message')); ?>">
            <i data-lucide="message-circle"></i>
            <?php if($unread_messages > 0): ?><span class="v2-badge"><?php echo e($unread_messages); ?></span><?php endif; ?>
        </a>
        <?php endif; ?>

        <?php if(addon_published_status('RideShare') && \App\CentralLogics\Helpers::module_permission_check('heat_map')): ?>
            <a id="v2-safety-link" href="<?php echo e(route('admin.ride-share.safety-alerts', ['module_id' => $ride_share_module_id])); ?>" class="v2-icon-btn <?php if($latest_safety): ?> safety-alert-header-icon <?php endif; ?>" <?php if($latest_safety): ?> data-user-id="<?php echo e($latest_safety->sent_by); ?>" <?php endif; ?> aria-label="<?php echo e(translate('Safety alerts')); ?>">
                <i data-lucide="shield-alert"></i>
                <?php if($safety_count > 0): ?><span class="v2-badge" id="v2-safety-badge"><?php echo e($safety_count); ?></span><?php endif; ?>
            </a>
        <?php endif; ?>

        <?php if($layout_features['fullscreen'] ?? true): ?>
        <button type="button" class="v2-icon-btn v2-desktop-only" id="v2-fs-btn" aria-label="<?php echo e(translate('Toggle fullscreen')); ?>" title="<?php echo e(translate('Toggle fullscreen')); ?> (F11)">
            <i data-lucide="maximize-2" id="v2-fs-icon"></i>
        </button>
        <?php endif; ?>
    </div>

    <button type="button" class="v2-module-switcher" id="v2-mod-switch" aria-haspopup="menu" aria-expanded="false">
        <span class="v2-mod-icon">
            <?php if($current_module_icon): ?>
                <img src="<?php echo e($current_module_icon); ?>" alt="" onerror="this.src='<?php echo e(asset('public/assets/admin/img/new-img/module-icon.svg')); ?>'">
            <?php else: ?>
                <i data-lucide="shopping-cart"></i>
            <?php endif; ?>
        </span>
        <span class="v2-mod-name"><?php echo e($current_module_name ?? translate('Modules')); ?></span>
        <i data-lucide="chevron-down" class="v2-chev"></i>
    </button>
    <div class="v2-modpop" id="v2-modpop" role="menu">
        <h4><?php echo e(translate('Modules section')); ?></h4>
        <p><?php echo e(translate('Select module & monitor your business module wise')); ?></p>
        <?php if($modules->count() > 0): ?>
            <div class="v2-mod-grid">
                <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php if(module_type_addon_active($module->module_type)): ?>
                        <a href="javascript:"
                           class="v2-mod-tile set-module <?php echo e($current_module_id == $module->id ? 'is-active' : ''); ?>"
                           data-module-id="<?php echo e($module->id); ?>"
                           data-url="<?php echo e($module->module_type === 'rental' && addon_published_status('Rental') ? route('admin.rental.dashboard') : route('admin.dashboard')); ?>"
                           data-filter="module_id">
                            <?php if(getEnvMode() == 'demo' && in_array($module->module_type, ['rental', 'ride-share'])): ?>
                                <span class="v2-mod-addon-tag"><?php echo e(translate('Addon')); ?></span>
                            <?php endif; ?>
                            <div class="v2-mod-tile-ico">
                                <img src="<?php echo e($module->icon_full_url); ?>" alt="" onerror="this.src='<?php echo e(asset('public/assets/admin/img/new-img/module/e-shop.svg')); ?>'">
                            </div>
                            <div><?php echo e($module->module_name); ?></div>
                        </a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if(Helpers::module_permission_check('module')): ?>
                    <a href="<?php echo e(route('admin.business-settings.module.create')); ?>" class="v2-mod-tile" title="<?php echo e(translate('Add new module')); ?>">
                        <div class="v2-mod-tile-ico"><i data-lucide="plus"></i></div>
                        <div><?php echo e(translate('Add')); ?></div>
                    </a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="v2-mod-empty">
                <p><?php echo e(translate('Please, enable or create module first')); ?></p>
                <a href="<?php echo e(route('admin.business-settings.module.index')); ?>" class="v2-mod-empty-btn"><?php echo e(translate('Module setup')); ?></a>
            </div>
        <?php endif; ?>
    </div>
</header>

<div class="v2-mobile-backdrop" id="v2-mobile-backdrop" aria-hidden="true"></div>

<?php $__env->startPush('script_2'); ?>
<script>
(function () {
    'use strict';

    function closePops() {
        document.querySelectorAll('.v2-modpop, .v2-lang-pop').forEach(function (p) { p.classList.remove('is-open'); });
        var ms = document.getElementById('v2-mod-switch');
        var lb = document.getElementById('v2-lang-btn');
        if (ms) ms.setAttribute('aria-expanded', 'false');
        if (lb) lb.setAttribute('aria-expanded', 'false');
    }

    function v2CloseDrawerIfOpen() {
        if (document.body.classList.contains('v2-drawer-open')) {
            document.body.classList.remove('v2-drawer-open');
        }
    }

    var modBtn = document.getElementById('v2-mod-switch');
    var modPop = document.getElementById('v2-modpop');
    if (modBtn && modPop) {
        modBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            v2CloseDrawerIfOpen();
            var isOpen = !modPop.classList.contains('is-open');
            closePops();
            if (isOpen) modPop.classList.add('is-open');
            modBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    }

    var langBtn = document.getElementById('v2-lang-btn');
    var langPop = document.getElementById('v2-lang-pop');
    if (langBtn && langPop) {
        langBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            v2CloseDrawerIfOpen();
            var isOpen = !langPop.classList.contains('is-open');
            closePops();
            if (isOpen) langPop.classList.add('is-open');
            langBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    }

    document.addEventListener('click', function (e) {
        if (e.target.closest('#v2-modpop, #v2-mod-switch, #v2-lang-pop, #v2-lang-btn')) return;
        closePops();
    });

    var MODE_KEY = 'v2_mode_v1';
    var MODE_ORDER = ['pinned', 'compact'];
    /* The button is labelled with what the next click does, not with the mode
       it is already in. The glyph animates between the two states on its own
       (.v2-mode-glyph in admin-v2.css), so nothing here touches the icon. */
    var MODE_LABEL = {
        pinned: '<?php echo e(translate('Collapse sidebar')); ?>',
        compact: '<?php echo e(translate('Expand sidebar')); ?>'
    };
    var modeBtn = document.getElementById('v2-mode-btn');
    var modeAnimTimer = null;

    /* The content edge is only allowed to animate for the length of a mode
       switch — see the .v2-mode-anim block in admin-v2.css for why it is not
       simply left on, and why the saved mode therefore lands instantly on
       page load instead of sliding in. */
    function armModeAnimation() {
        document.body.classList.add('v2-mode-anim');
        if (modeAnimTimer) clearTimeout(modeAnimTimer);
        modeAnimTimer = setTimeout(function () {
            document.body.classList.remove('v2-mode-anim');
            modeAnimTimer = null;
            /* Charts and datatables size themselves off the content width and
               only ever re-measure on resize, so tell them the edge settled. */
            var ev;
            try { ev = new Event('resize'); }
            catch (e) { ev = document.createEvent('Event'); ev.initEvent('resize', true, true); }
            window.dispatchEvent(ev);
        }, 380);
    }

    function applyMode(mode, persist) {
        if (MODE_ORDER.indexOf(mode) === -1) mode = 'pinned';
        document.body.classList.remove('v2-mode-pinned', 'v2-mode-compact');
        document.body.classList.add('v2-mode-' + mode);
        if (modeBtn) {
            modeBtn.setAttribute('title', MODE_LABEL[mode]);
            modeBtn.setAttribute('aria-label', MODE_LABEL[mode]);
            modeBtn.setAttribute('aria-pressed', mode === 'compact' ? 'true' : 'false');
        }
        if (persist !== false) {
            try { localStorage.setItem(MODE_KEY, mode); } catch (e) {}
        }
    }

    var isPosPage = /^\/?admin\/pos(\/|$)/.test(window.location.pathname);
    if (isPosPage) {
        applyMode('compact', false);
    } else {
        var savedMode;
        try { savedMode = localStorage.getItem(MODE_KEY); } catch (e) { savedMode = null; }
        applyMode(savedMode || 'pinned', false);
    }

    document.addEventListener('click', function (e) {
        if (!e.target.closest || !e.target.closest('#v2-mode-btn')) return;
        var current = document.body.classList.contains('v2-mode-compact') ? 'compact' : 'pinned';
        var next = MODE_ORDER[(MODE_ORDER.indexOf(current) + 1) % MODE_ORDER.length];
        armModeAnimation();
        applyMode(next, !isPosPage);
    });

    function v2IsFullscreen() {
        return !!(document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement);
    }
    function v2ToggleFullscreen() {
        if (!v2IsFullscreen()) {
            var el = document.documentElement;
            var req = el.requestFullscreen || el.webkitRequestFullscreen || el.mozRequestFullScreen || el.msRequestFullscreen;
            if (req) req.call(el);
        } else {
            var exit = document.exitFullscreen || document.webkitExitFullscreen || document.mozCancelFullScreen || document.msExitFullscreen;
            if (exit) exit.call(document);
        }
    }
    function v2SyncFullscreenIcon() {
        var ic = document.getElementById('v2-fs-icon');
        var btn = document.getElementById('v2-fs-btn');
        if (!ic || !btn) return;
        var fs = v2IsFullscreen();
        ic.outerHTML = '<i data-lucide="' + (fs ? 'minimize-2' : 'maximize-2') + '" id="v2-fs-icon"></i>';
        btn.setAttribute('title', fs ? '<?php echo e(translate('Exit fullscreen')); ?>' : '<?php echo e(translate('Toggle fullscreen')); ?> (F11)');
        if (window.lucide && typeof window.lucide.createIcons === 'function') window.lucide.createIcons();
    }
    var fsBtn = document.getElementById('v2-fs-btn');
    if (fsBtn) fsBtn.addEventListener('click', v2ToggleFullscreen);
    ['fullscreenchange', 'webkitfullscreenchange', 'mozfullscreenchange', 'msfullscreenchange'].forEach(function (ev) {
        document.addEventListener(ev, v2SyncFullscreenIcon);
    });

    var mobileToggle = document.getElementById('v2-mobile-toggle');
    var backdrop = document.getElementById('v2-mobile-backdrop');
    function setDrawer(open) {
        document.body.classList.toggle('v2-drawer-open', !!open);
    }
    function isDrawerOpen() {
        return document.body.classList.contains('v2-drawer-open');
    }
    if (mobileToggle) mobileToggle.addEventListener('click', function () {
        setDrawer(!isDrawerOpen());
    });
    if (backdrop) backdrop.addEventListener('click', function () { setDrawer(false); });

    var DRAWER_CLOSE_TRIGGERS = [
        '.v2-topbar-search',
        '.v2-mobile-only-search',
        '#v2-mod-switch',
        '#v2-lang-btn',
        '.v2-topbar-actions a.v2-icon-btn'
    ].join(',');
    document.addEventListener('click', function (e) {
        if (!isDrawerOpen()) return;
        if (e.target.closest(DRAWER_CLOSE_TRIGGERS)) {
            setDrawer(false);
        }
    });

    document.addEventListener('click', function (e) {
        if (!isDrawerOpen()) return;
        var navLink = e.target.closest('#v2-panel a[href]');
        if (navLink) setDrawer(false);
    });

    if (window.jQuery) {
        window.jQuery(document).on('show.bs.modal show.bs.offcanvas', function () {
            if (isDrawerOpen()) setDrawer(false);
        });
    } else {
        document.addEventListener('show.bs.modal', function () { if (isDrawerOpen()) setDrawer(false); }, true);
        document.addEventListener('show.bs.offcanvas', function () { if (isDrawerOpen()) setDrawer(false); }, true);
    }

    var modpopForDelegate = document.getElementById('v2-modpop');
    if (modpopForDelegate) {
        modpopForDelegate.addEventListener('click', function (e) {
            var tile = e.target.closest('a.set-module[data-url][data-module-id]');
            if (!tile) return;
            e.preventDefault();
            setDrawer(false);
            try {
                var url = new URL(tile.getAttribute('data-url'), window.location.href);
                var filterBy = tile.getAttribute('data-filter') || 'module_id';
                url.searchParams.set(filterBy, tile.getAttribute('data-module-id'));
                window.location.href = url.toString();
            } catch (err) {}
        });
    }


    if (window.lucide && typeof window.lucide.createIcons === 'function') {
        window.lucide.createIcons();
    }
})();
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/foodcol2/portal.foodcollections.com/resources/views/layouts/admin/partials/_header_v2.blade.php ENDPATH**/ ?>