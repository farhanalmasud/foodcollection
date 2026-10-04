
<!DOCTYPE html>
<?php
    if(addon_published_status('RideShare')){
        $toggle_rider_registration = \App\CentralLogics\Helpers::get_data_settings(RIDE_SHARE_BUSINESS_SETTINGS, 'toggle_rider_registration')?->value ?? false;
        if($toggle_rider_registration == 1){
            $toggle_rider_registration = true;
        }else{
            $toggle_rider_registration = false;
        }
    } else {
        $toggle_rider_registration = false;
    }
    $landing_site_direction = session()->get('landing_site_direction');
    $country= \App\CentralLogics\Helpers::get_business_settings('country')  ;
    $countryCode= strtolower($country??'auto');
   $metaData=  \App\CentralLogics\Helpers::landing_meta_data()??[];
?>
<html dir="<?php echo e($landing_site_direction); ?>" lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <?php echo $__env->make('layouts.landing._seo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;600;700;900&family=Syne:wght@700;800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="<?php echo e(asset('public/assets/landing/css/bootstrap.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/landing/css/odometer.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/toastr.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/app-toast.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/landing/css/landing.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/intltelinput/css/intlTelInput.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/page-transition.css')); ?>">

    <?php ($backgroundChange = \App\CentralLogics\Helpers::get_business_settings('backgroundChange') ?? []); ?>
    <?php if(isset($backgroundChange['primary_1_hex'])): ?>
    <style>
        :root {
            --primary: <?php echo e($backgroundChange['primary_1_hex']); ?>;
            --primary-dark: <?php echo e($backgroundChange['primary_1_hex']); ?>;
            --primary-rgb: <?php echo e($backgroundChange['primary_1_rgb'] ?? '255,107,0'); ?>;
        }
    </style>
    <?php endif; ?>

    <link rel="icon" type="image/x-icon" href="<?php echo e(\App\CentralLogics\Helpers::iconFullUrl()); ?>">
    <?php echo $__env->yieldPushContent('css_or_js'); ?>
</head>

<body>

    <div id="page-progress-bar"></div>

    
    <?php ($landingFixedTexts = \App\Models\DataSetting::with('translations')->where('type', 'admin_landing_page')->whereIn('key', ['fixed_link', 'fixed_newsletter_title', 'fixed_newsletter_sub_title', 'fixed_footer_article_title', 'download_user_app_links'])->get()->keyBy('key')); ?>
    <?php ($fixed_link = optional($landingFixedTexts->get('fixed_link'))->value); ?>
    <?php ($fixed_link = isset($fixed_link) ? json_decode($fixed_link, true) : null); ?>

    <div class="mobile-menu" id="mobileMenu">
        <button class="close-mob" id="closeMob">&times;</button>
        <a href="<?php echo e(route('home')); ?>" onclick="closeMobile()"><?php echo e(translate('messages.home')); ?></a>
        <a href="<?php echo e(route('about-us')); ?>" onclick="closeMobile()"><?php echo e(translate('About us')); ?></a>
        <a href="<?php echo e(route('privacy-policy')); ?>" onclick="closeMobile()"><?php echo e(translate('Privacy policy')); ?></a>
        <a href="<?php echo e(route('terms-and-conditions')); ?>" onclick="closeMobile()"><?php echo e(translate('messages.Terms and condition')); ?></a>
        <a href="<?php echo e(route('contact-us')); ?>" onclick="closeMobile()"><?php echo e(translate('Contact us')); ?></a>
        <?php if(isset($toggle_store_registration) && $toggle_store_registration): ?>
            <a href="<?php echo e(route('restaurant.create')); ?>" onclick="closeMobile()"><?php echo e(translate('messages.Vendor registration')); ?></a>
        <?php endif; ?>
        <?php if(isset($toggle_dm_registration) && $toggle_dm_registration): ?>
            <a href="<?php echo e(route('deliveryman.create')); ?>" onclick="closeMobile()"><?php echo e(translate('Deliveryman registration')); ?></a>
        <?php endif; ?>
        <?php if(isset($toggle_rider_registration) && $toggle_rider_registration): ?>
            <a href="<?php echo e(route('rider.create')); ?>" onclick="closeMobile()"><?php echo e(translate('Rider registration')); ?></a>
        <?php endif; ?>
        <?php if(isset($fixed_link) && isset($fixed_link['web_app_url_status']) && $fixed_link['web_app_url_status'] && !empty($fixed_link['web_app_url'])): ?>
            <a href="<?php echo e($fixed_link['web_app_url']); ?>" target="_blank" onclick="closeMobile()" class="mob-browse-web"><?php echo e(translate('Browse web')); ?></a>
        <?php endif; ?>
    </div>

    <nav class="main-nav">
        <div class="container">
            <a href="<?php echo e(route('home')); ?>" class="nav-logo max-w-70px-mobile">
                <img class="onerror-image object-fit-contain" data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>" src="<?php echo e(\App\CentralLogics\Helpers::logoFullUrl()); ?>" alt="image" />
            </a>
            <div class="nav-links gap-3 gap-lg-4">
                <a href="<?php echo e(route('home')); ?>" class="<?php echo e(Request::is('/') ? 'active-link' : ''); ?>"><?php echo e(translate('messages.home')); ?></a>
                <a href="<?php echo e(route('about-us')); ?>" class="<?php echo e(Request::is('about-us') ? 'active-link' : ''); ?>"><?php echo e(translate('About us')); ?></a>
                <a href="<?php echo e(route('privacy-policy')); ?>" class="<?php echo e(Request::is('privacy-policy') ? 'active-link' : ''); ?>"><?php echo e(translate('Privacy policy')); ?></a>
                <a href="<?php echo e(route('terms-and-conditions')); ?>" class="<?php echo e(Request::is('terms-and-conditions') ? 'active-link' : ''); ?>"><?php echo e(translate('messages.Terms and condition')); ?></a>
                <a href="<?php echo e(route('contact-us')); ?>" class="<?php echo e(Request::is('contact-us') ? 'active-link' : ''); ?>"><?php echo e(translate('Contact us')); ?></a>
            </div>
            <div class="nav-right">
                <?php ( $local = session()->has('landing_local')?session('landing_local'):null); ?>
                <?php ($lang = \App\CentralLogics\Helpers::get_business_settings('system_language') ); ?>
                <?php if($lang): ?>
                <div class="lang-sw" id="langSw">
                    <div class="lang-current" onclick="document.getElementById('langSw').classList.toggle('open')">
                        &#x1F310;
                        <?php $__currentLoopData = $lang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($data['code']==$local): ?>
                                <span><?php echo e(strtoupper($data['code'])); ?></span>
                            <?php elseif(!$local && $data['default'] == true): ?>
                                <span><?php echo e(strtoupper($data['code'])); ?></span>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <svg viewBox="0 0 10 10" fill="none"><path d="M2.5 3.75L5 6.25L7.5 3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    </div>
                    <div class="lang-dd">
                        <?php $__currentLoopData = $lang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($data['status']==1): ?>
                                <a href="<?php echo e(route('lang',[$data['code']])); ?>" class="<?php echo e(($data['code']==$local || (!$local && $data['default'] == true)) ? 'active' : ''); ?>">
                                    <?php echo e($data['code']); ?>

                                </a>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(isset($fixed_link) && isset($fixed_link['web_app_url_status']) && $fixed_link['web_app_url_status'] && !empty($fixed_link['web_app_url'])): ?>
                <a href="<?php echo e($fixed_link['web_app_url']); ?>" target="_blank" class="btn-browse-web"><?php echo e(translate('Browse web')); ?></a>
                <?php endif; ?>

                <?php if(isset($toggle_dm_registration) || isset($toggle_store_registration) || isset($toggle_rider_registration)): ?>
                <div class="join-wrap">
                    <button class="btn-join"><?php echo e(translate('Join us')); ?> <svg width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M2.5 3.75L5 6.25L7.5 3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg></button>
                    <div class="join-dd">
                        <?php if(isset($toggle_store_registration) && $toggle_store_registration): ?>
                        <a href="<?php echo e(route('restaurant.create')); ?>" class="<?php echo e(Request::is('vendor*') ? 'active' : ''); ?>">
                            <span class="ji" style="background:rgba(255,107,0,.1);color:#FF6B00;">&#x1F3EA;</span>
                            <?php echo e(translate('messages.Vendor registration')); ?>

                        </a>
                        <?php endif; ?>
                        <?php if(isset($toggle_dm_registration) && $toggle_dm_registration): ?>
                        <a href="<?php echo e(route('deliveryman.create')); ?>" class="<?php echo e(Request::is('deliveryman*') ? 'active' : ''); ?>">
                            <span class="ji" style="background:rgba(0,190,101,.1);color:#00BE65;">&#x1F6F5;</span>
                            <?php echo e(translate('Deliveryman registration')); ?>

                        </a>
                        <?php endif; ?>
                        <?php if(isset($toggle_rider_registration) && $toggle_rider_registration): ?>
                        <a href="<?php echo e(route('rider.create')); ?>" class="<?php echo e(Request::is('rider*') ? 'active' : ''); ?>">
                            <span class="ji" style="background:rgba(0,121,227,.1);color:#0079E3;">&#x1F697;</span>
                            <?php echo e(translate('Rider registration')); ?>

                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <button class="mob-btn" id="mobBtn" aria-label="Menu"><span></span><span></span><span></span></button>
            </div>
        </div>
    </nav>

    <?php echo $__env->yieldContent('content'); ?>

    <footer class="footer">
        <?php ($fixed_newsletter_title = optional($landingFixedTexts->get('fixed_newsletter_title'))->value); ?>
        <?php ($fixed_newsletter_sub_title = optional($landingFixedTexts->get('fixed_newsletter_sub_title'))->value); ?>
        <?php ($fixed_footer_article_title = optional($landingFixedTexts->get('fixed_footer_article_title'))->value); ?>

        <div class="container">
            <div class="newsletter-area">
                <h2><?php echo e($fixed_newsletter_title ?? translate('Sign up to our newsletter')); ?></h2>
                <p><?php echo e($fixed_newsletter_sub_title ?? translate('Receive latest news, updates and many other news every week')); ?></p>
                <form class="nl-form" method="post" action="<?php echo e(route('newsletter.subscribe')); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="email" name="email" placeholder="<?php echo e(translate('Enter your email address')); ?>" required />
                    <button type="submit"><?php echo e(translate('Subscribe')); ?></button>
                </form>
            </div>

            <div class="footer-grid">
                <div class="f-brand">
                    <a href="<?php echo e(route('home')); ?>" class="nav-logo">
                        <img class="onerror-image" data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>" src="<?php echo e(\App\CentralLogics\Helpers::logoFullUrl()); ?>" alt="image" />
                    </a>
                    <p><?php echo e($fixed_footer_article_title); ?></p>
                    <div class="f-social">
                        <?php ($social_media = \App\CentralLogics\Helpers::social_media_active()); ?>
                        <?php if(isset($social_media)): ?>
                            <?php $__currentLoopData = $social_media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e($social->link); ?>" target="_blank" aria-label="<?php echo e($social->name); ?>">
                                <img src="<?php echo e(asset('public/assets/landing/img/footer/'. $social->name.'.svg')); ?>" alt="<?php echo e($social->name); ?>">
                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                    <?php ($landing_page_links_footer = optional($landingFixedTexts->get('download_user_app_links'))->value); ?>
                    <?php ($landing_page_links_footer = isset($landing_page_links_footer) ? json_decode($landing_page_links_footer, true) : null); ?>
                    <?php ($footer_playstore_url = \App\CentralLogics\Helpers::get_business_settings('app_url_android', false)); ?>
                    <?php ($footer_appstore_url = \App\CentralLogics\Helpers::get_business_settings('app_url_ios', false)); ?>
                    <?php if((isset($landing_page_links_footer['playstore_url_status']) && $footer_playstore_url) || (isset($landing_page_links_footer['apple_store_url_status']) && $footer_appstore_url)): ?>
                    <div class="f-app-row">
                        <?php if(isset($landing_page_links_footer['playstore_url_status']) && $footer_playstore_url): ?>
                        <a href="<?php echo e($footer_playstore_url); ?>" target="_blank" class="f-app-link">
                            <svg viewBox="0 0 24 24"><path d="M3.609 1.814L13.792 12 3.61 22.186a.996.996 0 01-.61-.92V2.734a1 1 0 01.609-.92zm10.89 10.893l2.302 2.302-10.937 6.333 8.635-8.635zm3.199-1.4l2.834 1.638a1 1 0 010 1.726l-2.834 1.638-2.56-2.56 2.56-2.442zM5.864 1.458L16.8 7.79l-2.302 2.302-8.635-8.635z" fill="currentColor"/></svg>
                            <span class="fal-text"><span class="fal-sm">Get it on</span><span class="fal-lg">Google Play</span></span>
                        </a>
                        <?php endif; ?>
                        <?php if(isset($landing_page_links_footer['apple_store_url_status']) && $footer_appstore_url): ?>
                        <a href="<?php echo e($footer_appstore_url); ?>" target="_blank" class="f-app-link">
                            <svg viewBox="0 0 24 24"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z" fill="currentColor"/></svg>
                            <span class="fal-text"><span class="fal-sm">Download on the</span><span class="fal-lg">App Store</span></span>
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <?php ($landing_data_footer =\App\CentralLogics\Helpers::landing_policy_statuses()); ?>
                <div>
                    <h5><?php echo e(translate("messages.Support")); ?></h5>
                    <div class="f-links">
                        <a href="<?php echo e(route('privacy-policy')); ?>"><?php echo e(translate('Privacy policy')); ?></a>
                        <a href="<?php echo e(route('terms-and-conditions')); ?>"><?php echo e(translate('messages.Terms and condition')); ?></a>
                        <?php if(isset($landing_data_footer['refund_policy_status']) && $landing_data_footer['refund_policy_status'] == 1): ?>
                        <a href="<?php echo e(route('refund')); ?>"><?php echo e(translate('Refund policy')); ?></a>
                        <?php endif; ?>
                        <?php if(isset($landing_data_footer['shipping_policy_status']) && $landing_data_footer['shipping_policy_status'] == 1): ?>
                        <a href="<?php echo e(route('shipping-policy')); ?>"><?php echo e(translate('Shipping policy')); ?></a>
                        <?php endif; ?>
                        <?php if(isset($landing_data_footer['cancellation_policy_status']) && $landing_data_footer['cancellation_policy_status'] == 1): ?>
                        <a href="<?php echo e(route('cancelation')); ?>"><?php echo e(translate('Cancellation policy')); ?></a>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <h5><?php echo e(translate('Contact us')); ?></h5>
                    <div class="f-contact">
                        <a href="#">&#x1F4CD; <?php echo e(\App\CentralLogics\Helpers::get_settings('address')); ?></a>
                        <a href="mailto:<?php echo e(\App\CentralLogics\Helpers::get_settings('email_address')); ?>">&#x2709;&#xFE0F; <?php echo e(\App\CentralLogics\Helpers::get_settings('email_address')); ?></a>
                        <a href="tel:<?php echo e(\App\CentralLogics\Helpers::get_settings('phone')); ?>">&#x1F4DE; <?php echo e(\App\CentralLogics\Helpers::get_settings('phone')); ?></a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom-bar">
                &copy; <?php echo e(\App\CentralLogics\Helpers::get_settings('footer_text')); ?>

                by <?php echo e(\App\CentralLogics\Helpers::get_settings('business_name')); ?>

            </div>
        </div>
    </footer>

    <script src="<?php echo e(asset('public/assets/landing/js/jquery-3.6.0.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/landing/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/landing/js/viewport.jquery.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/landing/js/odometer.min.js')); ?>"></script>
    <script>
        window.APP_TOAST_I18N = {
            success: "<?php echo e(translate('messages.success')); ?>",
            info: "<?php echo e(translate('messages.Information')); ?>",
            warning: "<?php echo e(translate('messages.warning')); ?>",
            danger: "<?php echo e(translate('messages.error')); ?>",
            close: "<?php echo e(translate('messages.Close')); ?>"
        };
    </script>
    <script src="<?php echo e(asset('public/assets/admin/js/toastr.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/admin/js/app-toast.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/admin/js/field-error-toast.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/admin/intltelinput/js/intlTelInput.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/admin/js/page-transition.js')); ?>"></script>
    <?php echo Toastr::message(); ?>

    <?php if($errors->any()): ?>
        <script>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            toastr.error('<?php echo e($error); ?>', Error, {
                CloseButton: true,
                ProgressBar: true
            });
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </script>
    <?php endif; ?>

    <?php echo $__env->yieldPushContent('script_2'); ?>

    <script>
        "use strict";
        $(function(){ $('[data-toggle="tooltip"]').tooltip(); });

        document.getElementById('mobBtn').addEventListener('click',()=>document.getElementById('mobileMenu').classList.add('open'));
        document.getElementById('closeMob').addEventListener('click',()=>document.getElementById('mobileMenu').classList.remove('open'));
        function closeMobile(){document.getElementById('mobileMenu').classList.remove('open')}

        document.addEventListener('click',e=>{const sw=document.getElementById('langSw');if(sw&&!sw.contains(e.target))sw.classList.remove('open')})
    </script>

    <script>
        "use strict";
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
    </script>

</body>
</html>
<?php /**PATH /home/foodcol2/portal.foodcollections.com/resources/views/layouts/landing/app.blade.php ENDPATH**/ ?>