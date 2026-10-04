<!DOCTYPE html>
<?php

$country = \App\CentralLogics\Helpers::get_business_settings('country');
$countryCode = strtolower($country ? $country : 'auto');
?>
<html dir="<?php echo e(session()->get('site_direction')); ?>" lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
    class="<?php echo e(session()->get('site_direction') === 'rtl' ? 'active' : ''); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" id="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <?php if(!isset($module_type)): ?>
    <?php $module_type = Config::get('module.current_module_type'); ?>
    <?php endif; ?>
    <?php
        $layout_version  = config('layout.version', 'auto');
        $layout_features = config('layout.features', []);
        $use_v2_chrome   = match ($layout_version) {
            'v1'    => false,
            'v2'    => true,
            default => in_array($module_type, config('layout.v2_modules', []), true),
        };
        $ride_share_module_id = \App\CentralLogics\Helpers::ride_share_module_id();
        $fcm_credentials = \App\CentralLogics\Helpers::get_business_settings('fcm_credentials');
        $fcm_enabled = ! empty($fcm_credentials['apiKey'])
            && ! empty($fcm_credentials['projectId'])
            && ! empty($fcm_credentials['messagingSenderId'])
            && ! empty($fcm_credentials['appId']);
    ?>
    <link rel="icon" type="image/x-icon"
        href="<?php echo e(\App\CentralLogics\Helpers::iconFullUrl()); ?>">
    <link rel="preload" as="font" type="font/woff2" crossorigin
        href="<?php echo e(asset('public/assets/admin/vendor/icon-set/fonts/The-Icon-of9a76.woff2')); ?>?ww946b">
    <link href="<?php echo e(asset('public/assets/admin/css/fonts.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/vendor.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/vendor/icon-set/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/custom.css')); ?>?v=1.1">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/owl.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/theme.minc619.css?v=1.0')); ?>">
    <?php if(!$use_v2_chrome): ?>
        <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/bootstrap-tour-standalone.min.css')); ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/emogi-area.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/app-toast.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/intltelinput/css/intlTelInput.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/upload-single-image.css')); ?>">
    <?php if(addon_published_status('RideShare') && in_array($module_type, ['ride-share', 'settings', 'transactions'])): ?>
        <link rel="stylesheet" href="<?php echo e(asset('Modules/RideShare/public/assets/css/ride-share.css')); ?>">
    <?php endif; ?>
    <?php if(addon_published_status('Service') && $module_type == 'service'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('Modules/Service/public/assets/css/service.css')); ?>">
    <?php endif; ?>
    <?php if(addon_published_status('ReelsModule')): ?>
        <link rel="stylesheet" href="<?php echo e(asset('Modules/ReelsModule/public/assets/css/reels.css')); ?>">
    <?php endif; ?>
    <?php if($use_v2_chrome): ?>
        <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/admin-v2.css')); ?>">
    <?php endif; ?>
    
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/global-search.css')); ?>">
    
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/new-order-alert.css')); ?>">
    
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/admin-tabs.css')); ?>">
    
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/admin-tables.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/ajax-framework.css')); ?>">
    
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/filter-drawer.css')); ?>">
    
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/button-icons.css')); ?>">
    
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/breadcrumb.css')); ?>">
    
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/page-head.css')); ?>">
    
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/form-controls.css')); ?>">
    
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/buttons.css')); ?>">
    <?php echo $__env->yieldPushContent('css_or_js'); ?>

    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/toastr.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/page-transition.css')); ?>">
</head>

