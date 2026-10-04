<!DOCTYPE html>
<?php

    $log_email_succ = session()->get('log_email_succ');
?>

<html dir="<?php echo e($site_direction); ?>" lang="<?php echo e($locale); ?>" class="<?php echo e($site_direction === 'rtl'?'active':''); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo e(translate('messages.login')); ?></title>

    <link rel="shortcut icon" href="<?php echo e(asset('public/favicon.ico')); ?>">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin')); ?>/css/vendor.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin')); ?>/vendor/icon-set/style.css">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/button-icons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/theme.minc619.css?v=1.0')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/form-controls.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/buttons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin')); ?>/css/toastr.css">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/app-toast.css')); ?>">
</head>

<body>
<main id="content" role="main" class="main">
    <div class="auth-wrapper">
        <div class="auth-wrapper-left">
            <div class="auth-left-cont">
                <img class="onerror-image"  data-onerror-image="<?php echo e(asset('/public/assets/admin/img/favicon.png')); ?>"
                src="<?php echo e(\App\CentralLogics\Helpers::logoFullUrl()); ?>"  alt="public/img">
                <h2 class="title"><?php echo e(translate('Your')); ?> <span class="d-block"><?php echo e(translate('All service')); ?></span> <strong class="text--039D55"><?php echo e(translate('in one field')); ?>....</strong></h2>
            </div>
        </div>
        <div class="auth-wrapper-right">
            <label class="badge badge-soft-success __login-badge">
                <?php echo e(translate('messages.Software version')); ?> : <?php echo e(env('SOFTWARE_VERSION')); ?>

            </label>

            <div class="auth-wrapper-form">
                <div class="d-sm-none flex-grow-1 mb-2">
                    <img class="w-50px img-fluid" class="onerror-image"  data-onerror-image="<?php echo e(asset('/public/assets/admin/img/favicon.png')); ?>"
                        src="<?php echo e(\App\CentralLogics\Helpers::logoFullUrl()); ?>"  alt="public/img">
                </div>
                <form class="" action="<?php echo e(route('login_post')); ?>" method="post" id="form-id">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="role" value="<?php echo e($role ?? null); ?>">
                    <div class="auth-header">
                        <div class="mb-5">
                            <h2 class="title"><?php echo e(translate($role)); ?> <?php echo e(translate('messages.login')); ?></h2>
                            <div><?php echo e(translate('messages.Welcome back login to your panel')); ?>.</div>
                        </div>
                    </div>

                    <div class="js-form-message form-group">
                        <label class="input-label text-capitalize" for="signinSrEmail"><?php echo e(translate('messages.Your email')); ?></label>

                        <input type="email" class="form-control form-control-lg" name="email" id="signinSrEmail"
                                tabindex="1" placeholder="email@address.com" value="<?php echo e($email ?? ''); ?>" aria-label="email@address.com"
                                required data-msg="<?php echo e(translate('Please enter a valid email address.')); ?>">
                    </div>

                    <div class="js-form-message form-group mb-2">
                        <label class="input-label" for="signupSrPassword" tabindex="0">
                            <span class="d-flex justify-content-between align-items-center">
                                <?php echo e(translate('messages.password')); ?>

                            </span>
                        </label>

                        <div class="input-group input-group-merge">
                            <input type="password" class="js-toggle-password form-control form-control-lg"
                                    name="password" id="signupSrPassword" placeholder="<?php echo e(translate('Minimum characters')); ?>: 6+" value="<?php echo e($password ?? ''); ?>"
                                    aria-label="<?php echo e(translate('Minimum characters')); ?>: 6+" required
                                    data-msg="<?php echo e(translate('messages.Invalid password warning')); ?>"
                                    data-hs-toggle-password-options='{
                                                "target": "#changePassTarget",
                                    "defaultClass": "tio-hidden-outlined",
                                    "showClass": "tio-visible-outlined",
                                    "classChangeTarget": "#changePassIcon"
                                    }'>
                            <div id="changePassTarget" class="input-group-append">
                                <a class="input-group-text" href="javascript:">
                                    <i id="changePassIcon" class="tio-visible-outlined"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-5">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="termsCheckbox" <?php echo e($password ? 'checked' : ''); ?>

                                        name="remember">
                                <label class="custom-control-label text-muted" for="termsCheckbox">
                                    <?php echo e(translate('messages.Remember me')); ?>

                                </label>
                            </div>
                        </div>
                        <div class="form-group" id="forget-password" style="display: <?php echo e($role == 'admin' ? '' : 'none'); ?>;">
                            <div class="custom-control">
                                <span type="button" data-toggle="modal" class="text-primary text-hover--primary" data-target="#forgetPassModal"><?php echo e(translate('Forgot password')); ?>?</span>
                            </div>
                        </div>
                        <div class="form-group" id="forget-password1" style="display: <?php echo e($role == 'vendor' ? '' : 'none'); ?>;">
                            <div class="custom-control">
                                <span type="button" data-toggle="modal" class="text-primary text-hover--primary" data-target="#forgetPassModal1"><?php echo e(translate('Forgot password')); ?>?</span>
                            </div>
                        </div>
                    </div>

                    <?php echo $__env->make('admin-views.partials._recaptcha', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                    <button type="submit" class="btn btn-lg btn-block btn--primary mt-xxl-3" id="signInBtn"><i class="tio-sign-in"></i> <?php echo e(translate('messages.login')); ?></button>
                </form>
                <?php if(getEnvMode() == 'demo'): ?>
                <?php if(isset($role) && $role == 'admin'): ?>
                <div class="auto-fill-data-copy">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div>
                            <span class="d-block"><strong>Email</strong> : admin@admin.com</span>
                            <span class="d-block"><strong>Password</strong> : 12345678</span>
                        </div>
                        <div>
                            <button class="btn action-btn btn--primary m-0 copy_cred"><i class="tio-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if(isset($role) && $role == 'vendor'): ?>
                <div class="auto-fill-data-copy">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div>
                            <span class="d-block"><strong>Email</strong> : test.restaurant@gmail.com</span>
                            <span class="d-block"><strong>Password</strong> : 12345678</span>
                        </div>
                        <div>
                            <button class="btn action-btn btn--primary m-0 copy_cred2"><i class="tio-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</main>
<div class="modal fade" id="forgetPassModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header justify-content-end">
        <span type="button" class="close-modal-icon" data-dismiss="modal">
            <i class="tio-clear"></i>
        </span>
      </div>
      <div class="modal-body">
        <div class="forget-pass-content">
            <img src="<?php echo e(asset('/public/assets/admin/img/send-mail.svg')); ?>" alt="">
            <h4>
                <?php echo e(translate('Send mail to your email')); ?> ?
            </h4>
            <p>
                <?php ($masked_email = isset($role) && $role == 'admin' ? \App\Models\Admin::where('role_id', 1)->first()?->masked_email : ''); ?>
                <?php echo e(translate('A mail will be sent to your registered email with a link to change password')); ?>

                <?php if($masked_email): ?>
                    <br><?php echo e(translate('Email')); ?>: <?php echo e($masked_email); ?>

                <?php endif; ?>
            </p>
            <form action="<?php echo e(route('reset-password')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-lg btn-block btn--primary mt-3">
                    <i class="tio-send"></i> <?php echo e(translate('Send mail')); ?>

                </button>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="forgetPassModal1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header justify-content-end">
        <span type="button" class="close-modal-icon" data-dismiss="modal">
            <i class="tio-clear"></i>
        </span>
      </div>
      <div class="modal-body">
        <div class="forget-pass-content">
            <img src="<?php echo e(asset('/public/assets/admin/img/send-mail.svg')); ?>" alt="">
            <h4>
                <?php echo e(translate('Send mail to your email')); ?> ?
            </h4>
            <form class="" action="<?php echo e(route('vendor-reset-password')); ?>" method="post">
                <?php echo csrf_field(); ?>

                <input type="email" name="email" id="" class="form-control" placeholder="<?php echo e(translate('messages.Please enter your registered email')); ?>" required>
                <button type="submit" class="btn btn-lg btn-block btn--primary mt-3"><i class="tio-send"></i> <?php echo e(translate('Send mail')); ?></button>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="successMailModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header justify-content-end">
          <span type="button" class="close-modal-icon" data-dismiss="modal">
              <i class="tio-clear"></i>
          </span>
        </div>
        <div class="modal-body">
          <div class="forget-pass-content">
              <img src="<?php echo e(asset('/public/assets/admin/img/sent-mail.svg')); ?>" alt="">
              <h4>
                <?php echo e(translate('A mail has been sent to your registered email')); ?>!
              </h4>
              <p>
                <?php echo e(translate('Click the link in the mail description to change password')); ?>

              </p>
              <button class="btn btn-lg btn-block btn--primary mt-3" data-dismiss="modal">
                <i class="tio-checkmark-circle-outlined"></i> <?php echo e(translate('Got it')); ?>

              </button>
          </div>
        </div>
      </div>
    </div>
  </div>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/vendor.min.js"></script>

<script src="<?php echo e(asset('public/assets/admin')); ?>/js/theme.min.js"></script>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/toastr.js"></script>
<script src="<?php echo e(asset('public/assets/admin/js/app-toast.js')); ?>"></script>
<?php echo Toastr::message(); ?>


<?php if($errors->any()): ?>
    <script>
        "use strict";
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        toastr.error('<?php echo e(translate($error)); ?>', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </script>
<?php endif; ?>
<?php if($log_email_succ): ?>
<?php (session()->forget('log_email_succ')); ?>
    <script>
        "use strict";
        $('#successMailModal').modal('show');
    </script>
<?php endif; ?>

<script>
    "use strict";
        $("#role-select").change(function() {
            var selectValue = $(this).val();
            if (selectValue == "admin") {
            $("#forget-password").show();
            $("#forget-password1").hide();
            } else if(selectValue == "vendor") {
            $("#forget-password").hide();
            $("#forget-password1").show();
            }
            else {
            $("#forget-password").hide();
            $("#forget-password1").hide();
            }
        });

    $(document).on('ready', function () {
        $('.js-toggle-password').each(function () {
            new HSTogglePassword(this).init()
        });

        $('.js-validate').each(function () {
            $.HSCore.components.HSValidation.init($(this));
        });
    });
    $(document).ready(function() {
        $('.onerror-image').on('error', function() {
            let img = $(this).data('onerror-image')
            $(this).attr('src', img);
        });
    });
</script>

<script>
    $(document).on('click', '.reloadCaptcha', function () {
        $.ajax({
            url: "<?php echo e(route('reload-captcha')); ?>",
            type: "GET",
            dataType: 'json',
            beforeSend: function () {
                $('#loading').show()
                $('.capcha-spin').addClass('active')
            },
            success: function (data) {
                $('#reload-captcha').html(data.view);
            },
            complete: function () {
                $('#loading').hide()
                $('.capcha-spin').removeClass('active')
            }
        });
    });

</script>

<?php if(isset($recaptcha) && $recaptcha['status'] == 1): ?>
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo e($recaptcha['site_key']); ?>"></script>
<?php endif; ?>
<?php if(isset($recaptcha) && $recaptcha['status'] == 1): ?>
    <script>
        $(document).ready(function () {
            $('#signInBtn').click(function (e) {
                if ($('#set_default_captcha_value').val() == 1) {
                    $('#form-id').submit();
                    return true;
                }
                e.preventDefault();
                if (typeof grecaptcha === 'undefined') {
                    toastr.error('Invalid recaptcha key provided. Please check the recaptcha configuration.');
                    $('#reload-captcha').removeClass('d-none');
                    $('#set_default_captcha_value').val('1');

                    return;
                }
                grecaptcha.ready(function () {
                    grecaptcha.execute('<?php echo e($recaptcha['site_key']); ?>', { action: 'submit' }).then(function (token) {
                        $('#g-recaptcha-response').val(token);
                        $('#form-id').submit();
                    });
                });
                window.onerror = function (message) {
                    var errorMessage = 'An unexpected error occurred. Please check the recaptcha configuration';
                    if (message.includes('Invalid site key')) {
                        errorMessage = 'Invalid site key provided. Please check the recaptcha configuration.';
                    } else if (message.includes('not loaded in api.js')) {
                        errorMessage = 'reCAPTCHA API could not be loaded. Please check the recaptcha API configuration.';
                    }
                    $('#reload-captcha').removeClass('d-none');
                    $('#set_default_captcha_value').val('1');
                    toastr.error(errorMessage)
                    return true;
                };
            });
        });
    </script>
<?php endif; ?>




<?php if(getEnvMode()=='demo'): ?>
    <script>
        "use strict";
        $('.copy_cred').on('click', function () {
            $('#signinSrEmail').val('admin@admin.com');
            $('#signupSrPassword').val('12345678');
            toastr.success('Copied successfully!', 'Success!', {
                CloseButton: true,
                ProgressBar: true
            });
        })
        $('.copy_cred2').on('click', function () {
            $('#signinSrEmail').val('test.restaurant@gmail.com');
            $('#signupSrPassword').val('12345678');
            toastr.success('Copied successfully!', 'Success!', {
                CloseButton: true,
                ProgressBar: true
            });
        })
    </script>
<?php endif; ?>

</body>
</html>
<?php /**PATH /home/foodcol2/portal.foodcollections.com/resources/views/auth/login.blade.php ENDPATH**/ ?>