<body class="footer-offset <?php echo e(($use_v2_chrome ?? false) ? 'v2-chrome' : ''); ?><?php echo e(($use_v2_chrome && ($layout_features['pin'] ?? true) === false) ? ' layout-no-pin' : ''); ?>">
    <script>
        (function () {
            if (window.localStorage.getItem('hs-navbar-vertical-aside-mini')) {
                document.body.classList.add('navbar-vertical-aside-mini-mode');
            }
        })();
    </script>


    <div id="page-progress-bar"></div>

    <?php
        $v2_current_module_id_for_url = config('module.current_module_id');
    ?>
    <?php if(!empty($v2_current_module_id_for_url)): ?>
    <script>
    (function () {
        try {
            var mid = "<?php echo e($v2_current_module_id_for_url); ?>";
            if (!mid) return;
            var url = new URL(window.location.href);
            if (url.searchParams.get('module_id') !== mid) {
                url.searchParams.set('module_id', mid);
                history.replaceState(history.state, '', url.toString());
            }

            window.addEventListener('pageshow', function (e) {
                if (e.persisted) {
                    var u = new URL(window.location.href);
                    if (u.searchParams.has('module_id')) {
                        window.location.reload();
                    }
                }
            });
        } catch (e) {}
    })();
    </script>
    <?php endif; ?>

    <?php if(getEnvMode() == 'demo'): ?>
        <div class="direction-toggle">
            <i class="tio-settings"></i>
            <span></span>
        </div>
    <?php endif; ?>

    <div id="app-toast-container" class="app-toast-container"></div>

    
    <div id="loading" class="initial-hidden" role="status" aria-live="polite">
        <div class="loader--inner">
            <span class="app-loader__spinner" aria-hidden="true"></span>
            <span class="sr-only"><?php echo e(translate('messages.loading')); ?></span>
        </div>
    </div>
    <?php if(!isset($module_type)): ?>
    <?php $module_type = Config::get('module.current_module_type'); ?>
    <?php endif; ?>

    <?php echo $__env->make('layouts.admin.partials._header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php if($use_v2_chrome ?? false): ?>
        <?php echo $__env->make('layouts.admin.partials._header_v2', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    <?php if(Request::is('admin/payment/configuration*') || Request::is('admin/sms/configuration*') || Request::is('taxvat/*') || Request::is('admin/pro-customer*')): ?>
        <?php $module_type = 'settings'; ?>
    <?php endif; ?>

    <?php if($use_v2_chrome ?? false): ?>
        <div id="sidebarMain" class="d-none"></div>
        <div id="sidebarCompact" class="d-none"></div>
        <?php if($module_type === 'users'): ?>
            <?php echo $__env->make('layouts.admin.partials._sidebar_v2_users', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif($module_type === 'transactions'): ?>
            <?php
                $req_path_for_dispatch = request()->path();
                $is_tax_url = \Illuminate\Support\Str::is('admin/transactions/report/*tax*', $req_path_for_dispatch)
                    || \Illuminate\Support\Str::is('admin/transactions/rental/report/*tax*', $req_path_for_dispatch)
                    || \Illuminate\Support\Str::is('admin/transactions/service/report/*tax*', $req_path_for_dispatch)
                    || \Illuminate\Support\Str::is('admin/transactions/ride-share/report/*tax*', $req_path_for_dispatch);
                $is_reports_url = !$is_tax_url && (
                    \Illuminate\Support\Str::is('admin/transactions/report/*', $req_path_for_dispatch)
                    || \Illuminate\Support\Str::is('admin/transactions/rental/report/*', $req_path_for_dispatch)
                    || \Illuminate\Support\Str::is('admin/transactions/service/report/*', $req_path_for_dispatch)
                    || \Illuminate\Support\Str::is('admin/transactions/ride-share/*', $req_path_for_dispatch)
                );
            ?>
            <?php if($is_reports_url): ?>
                <?php echo $__env->make('layouts.admin.partials._sidebar_v2_reports', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php else: ?>
                <?php echo $__env->make('layouts.admin.partials._sidebar_v2_finance', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>
        <?php elseif($module_type === 'dispatch'): ?>
            <?php echo $__env->make('layouts.admin.partials._sidebar_v2_dispatch', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif($module_type === 'settings'): ?>
            <?php echo $__env->make('layouts.admin.partials._sidebar_v2_settings', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif($module_type === 'rental'): ?>
            <?php echo $__env->make('rental::admin.partials._sidebar_v2_rental', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif($module_type === 'ride-share'): ?>
            <?php echo $__env->make('ride-share::admin.partials._sidebar_v2_ride-share', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif($module_type === 'service'): ?>
            <?php echo $__env->make('service::admin.partials._sidebar_v2_service', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php else: ?>
            <?php echo $__env->make('layouts.admin.partials._sidebar_v2', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>
    <?php else: ?>
        <?php if($module_type === 'rental'): ?>
            <?php echo $__env->make('rental::admin.partials._sidebar_rental', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif($module_type === 'ride-share'): ?>
            <?php echo $__env->make('ride-share::admin.partials._sidebar_ride-share', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif($module_type === 'service'): ?>
            <?php echo $__env->make('service::admin.partials._sidebar_service', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php else: ?>
            <?php echo $__env->make("layouts.admin.partials._sidebar_{$module_type}", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>
    <?php endif; ?>


    <main id="content" role="main" class="main pointer-event">
        
        <?php echo $__env->make('partials._breadcrumb', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php echo $__env->yieldContent('content'); ?>

        <?php echo $__env->make('layouts.admin.partials._footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="d-none" id="text-validate-translate" data-required="<?php echo e(translate('This field is required.')); ?>"
            data-something-went-wrong="<?php echo e(translate('Something went wrong')); ?>"
            data-max-limit-crossed="<?php echo e(translate('Max limit crossed')); ?>"
            data-file-size-larger="<?php echo e(translate('File size is larger')); ?>"
            data-passwords-do-not-match="<?php echo e(translate('Passwords do not match')); ?>"
            data-valid-email="<?php echo e(translate('Please enter a valid email')); ?>"
            data-password-validation="<?php echo e(translate('Use at least one uppercase letter, one lowercase letter, one number and one symbol.')); ?> <?php echo e(translate('Minimum characters')); ?>: 8">
        </div>

        
        <div class="modal fade noa-modal" id="popup-modal" tabindex="-1" role="dialog"
            aria-labelledby="popup-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered noa-dialog" role="document">
                <div class="modal-content noa">
                    <button type="button" class="noa-close" data-dismiss="modal"
                        aria-label="<?php echo e(translate('Close')); ?>">
                        <i class="tio-clear" aria-hidden="true"></i>
                    </button>
                    <div class="modal-body noa-body">
                        <div class="noa-icon" aria-hidden="true">
                            <span class="noa-ping"></span>
                            <span class="noa-ping noa-ping--slow"></span>
                            <span class="noa-icon-core"><i class="tio-shopping-cart-outlined"></i></span>
                        </div>
                        <span class="noa-eyebrow"><?php echo e(translate('New notification')); ?></span>
                        <h2 class="noa-title update_notification_text" id="popup-modal-title">
                            <?php echo e(translate('You have new order, check please.')); ?>

                        </h2>
                        <p class="noa-text">
                            <?php echo e(translate('messages.Review the details and take action right away.')); ?>

                        </p>
                        <button type="button" class="btn noa-btn check-order">
                            <?php echo e(translate('Ok, let me check')); ?>

                            <i class="tio-chevron-right noa-btn-arrow" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $__env->make('layouts.partials._video-preview-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="modal fade" id="toggle-modal">
            <div class="modal-dialog modal-dialog-centered status-warning-modal">
                <div class="modal-content">
                    <div class="modal-header px-2 pt-2">
                        <button type="button" class="close btn btn--reset btn-circle" data-dismiss="modal">
                            <span aria-hidden="true" class="tio-clear fs-20 opacity-70"></span>
                        </button>
                    </div>
                    <div class="modal-body pb-4">
                        <div class="max-349 mx-auto mb-20 mt-2">
                            <div class="mb-30">
                                <div class="text-center mb-1">
                                    <img id="toggle-image" alt="" class="mb-20 initial--10">
                                    <h3 class="modal-title" id="toggle-title"></h3>
                                </div>
                                <div class="text-center fs-14" id="toggle-message">
                                </div>
                            </div>
                            <div class="btn--container justify-content-center">
                                <button id="reset_btn" type="reset" class="btn btn--reset min-w-120"
                                    data-dismiss="modal">
                                    <i class="tio-clear-circle-outlined"></i> <?php echo e(translate("No")); ?>

                                </button>
                                <button type="button" id="toggle-ok-button"
                                    class="btn btn--primary min-w-120 confirm-Toggle"
                                    data-dismiss="modal"><i class="tio-checkmark-circle-outlined"></i> <?php echo e(translate('Yes')); ?></button>
                            </div>
                            <div class="text-center mt-3" id="toggle-footer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="modal fade" id="toggle-status-modal">
            <div class="modal-dialog status-warning-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true" class="tio-clear"></span>
                        </button>
                    </div>
                    <div class="modal-body pb-5 pt-0">
                        <div class="max-349 mx-auto mb-20">
                            <div class="text-center">
                                <img id="toggle-status-image" alt="" class="mb-20">
                                <h5 class="modal-title mb-3" id="toggle-status-title"></h5>
                            </div>
                            <div class="text-center" id="toggle-status-message">
                            </div>
                            <div class="btn--container justify-content-center">
                                <button id="reset_btn" type="reset" class="btn btn--reset min-w-120px"
                                    data-dismiss="modal">
                                    <i class="tio-clear-circle-outlined"></i> <?php echo e(translate("No")); ?>

                                </button>
                                <button type="button" id="toggle-status-ok-button"
                                    class="btn btn--primary min-w-120 confirm-Status-Toggle"
                                    data-dismiss="modal"><i class="tio-checkmark-circle-outlined"></i> <?php echo e(translate('Yes')); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="instruction-modal">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close instruction-Modal-Close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/0sus46BflpU"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="email-modal">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close email-Modal-Close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/_BIHsClZtOE"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="new-dynamic-submit-model">
            <div class="modal-dialog modal-dialog-centered modal-dialog-centered status-warning-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true" class="tio-clear"></span>
                        </button>
                    </div>
                    <div class="modal-body pb-5 pt-0">
                        <div class="max-349 mx-auto mb-20">
                            <div>
                                <div class="text-center">
                                    <img id="image-src" class="mb-20">
                                    <h5 class="modal-title" id="toggle-title"></h5>
                                </div>
                                <div class="text-center" id="toggle-message">
                                    <h3 id="modal-title"></h3>
                                    <div id="modal-text"></div>
                                </div>

                            </div>
                            <div class="mb-4 d-none" id="note-data">
                                <textarea class="form-control" placeholder="<?php echo e(translate('Enter a note')); ?>"
                                    id="get-text-note" cols="5"></textarea>
                            </div>
                            <div class="btn--container justify-content-center">
                                <div id="hide-buttons">
                                    <div class="d-flex justify-content-center flex-wrap gap-3">
                                        <button data-dismiss="modal" id="cancel6_btn_text"
                                            class="btn btn--cancel min-w-120"><i class="tio-time"></i> <?php echo e(translate('Not now')); ?></button>
                                        <button type="button" id="new-dynamic-ok-button"
                                            class="btn btn-primary confirm-model min-w-120"><i class="tio-checkmark-circle-outlined"></i> <?php echo e(translate('Yes')); ?></button>
                                    </div>
                                </div>

                                <button data-dismiss="modal" type="button" id="new-dynamic-ok-button-show"
                                    class="btn btn--primary  d-none min-w-120"><i class="tio-checkmark-circle-outlined"></i> <?php echo e(translate('Okay')); ?></button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="safetyAlertNotificationModal" aria-modal="true" role="dialog">
            <div class="modal-dialog status-warning-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true" class="tio-clear"></span>
                        </button>
                    </div>
                    <div class="modal-body pb-5 pt-0">
                        <div class="max-349 mx-auto">
                            <div>
                                <div class="text-center">
                                    <img alt="" class="mb-4" id="deleteIcon"
                                        src="<?php echo e(asset('Modules/RideShare/public/assets/img/ride-share/safety-alert-shield-icon-red.png')); ?>">
                                    <h5 class="modal-title mb-3" id="safetyAlertNotificationTitle"></h5>
                                </div>
                                <div class="text-center mb-4 pb-2">
                                    <p id="safetyAlertNotificationSubtitle"></p>
                                </div>
                            </div>
                            <div class="btn--container justify-content-center mt-3">
                                <button id="checkLater"
                                    class="btn btn--cancel min-w-120 fs-14 fw-semibold"><i class="tio-time"></i> <?php echo e(translate('Check later')); ?></button>
                                <a href=""
                                    class="show-safety-alert-user-details btn btn-primary min-w-120 confirm-Toggle fs-14 fw-semibold"
                                    data-user-id="">
                                    <i class="tio-visible-outlined"></i> <?php echo e(translate('View alert')); ?>

                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="imageModal" class="imageModal modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header justify-content-end gap-3 border-0 p-2">
                        <button type="button"
                            class="modal_img-btn border-0 btn-circle rounded-circle bg-section2 shadow-none fs-8 m-0"
                            data-dismiss="modal" aria-label="Close">
                            <i class="tio-clear"></i>
                        </button>
                    </div>
                    <div class="modal-body text-center p-3 pt-0">
                        <div class="imageModal_img_wrapper">
                            <img src="" class="img-fluid imageModal_img" alt="<?php echo e(translate('Preview image')); ?>">
                            <div class="imageModal_btn_wrapper m-1">
                                <a href="javascript:" class="btn icon-btn px-1 py-1 download_btn"
                                    title="<?php echo e(translate('Download')); ?>" download>
                                    <i class="tio-arrow-large-downward"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-none" id="default-text-data"
            data-default-image-src="<?php echo e(asset('public/assets/admin/img/upload-img.png')); ?>"></div>



        <?php
$current_module_type_for_search = null;
if (in_array(config('module.current_module_type'), config('module.module_type'))) {
    $current_module_type_for_search = config('module.current_module_type');
}
?>



        <script src="<?php echo e(asset('public/assets/admin')); ?>/js/custom.js"></script>
        <?php if($fcm_enabled): ?>
            <script src="<?php echo e(asset('public/assets/admin')); ?>/js/firebase.min.js"></script>
        <?php endif; ?>

        <?php echo $__env->yieldPushContent('script'); ?>


        <script src="<?php echo e(asset('public/assets/admin')); ?>/js/vendor.min.js"></script>
        <script src="<?php echo e(asset('public/assets/admin')); ?>/js/jquery.validate.min.js"></script>
        <script src="<?php echo e(asset('public/assets/admin')); ?>/js/theme.min.js"></script>
        <script src="<?php echo e(asset('public/assets/admin')); ?>/js/verified-select2.js"></script>
        <script src="<?php echo e(asset('public/assets/admin')); ?>/js/sweet_alert.js"></script>
        <?php if(!$use_v2_chrome): ?>
            <script src="<?php echo e(asset('public/assets/admin')); ?>/js/bootstrap-tour-standalone.min.js"></script>
        <?php endif; ?>
        <script src="<?php echo e(asset('public/assets/admin/js/owl.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/assets/admin')); ?>/js/emogi-area.js"></script>
        <script>
            window.APP_TOAST_I18N = {
                success: "<?php echo e(translate('messages.success')); ?>",
                info: "<?php echo e(translate('messages.Information')); ?>",
                warning: "<?php echo e(translate('messages.warning')); ?>",
                danger: "<?php echo e(translate('messages.error')); ?>",
                close: "<?php echo e(translate('messages.Close')); ?>"
            };
        </script>
        <script src="<?php echo e(asset('public/assets/admin')); ?>/js/toastr.js"></script>
        <script src="<?php echo e(asset('public/assets/admin/js/app-toast.js')); ?>"></script>
        <script src="<?php echo e(asset('public/assets/admin/js/app-blade/admin.js')); ?>"></script>
        <script src="<?php echo e(asset('public/assets/admin/js/form-validate.js')); ?>"></script>
        <script src="<?php echo e(asset('public/assets/admin/js/field-error-toast.js')); ?>"></script>
        <script src="<?php echo e(asset('public/assets/admin/js/upload-single-image.js')); ?>"></script>
        <script src="<?php echo e(asset('public/assets/admin/js/multiple-file-upload.js')); ?>"></script>
        <script src="<?php echo e(asset('public/assets/admin/intltelinput/js/intlTelInput.min.js')); ?>"></script>
        <?php if(addon_published_status('RideShare') && in_array($module_type, ['ride-share', 'settings', 'transactions'])): ?>
            <script src="<?php echo e(asset('Modules/RideShare/public/assets/js/ride-share.js')); ?>"></script>
        <?php endif; ?>

        <?php echo Toastr::message(); ?>


        <?php if($errors->any()): ?>
            <script>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    toastr.error('<?php echo e(translate($error)); ?>');
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </script>
        <?php endif; ?>


        <?php echo $__env->yieldPushContent('script_2'); ?>
        <script>
            let baseUrl = '<?php echo e(url('/')); ?>';
        </script>

        <script src="<?php echo e(asset('public/assets/admin/js/view-pages/common.js')); ?>"></script>
        <?php echo $__env->make('partials._status-toggle-lang', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        
        <script src="<?php echo e(asset('public/assets/admin/js/status-toggle.js')); ?>"></script>
        
        <?php echo $__env->make('partials._priority-select-lang', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <script src="<?php echo e(asset('public/assets/admin/js/priority-select.js')); ?>"></script>
        <?php echo $__env->make('partials._ajax-framework-lang', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <script src="<?php echo e(asset('public/assets/admin/js/ajax-framework.js')); ?>"></script>
        
        <script src="<?php echo e(asset('public/assets/admin/js/filter-drawer.js')); ?>"></script>
        
        <script src="<?php echo e(asset('public/assets/admin/js/breadcrumb.js')); ?>"></script>
        
        <script src="<?php echo e(asset('public/assets/admin/js/tab-scroller.js')); ?>"></script>
        <script src="<?php echo e(asset('public/assets/admin/js/keyword-highlighted.js')); ?>"></script>
        <script src="<?php echo e(asset('public/assets/admin/js/global-search.js')); ?>"></script>
        <script src="<?php echo e(asset('public/assets/admin/js/page-transition.js')); ?>"></script>
        <?php if(addon_published_status('ReelsModule') && request()->routeIs('admin.reels.create', 'admin.reels.edit')): ?>
            <script src="<?php echo e(asset('Modules/ReelsModule/public/assets/js/reel-upload.js')); ?>"></script>
        <?php endif; ?>
        <audio id="myAudio">
            <source src="<?php echo e(asset('public/assets/admin/sound/notification.mp3')); ?>" type="audio/mpeg">
        </audio>
        <audio id="safetyAlertAudio">
            <source src="<?php echo e(asset('public/assets/admin/sound/safety-alert.mp3')); ?>" type="audio/mpeg">
        </audio>
        <script>
            var audio = document.getElementById("myAudio");
            var isPlaying = false;
            function playAudio() {
                audio.play();
            }

            function pauseAudio() {
                audio.pause();
            }

            var safetyAlertAudio = document.getElementById("safetyAlertAudio");
            function playSafetyAlertAudio() {
                safetyAlertAudio.play();
                isPlaying = true;
            }
            function pauseSafetyAlertAudio() {
                safetyAlertAudio.pause();
                isPlaying = false;
                safetyAlertAudio.currentTime = 0; // Reset to the start
            }
            "use strict";


            <?php $hasModules = \App\Models\Module::Active()->exists(); ?>

            <?php if(!$hasModules): ?>
                $('#instruction-modal').show();
            <?php endif; ?>

            $('.restart-Tour').on('click', function () {
                // v2 chrome has its own driver.js-based tour; legacy uses bootstrap-tour.
                if (document.body.classList.contains('v2-chrome') && typeof window.startV2Tour === 'function') {
                    window.startV2Tour({ restart: true });
                    return;
                }
                <?php if($hasModules): ?>
                    if (tour) {
                        tour.restart();
                        $('body').css('overflow', 'hidden')
                    }
                <?php endif; ?>
    });



            function route_alert(route, message, title = "<?php echo e(translate('messages.Are you sure?')); ?>") {
                Swal.fire({
                    title: title,
                    text: message,
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: 'default',
                    confirmButtonColor: '#FC6A57',
                    cancelButtonText: '<?php echo e(translate('messages.No')); ?>',
                    confirmButtonText: '<?php echo e(translate('messages.Yes')); ?>',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        location.href = route;
                    }
                })
            }

            $(document).on('click', '.form-alert', function () {
                let id = $(this).data('id');
                let title = $(this).data('title');
                let message = $(this).data('message');
                let image = $(this).data('image-url');
                let cancel = $(this).data('cancel-btn');
                let confirm = $(this).data('confirm-btn');

                if (!title || title === "") {
                    title = '<?php echo e(translate('messages.Are you sure?')); ?>';
                }
                if (!cancel || cancel === "") {
                    cancel = '<?php echo e(translate('messages.No')); ?>';
                }
                if (!confirm || confirm === "") {
                    confirm = '<?php echo e(translate('messages.Yes')); ?>';
                }
                if (!image || image === "") {
                    image = "<?php echo e(asset('public/assets/admin/img/off-danger.png')); ?>";
                }

                Swal.fire({
                    title: title,
                    imageUrl: image,
                    imageWidth: 80,
                    imageHeight: 80,
                    imageAlt: 'Custom icon',
                    text: message,
                    showCancelButton: true,
                    cancelButtonColor: 'default',
                    confirmButtonColor: '#FC6A57',
                    cancelButtonText: cancel,
                    confirmButtonText: confirm,
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        $('#' + id).submit();
                    }
                });
            });

            $('.canceled-status').on('click', function () {
                let route = $(this).data('url');
                let message = $(this).data('message');
                let processing = $(this).data('processing') ?? false;
                cancelled_status(route, message, processing);
            })

            function cancelled_status(route, message, processing = false) {
                Swal.fire({
                    //text: message,
                    title: '<?php echo e(translate('messages.Are you sure?')); ?>',
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: 'default',
                    confirmButtonColor: '#FC6A57',
                    cancelButtonText: '<?php echo e(translate('messages.Cancel')); ?>',
                    confirmButtonText: '<?php echo e(translate('messages.Submit')); ?>',
                    inputPlaceholder: "<?php echo e(translate('Enter a reason')); ?>",
                    input: 'text',
                    html: message + '<br/>' + '<label><?php echo e(translate('Enter a reason')); ?></label>',
                    inputValue: processing,
                    preConfirm: (note) => {
                        location.href = route + '&note=' + encodeURIComponent(note ?? '');
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                })
            }

            function set_mail_filter(url, id, filter_by) {
                Swal.fire({
                    title: '<?php echo e(translate('messages.Are you sure?')); ?>',
                    text: 'Please save changes before switching template',
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: 'default',
                    confirmButtonColor: '#FC6A57',
                    cancelButtonText: '<?php echo e(translate('messages.No')); ?>',
                    confirmButtonText: '<?php echo e(translate('messages.Yes')); ?>',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        let nurl = new URL(url);
                        nurl.searchParams.set(filter_by, id);
                        location.href = nurl;
                    }
                })
            }


            function copy_text(copyText) {
                navigator.clipboard.writeText(copyText);
                toastr.success('<?php echo e(translate('messages.Text copied')); ?>', {
                    CloseButton: true,
                    ProgressBar: true
                });
            }

            $(document).on('ready', function () {
                $(".direction-toggle").on("click", function () {
                    if ($('html').hasClass('active')) {
                        $('html').removeClass('active')
                        setDirection(1);
                    } else {
                        setDirection(0);
                        $('html').addClass('active')
                    }
                });

                if ($('html').attr('dir') === "rtl") {
                    $(".direction-toggle").find('span').text('Toggle LTR')
                } else {
                    $(".direction-toggle").find('span').text('Toggle RTL')
                }

                function setDirection(status) {
                    if (status === 1) {
                        $("html").attr('dir', 'ltr');
                        $(".direction-toggle").find('span').text('Toggle RTL')
                    } else {
                        $("html").attr('dir', 'rtl');
                        $(".direction-toggle").find('span').text('Toggle LTR')
                    }
                    $.get({
                        url: '<?php echo e(route('admin.business-settings.site_direction')); ?>',
                        dataType: 'json',
                        data: {
                            status: status,
                        },
                        success: function () {
                            alert(ok);
                        },

                    });
                }
            });

            <?php if($fcm_enabled): ?>
            let firebaseConfig = {
                apiKey: "<?php echo e(isset($fcm_credentials['apiKey']) ? $fcm_credentials['apiKey'] : ''); ?>",
                authDomain: "<?php echo e(isset($fcm_credentials['authDomain']) ? $fcm_credentials['authDomain'] : ''); ?>",
                projectId: "<?php echo e(isset($fcm_credentials['projectId']) ? $fcm_credentials['projectId'] : ''); ?>",
                storageBucket: "<?php echo e(isset($fcm_credentials['storageBucket']) ? $fcm_credentials['storageBucket'] : ''); ?>",
                messagingSenderId: "<?php echo e(isset($fcm_credentials['messagingSenderId']) ? $fcm_credentials['messagingSenderId'] : ''); ?>",
                appId: "<?php echo e(isset($fcm_credentials['appId']) ? $fcm_credentials['appId'] : ''); ?>",
                measurementId: "<?php echo e(isset($fcm_credentials['measurementId']) ? $fcm_credentials['measurementId'] : ''); ?>"
            };
            firebase.initializeApp(firebaseConfig);
            const messaging = firebase.messaging();

            function startFCM() {
                messaging
                    .requestPermission()
                    .then(function () {
                        return messaging.getToken();
                    })
                    .then(function (token) {
                        // console.log('FCM Token:', token);
                        // Send the token to your backend to subscribe to topic
                        subscribeTokenToBackend(token, 'admin_message');
                        <?php if(addon_published_status('RideShare')): ?>
                            subscribeTokenToBackend(token, 'admin_safety_alert_notification');
                        <?php endif; ?>
            }).catch(function (error) {
                            console.error('Error getting permission or token:', error);
                        });
            }
            <?php endif; ?>

            // FCM topic subscriptions are persistent on Google's side, so re-sending an
            // unchanged token on every page load just burns two Google API round trips
            // per request. Re-assert weekly to cover token rotation.
            const FCM_SUB_TTL = 7 * 24 * 60 * 60 * 1000;

            function fcmAlreadySubscribed(token, topic) {
                try {
                    let cached = JSON.parse(localStorage.getItem(`fcm_sub_${topic}`) || 'null');
                    return cached && cached.token === token && (Date.now() - cached.at) < FCM_SUB_TTL;
                } catch (e) {
                    return false;
                }
            }

            function subscribeTokenToBackend(token, topic) {
                if (fcmAlreadySubscribed(token, topic)) {
                    return;
                }
                fetch('<?php echo e(url('/')); ?>/subscribeToTopic', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({ token: token, topic: topic })
                }).then(response => {
                    if (response.status < 200 || response.status >= 400) {
                        return response.text().then(text => {
                            throw new Error(`Error subscribing to topic: ${response.status} - ${text}`);
                        });
                    }
                    try {
                        localStorage.setItem(`fcm_sub_${topic}`, JSON.stringify({ token: token, at: Date.now() }));
                    } catch (e) {}
                }).catch(error => {
                    console.error('Subscription error:', error);
                });
            }



            function conversationList() {
                $.ajax({
                    url: "<?php echo e(route('admin.message.list')); ?>",
                    success: function (data) {
                        $('#conversation-list').empty();
                        $("#conversation-list").append(data.html);
                        let user_id = getUrlParameter('user');
                        $('.customer-list').removeClass('conv-active');
                        $('#customer-' + user_id).addClass('conv-active');
                    }
                })
            }

            function conversationView() {
                let conversation_id = getUrlParameter('conversation');
                let user_id = getUrlParameter('user');
                let url = '<?php echo e(url('/')); ?>/admin/message/view/' + conversation_id + '/' + user_id;
                $.ajax({
                    url: url,
                    success: function (data) {
                        $('#view-conversation').html(data.view);
                    }
                })
            }



            function vendorConversationView() {
                let conversation_id = getUrlParameter('conversation');
                let user_id = getUrlParameter('user');
                let url = '<?php echo e(url('/')); ?>/admin/store/message/' + conversation_id + '/' + user_id;
                $.ajax({
                    url: url,
                    success: function (data) {
                        $('#vendor-view-conversation').html(data.view);
                    }
                })
            }

            function dmConversationView() {
                let conversation_id = getUrlParameter('conversation');
                let user_id = getUrlParameter('user');
                let url = '<?php echo e(url('/')); ?>/admin/users/delivery-man/message/' + conversation_id + '/' + user_id;
                $.ajax({
                    url: url,
                    success: function (data) {
                        $('#dm-view-conversation').html(data.view);
                    }
                })
            }

            let new_order_type = 'store_order';
            let new_module_id = null;
            let admin_zone_id = null;
            let admin_role_id = null;

            <?php $order_notification_type = \App\CentralLogics\Helpers::get_business_settings('order_notification_type') ?? 'manual'; ?>
            <?php if($fcm_enabled): ?>
            messaging.onMessage(function (payload) {
                console.log(payload.data)
                if (payload.data.order_id && payload.data.type == "order_request") {
                    <?php $admin_order_notification = \App\CentralLogics\Helpers::get_business_settings('admin_order_notification') ?? 0; ?>
                    <?php if(\App\CentralLogics\Helpers::module_permission_check('order') && $admin_order_notification && $order_notification_type == 'firebase'): ?>
                        new_order_type = payload.data.order_type
                        new_module_id = payload.data.module_id
                        admin_zone_id = '<?php    echo auth()->guard('admin')->user()->zone_id;?>';
                        admin_role_id = '<?php    echo auth()->guard('admin')->user()->role_id;?>';
                        if (new_order_type === 'trip') {
                            document.querySelector('.update_notification_text').textContent = "<?php echo e(translate('You have new trip, check please.')); ?>";
                        }
                        if (new_order_type === 'service_booking') {
                            document.querySelector('.update_notification_text').textContent = "<?php echo e(translate('You have new booking, check please.')); ?>";
                        }
                        <?php if(addon_published_status('RideShare')): ?>
                            if (new_order_type === 'ride_request') {
                                document.querySelector('.update_notification_text').textContent = "<?php echo e(translate('You have new ride request, check please.')); ?>";
                            }
                        <?php endif; ?>
                            if (admin_role_id === '1') {
                            playAudio();
                            $('#popup-modal').appendTo("body").modal('show');
                        }
                        if ((admin_role_id !== '1') && (admin_zone_id === payload.data.zone_id)) {
                            playAudio();
                            $('#popup-modal').appendTo("body").modal('show');
                        }
                    <?php endif; ?>

        } else if (payload.data.type == 'safety_alert') {
                    <?php if(addon_published_status('RideShare')): ?>
                        safetyAlertNotification(payload.data);
                        playSafetyAlertAudio();
                    <?php endif; ?>

        } else {
                    // The open thread is only refreshed when one is actually
                    // open, whatever else sits in the query string, and the
                    // admin inbox renders it into #admin-view-conversation.
                    if (window.location.pathname.includes('message/list') && getUrlParameter('conversation')) {
                        let conversation_id = getUrlParameter('conversation');
                        let user_id = getUrlParameter('user');
                        let url = '<?php echo e(url('/')); ?>/admin/message/view/' + conversation_id + '/' + user_id;
                        $.ajax({
                            url: url,
                            success: function (data) {
                                $('#admin-view-conversation').html(data.view);
                            }
                        })
                    }
                    toastr.success('New message arrived', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    if ($('#conversation-list').scrollTop() === 0) {
                        conversationList();
                    }
                }
            });
            <?php endif; ?>

            function safetyAlertNotification(data) {
                let checkLaterButton = $('#checkLater');
                let showSafetyAlertUserDetails = $('.show-safety-alert-user-details');
                let response = `${data.type.replace(/_/g, ' ')} <?php echo e(translate('sent a new Safety Alert for')); ?>`;
                response = response.charAt(0).toUpperCase() + response.slice(1).toLowerCase();
                let trip = `<b> <?php echo e(translate('Trip')); ?> #${data.trip_reference_id}</b>`
                let fullContent = `${response} ${trip}`;
                $('#safetyAlertNotificationTitle').text(data.body);
                $('#safetyAlertNotificationSubtitle').empty().html(fullContent);
                showSafetyAlertUserDetails.attr('data-user-id', data.sent_by);
                showSafetyAlertUserDetails.attr('href', data.route);
                const modalElement = document.getElementById('safetyAlertNotificationModal');
                let bootstrapModal = new bootstrap.Modal(modalElement, {
                    backdrop: 'static',
                    keyboard: false,
                });
                if (modalElement.classList.contains('show')) {
                    bootstrapModal.hide();
                    modalElement.removeEventListener('hidden.bs.modal', onHidden);
                }
                bootstrapModal.show();
                const onHidden = () => {
                    modalElement.removeEventListener('hidden.bs.modal', onHidden);
                };
                modalElement.addEventListener('hidden.bs.modal', onHidden);
                showSafetyAlertUserDetails.on('click', function () {
                    let $userId = localStorage.getItem('safetyAlertUserId');
                    if ($userId != data.sent_by) {
                        localStorage.setItem('safetyAlertUserId', data.sent_by);
                    }
                    localStorage.setItem('safetyAlertUserDetailsStatus', true);
                });
                checkLaterButton.on('click', function () {
                    pauseSafetyAlertAudio();
                    bootstrapModal.hide();
                    let safetyAlertMapIcon = document.getElementById('safetyAlertMapIcon');
                    let newSafetyAlertMapIcon = document.getElementById('newSafetyAlertMapIcon');
                    if (safetyAlertMapIcon) {
                        safetyAlertMapIcon.classList.remove('d-none');
                    }
                    if (newSafetyAlertMapIcon) {
                        newSafetyAlertMapIcon.classList.add('d-none');
                    }
                });
                $('#btnClose').on('click', function () {
                    pauseSafetyAlertAudio();
                    bootstrapModal.hide();
                });
            }

            <?php if(\App\CentralLogics\Helpers::module_permission_check('order') && $order_notification_type == 'manual'): ?>
            <?php $admin_order_notification = \App\CentralLogics\Helpers::get_business_settings('admin_order_notification') ?? 0; ?>
            <?php if($admin_order_notification): ?>
                setInterval(function () {
                    $.get({
                        url: '<?php echo e(route('admin.get-store-data')); ?>',
                        dataType: 'json',
                        success: function (response) {
                            let data = response.data;
                            new_order_type = data.type;
                            new_module_id = data.module_id;
                            if (new_order_type === 'trip') {
                                document.querySelector('.update_notification_text').textContent = "<?php echo e(translate('You have new trip, check please.')); ?>";
                            }
                            if (new_order_type === 'service_booking') {
                                document.querySelector('.update_notification_text').textContent = "<?php echo e(translate('You have new booking, check please.')); ?>";
                            }
                            if (new_order_type === 'ride_request') {
                                document.querySelector('.update_notification_text').textContent = "<?php echo e(translate('You have new ride request, check please.')); ?>";
                            }
                            if (data.new_order > 0) {
                                playAudio();
                                $('#popup-modal').appendTo("body").modal('show');
                            } else {
                                $('#popup-modal').appendTo("body").modal('hide');
                            }
                        },
                    });
                }, 10000);
            <?php endif; ?>
            <?php endif; ?>

            $(document).on('click', '.check-order', function () {
                if (new_order_type === 'parcel') {
                    location.href = '<?php echo e(url('/')); ?>/admin/parcel/orders/all?module_id=' + new_module_id;
                } else if (new_order_type === 'trip') {
                    location.href = '<?php echo e(url('/')); ?>/admin/rental/trip?module_id=' + new_module_id;
                } else if (new_order_type === 'service_booking') {
                    location.href = '<?php echo e(url('/')); ?>/admin/service/booking/list?module_id=' + new_module_id;
                } else if (new_order_type === 'ride_request') {
                    <?php if($ride_share_module_id): ?>
                        location.href = '<?php echo e(url('/')); ?>/admin/ride-share/ride/list/all?module_id=' + <?php echo e($ride_share_module_id); ?>;
                    <?php else: ?>
                        location.href = '<?php echo e(url('/')); ?>/admin/order/list/all?module_id=' + new_module_id;
                    <?php endif; ?>
                    } else {
                    location.href = '<?php echo e(url('/')); ?>/admin/order/list/all?module_id=' + new_module_id;
                }
            });

            <?php if($fcm_enabled): ?>
            startFCM();
            <?php endif; ?>
            <?php if(\App\CentralLogics\Helpers::module_permission_check('customer_management')): ?>
            conversationList();
            <?php endif; ?>
            if (getUrlParameter('conversation')) {
                conversationView();
                vendorConversationView();
                dmConversationView();
            }


            $(document).on('click', '.call-demo', function (e) {
                <?php if(getEnvMode() == 'demo'): ?>
                    toastr.warning('<?php echo e(translate('Update option is disabled for demo!')); ?>', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    e.preventDefault();
                <?php endif; ?>
        });

            $('.request_alert').on('click', function (event) {
                let url = $(this).data('url');
                let message = $(this).data('message');
                request_alert(url, message)
            })

            function request_alert(url, message) {
                Swal.fire({
                    title: '<?php echo e(translate('messages.Are you sure?')); ?>',
                    text: message,
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: 'default',
                    confirmButtonColor: '#FC6A57',
                    cancelButtonText: '<?php echo e(translate('messages.No')); ?>',
                    confirmButtonText: '<?php echo e(translate('messages.Yes')); ?>',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        location.href = url;
                    }
                })
            }


            <?php if(addon_published_status('RideShare') && in_array($module_type, ['ride-share', 'settings'])): ?>
                function fetchSafetyAlertIcon(condition = false) {
                    let url = "<?php echo e(route('admin.ride-share.fleet-map.fleet-map-safety-alert-icon-in-map')); ?>";
                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function (response) {
                            $('.safety-alert-icon-map').empty().html(response);
                            if (condition) {
                                if ($('#safetyAlertMapIcon').length) {
                                    $('#safetyAlertMapIcon').addClass('d-none');
                                }
                                if ($('#newSafetyAlertMapIcon').length) {
                                    $('#newSafetyAlertMapIcon').removeClass('d-none');
                                }
                            }

                            $('.show-safety-alert-user-details').on('click', function () {
                                localStorage.setItem('safetyAlertUserDetailsStatus', true);
                            });
                        }
                    })
                }

                function getZoneMessage() {
                    let url = "<?php echo e(route('admin.ride-share.fleet-map.fleet-map-zone-message')); ?>";
                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function (response) {
                            $('.get-zone-message').empty().html(response);
                            $('.zone-message-hide').on('click', function () {
                                $('.zone-message').addClass('invisible');
                                sessionStorage.setItem('showZoneMessage', 'false');
                            });
                        }
                    })
                }

                $(document).ready(function () {
                    let showSafetyAlertUserDetails = $('.show-safety-alert-user-details');
                    showSafetyAlertUserDetails.on('click', function () {
                        localStorage.setItem('safetyAlertUserDetailsStatus', true);
                        localStorage.setItem('safetyAlertUserIdFromTrip', $(this).data('user-id'));
                    });

                    $('.safety-alert-header-icon').on('click', function () {
                        localStorage.setItem('safetyAlertUserDetailsStatus', true);
                        localStorage.setItem('safetyAlertUserId', $(this).data('user-id'));
                    });
                })

            <?php endif; ?>
        </script>


        <script>


            function initTelInputs() {
                const inputs = document.querySelectorAll('input[type="tel"]');

                inputs.forEach(input => {

                    const iti = window.intlTelInput(input, {
                        initialCountry: "<?php echo e($countryCode); ?>",
                        utilsScript: "<?php echo e(asset('public/assets/admin/intltelinput/js/utils.js')); ?>",
                        autoInsertDialCode: true,
                        nationalMode: false,
                        formatOnDisplay: false,
                        strictMode: true,
                        <?php if(\App\CentralLogics\Helpers::get_business_settings('country_picker_status') != 1): ?>
                            onlyCountries: ["<?php echo e($countryCode); ?>"],
                        <?php endif; ?>
                });

                const restoreDialCode = () => {
                    if (input.value.trim() === '') {
                        input.value = '+' + iti.getSelectedCountryData().dialCode;
                    }
                };

                input.addEventListener('blur', restoreDialCode);
                input.closest('form')?.addEventListener('submit', restoreDialCode);
            });

            $(document).off('keyup.telinput').on('keyup.telinput', 'input[type="tel"]', function () {
                const iti = window.intlTelInputGlobals.getInstance(this);
                if (!iti) return;

                let val = $(this).val();
                if (val.trim() === '') {
                    val = '+' + iti.getSelectedCountryData().dialCode;
                } else {
                    const plus = val.startsWith('+') ? '+' : '';
                    val = plus + val.replace(/[^\d]/g, '');
                }

                $(this).val(val);
            });
        }


            initTelInputs();





            //external configuration
            $("#generateSystemSelfToken").on("click", function () {
                generateRandomToken(64);
            });
            if (document.getElementById('copyButton')) {

                document.getElementById('copyButton').addEventListener('click', function () {
                    const input = document.getElementById('systemSelfToken');

                    // Select the input field text
                    input.select();
                    input.setSelectionRange(0, 99999); // For mobile devices

                    // Copy the text inside the input field to the clipboard
                    navigator.clipboard.writeText(input.value).then(function () {
                        toastr.success('Text copied to clipboard: ' + input.value);
                    }).catch(function (error) {
                        toastr.error('Failed to copy text: ', error);
                    });
                });
            }

            function generateRandomToken(length) {
                const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                let token = '';
                for (let i = 0; i < length; i++) {
                    const randomIndex = Math.floor(Math.random() * characters.length);
                    token += characters.charAt(randomIndex);
                }
                $('#systemSelfToken').val(token)
            }



            /* ------------------------------------------------------------------
               Global search palette. Markup lives in
               layouts/partials/_global_search_modal.blade.php; the shared
               rendering + keyboard behaviour in js/global-search.js. Only the
               routes and translations are panel-specific, so they stay here.
               ------------------------------------------------------------------ */
            <?php
                // Grouped into one array on purpose: @json() splits its argument
                // on commas, so a translated string containing one cannot be
                // passed to the directive directly.
                $gs_labels = [
                    'pages' => translate('Pages & actions'),
                    'records' => translate('Records'),
                    'recent' => translate('Recent searches'),
                    'page' => translate('Page'),
                    'record' => translate('Record'),
                    'noResultTitle' => translate('No data found'),
                    'noResultText' => translate('Try another keyword, or search by ID, name, phone or email.'),
                    'idleTitle' => translate('Search anything'),
                    'idleText' => translate('Jump to any page, or look up an order, store, customer and more.'),
                    'errorTitle' => translate('Something went wrong'),
                    'errorText' => translate('We could not load the results. Please try again.'),
                ];

                $gs_notes = [
                    'limit' => translate('Showing the closest matches only. Refine your keyword to narrow the list.'),
                    'module' => $current_module_type_for_search
                        ? null
                        : '* ' . translate('To get module-specific results, please search within the module.'),
                ];
            ?>

            GlobalSearch.configure({
                labels: <?php echo json_encode($gs_labels, 15, 512) ?>,
                images: {
                    noResult: <?php echo json_encode(asset('/public/assets/admin/img/modal/no-search-found.png'), 15, 512) ?>
                }
            });

            $(document).ready(function () {
                var $modal = $('#staticBackdrop');
                var $form = $('#searchForm');
                var $input = $('#searchInput');
                var $results = $('#searchResults');

                var searchDebounce = null;
                var searchRequest = null;
                var recentRequest = null;

                var resultLimit = <?php echo e(config('search.result_limit', 50)); ?>;
                var notes = <?php echo json_encode($gs_notes, 15, 512) ?>;
                var limitNote = notes.limit;
                var moduleNote = notes.module;

                // Delegated: the result list is re-rendered on every keystroke.
                $results.on('click', '.search-list-item', function () {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo e(route('admin.store.clicked.route')); ?>',
                        data: {
                            routeName: $(this).data('route-name'),
                            routeUri: $(this).data('route-uri'),
                            routeFullUrl: $(this).data('route-full-url'),
                            searchKeyword: $input.val().trim(),
                            moduleId: '<?php echo e(config('module.current_module_id') ?? null); ?>',
                            _token: $form.find('input[name="_token"]').val()
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                });

                function abortPending() {
                    clearTimeout(searchDebounce);

                    if (searchRequest) {
                        searchRequest.abort();
                        searchRequest = null;
                    }

                    if (recentRequest) {
                        recentRequest.abort();
                        recentRequest = null;
                    }
                }

                // Keep the previous rows on screen while retyping; the progress
                // bar already signals that a request is in flight.
                function showPlaceholder(rows) {
                    if (!$results.find('.gsearch-item').length) {
                        $results.html(GlobalSearch.skeleton(rows));
                    }
                }

                function runGlobalSearch(searchKeyword) {
                    searchRequest = $.ajax({
                        type: 'POST',
                        url: $form.attr('action'),
                        data: { search: searchKeyword, _token: $form.find('input[name="_token"]').val() },
                        success: function (response) {
                            if (!response.length) {
                                $results.html(GlobalSearch.noResult(moduleNote));
                                return;
                            }

                            $results.html(GlobalSearch.results(response, searchKeyword, {
                                note: moduleNote,
                                footnote: response.length >= resultLimit ? limitNote : null
                            }));
                        },
                        error: function (xhr, status) {
                            if (status !== 'abort') {
                                console.error(xhr.responseText);
                                $results.html(GlobalSearch.error());
                            }
                        },
                        complete: function (xhr, status) {
                            if (status !== 'abort') {
                                GlobalSearch.loading(false);
                            }
                        }
                    });
                }

                function getRecentSearch() {
                    GlobalSearch.loading(true);
                    showPlaceholder(5);

                    recentRequest = $.ajax({
                        type: 'GET',
                        url: '<?php echo e(route('admin.recent.search')); ?>',
                        success: function (response) {
                            $results.html(response.length ? GlobalSearch.recent(response) : GlobalSearch.idle());
                        },
                        error: function (xhr, status) {
                            if (status !== 'abort') {
                                console.error(xhr.responseText);
                                $results.html(GlobalSearch.error());
                            }
                        },
                        complete: function (xhr, status) {
                            if (status !== 'abort') {
                                GlobalSearch.loading(false);
                            }
                        }
                    });
                }

                $form.find('input[name="search"]').on('input', function () {
                    var searchKeyword = $(this).val().trim();

                    abortPending();

                    if (searchKeyword.length < 1) {
                        getRecentSearch();
                        return;
                    }

                    GlobalSearch.loading(true);
                    showPlaceholder(4);

                    searchDebounce = setTimeout(function () {
                        runGlobalSearch(searchKeyword);
                    }, 300);
                });

                $form.on('submit', function (event) {
                    event.preventDefault();
                });

                $modal.on('shown.bs.modal', function () {
                    getRecentSearch();
                });

                $modal.on('hidden.bs.modal', function () {
                    abortPending();
                    $results.empty();
                });
            });

            document.addEventListener('keydown', function (event) {
                if ((event.ctrlKey || event.metaKey) && (event.key === 'k' || event.key === 'K')) {
                    event.preventDefault();
                    document.getElementById('modalOpener').click();
                }
            });



        </script>


        <script>
            let hideTimer;

            $('.blinkings').hover(
                function () {
                    clearTimeout(hideTimer);
                    $(this).closest('.card').find('.remove_btn_outside').css({
                        opacity: 0,
                        visibility: 'hidden'
                    });
                },
                function () {
                    let $btn = $(this).closest('.card').find('.remove_btn_outside');

                    hideTimer = setTimeout(() => {
                        $btn.css({
                            opacity: 1,
                            visibility: 'visible'
                        });
                    }, 100);
                }
            );
        </script>
        <script>
            $(document).ready(function () {

                $('[data-bg-color]').each(function () {
                    $(this).css('background-color', $(this).data('bg-color'));
                });

                $('[data-text-color]').each(function () {
                    $(this).css('color', $(this).data('text-color'));
                });

            });
        </script>

        <?php echo $__env->make('layouts.partials._logout_confirm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>

</html>
<?php /**PATH /home/foodcol2/portal.foodcollections.com/resources/views/layouts/admin/app.blade.php ENDPATH**/ ?>