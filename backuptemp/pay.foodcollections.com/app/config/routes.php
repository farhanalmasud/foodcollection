<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

include_once "route_slugs.php";
$r_login = $custom_slug_array["login"];

$route['default_controller']                = 'home_controller';
$route['404_override']                      = 'home_controller/not_found';
$route['translate_uri_dashes']              = FALSE;


/**
 * Auth Section
 */

$route[$r_login]['get']                             = 'auth_controller/login';
$route['login-post']['post']                        = 'auth_controller/login_post';
$route['admin/logout']['get']                       = 'auth_controller/logout';
$route['forgot-password']['get']                    = 'auth_controller/forgot_password';
$route['forgot-password-post']['post']              = 'auth_controller/forgot_password_post';
$route['reset-password']['get']                     = 'auth_controller/reset_password';
$route['reset-password-post']['post']               = 'auth_controller/reset_password_post';

/**
 * Callback Section
 */

$route['callback/(:any)']['post']                   = 'callback_controller/callback_data/$1';

/**
 * Cron Section
 */

$route['cron/run']['get']                           = 'cron/run';

/**
 * API Section
 */

// external api section
$route['api/checkout']['post']                      = 'api_controller/add_temp_data';
$route['api/checkout/(:any)']['post']               = 'api_controller/add_temp_data/$1';
$route['api/checkout-v2']['post']                   = 'api_controller/add_temp_data_v2';
$route['api/checkout-v2/(:any)']['post']            = 'api_controller/add_temp_data_v2/$1';
$route['api/checkout-v3']['post']                   = 'api_controller/add_temp_data_v3';
$route['api/checkout-v3/(:any)']['post']            = 'api_controller/add_temp_data_v3/$1';
$route['api/domain-checkout/(:any)']['get']         = 'api_controller/add_temp_domain_data/$1';
$route['api/domain-checkout/(:any)/(:any)']['get']  = 'api_controller/add_temp_domain_data/$1/$2';
$route['api/verify-payment']['post']                = 'api_controller/verify_payment_transaction';
$route['api/verify-payment/(:any)']['post']         = 'api_controller/verify_payment_transaction/$1';
$route['api/refund-payment']['post']                = 'api_controller/refund_payment';

// internal api controller
$route['checkout/verify-payment-data']['post']              = 'payment_api_controller/init_api';
$route['checkout/verify-bank-data']['post']                 = 'payment_controller/submit_bank_payment';
$route['checkout/verify-international-data']['post']        = 'payment_controller/submit_international_payment';
$route['checkout/payment/bkash/(:num)']['post']             = 'bkash_api_controller/init_bkash/$1';

$route['checkout/payment/tokenized-bkash/(:num)/(:any)']['get']     = 'bkash_tokenized_api_controller/init_bkash/$1/$2';
$route['bkash/callback']['get']                                     = 'bkash_tokenized_api_controller/verify';

$route['checkout/payment/nagad/(:num)/(:any)']['get']       = 'nagad_api_controller/init_nagad/$1/$2';
$route['nagad/callback']['get']                             = 'nagad_api_controller/verify';

$route['checkout/payment/upay/(:num)/(:any)']['get']        = 'upay_api_controller/init_upay/$1/$2';
$route['upay/callback']['get']                              = 'upay_api_controller/verify';

$route['checkout/international/paypal/(:any)']['get']       = 'paypal_api_controller/init_paypal/$1';
$route['paypal/callback']['get']                            = 'paypal_api_controller/verify';
$route['paypal/cancel']['get']                              = 'paypal_api_controller/cancel';

$route['checkout/international/paypal-personal/(:any)']['get']      = 'paypal_personal_api_controller/init_paypal/$1';
$route['paypal-personal/callback']['post']                          = 'paypal_personal_api_controller/webhook';
$route['paypal/cancel']['get']                                      = 'paypal_personal_api_controller/cancel';
$route['paypal-personal/success']['get']                            = 'paypal_personal_api_controller/success';

$route['checkout/international/paddle']['post']             = 'paddle_api_controller/init_paddle';
$route['paddle/callback']['post']                           = 'paddle_api_controller/webhook';
$route['paddle/success']['get']                             = 'paddle_api_controller/success';

$route['checkout/international/stripe/(:any)']['get']       = 'stripe_api_controller/init_stripe/$1';
$route['stripe/callback']['get']                            = 'stripe_api_controller/verify';
$route['stripe/cancel']['get']                              = 'stripe_api_controller/cancel';

$route['checkout/international/perfectmoney/(:any)']['get']         = 'perfectmoney_api_controller/init_perfectmoney/$1';
$route['perfectmoney/callback']['post']                             = 'perfectmoney_api_controller/webhook';
$route['perfectmoney/cancel']['get']                                = 'perfectmoney_api_controller/cancel';
$route['perfectmoney/success']['get']                                     = 'perfectmoney_api_controller/success';


/**
 * Front Section
 */

$route['verify-license']['get']                     = 'home_controller/verify_license';
$route['verify-license-post']['post']               = 'home_controller/verify_license_post';
$route['change-language']['post']                   = 'home_controller/chnage_language';
// payment
$route['resellercamp-add-fund']['post']             = 'payment_controller/resellercamp_api';
$route['resellercamp-global-add-fund']['post']      = 'payment_controller/resellercamp_global_api';
$route['generate-invoice']['post']                  = 'payment_controller/invoice_api';
$route['generate-invoice-global']['post']           = 'payment_controller/invoice_global_api';
$route['payment/(:any)']['get']                     = 'payment_controller/payment_page/$1';
$route['checkout/mfs/(:any)/(:num)/(:any)']['get']  = 'payment_controller/mobile_bank/$1/$2/$3';
$route['checkout/bank/(:any)/(:any)']['get']        = 'payment_controller/net_bank/$1/$2';
$route['checkout/international/(:num)/(:any)']['get']  = 'payment_controller/international/$1/$2';
$route['checkout/success']['post']                  = 'payment_controller/success_page';
$route['checkout/pending']['post']                  = 'payment_controller/pending_page';
$route['checkout/cancel']                           = 'payment_controller/cancel_page';
// invoice
$route['invoice/(:any)']['get']                     = 'payment_controller/invoice_page/$1';
$route['invoice/(:any)/(:any)']['get']              = 'payment_controller/invoice_page_global/$1/$2';
//resellercamp
$route['resellercamp/(:any)']['get']                = 'payment_controller/resellercamp/$1';
$route['resellercamp/(:any)/(:any)']['get']         = 'payment_controller/resellercamp_global/$1/$2';



/**
 * Admin Section
 */

$route['admin/dashboard']                   = 'admin_controller/dashboard';

// profile
$route['admin/profile']                     = 'admin_controller/profile_settings';
$route['admin/profile-post']                = 'admin_controller/profile_settings_post';
// activity
$route['admin/activities']                  = 'admin_controller/activities';
$route['admin/get-activities']              = 'admin_controller/get_activities';
// api keys
$route['admin/generate-api-key']            = 'admin_controller/generate_api_key';
$route['admin/generate-invoice-api-key']    = 'admin_controller/generate_invoice_api_key';
$route['admin/generate-apk-api-key']        = 'admin_controller/generate_apk_api_key';


// upload
$route['upload/brand-image/(:any)']['post'] = 'brand_controller/upload_brand_image/$1';
$route['upload/profile-picture']['post']    = 'admin_controller/upload_profile_picture';
$route['upload/upload-bank-logo']['post']   = 'bank_controller/upload_bank_logo';
$route['upload/payment-slip']['post']       = 'payment_controller/upload_payment_slip';

// payment
$route['admin/approve-payment-with-request']    = 'admin_controller/approve_payment_with_request';
$route['admin/send-payment-request']        = 'admin_controller/send_payment_request';
$route['admin/payment-status']              = 'admin_controller/payment_status';
$route['admin/refund-payment']              = 'admin_controller/refund_payment';

// trash
$route['admin/trash-item']                  = 'admin_controller/trash_item';
$route['admin/trash-multi-items']           = 'admin_controller/trash_multi_items';

// delete
$route['admin/delete-item']                 = 'admin_controller/delete_item';
$route['admin/delete-multi-items']          = 'admin_controller/delete_multi_items';

// approve
$route['admin/approve-multi-items']         = 'admin_controller/approve_multi_items';

// restore
$route['admin/restore-payment']             = 'admin_controller/restore_item';


// update section
$route['admin/update-settings']             = 'admin_controller/update_settings';
$route['admin/update-template-settings']    = 'admin_controller/update_template_settings';



/**
 * Mobile Bank Payment Section
 */

$route['admin/payments']                    = 'mobile_bank_controller/payments';
$route['admin/payment-details/(:num)']      = 'mobile_bank_controller/payment_details/$1';
$route['admin/edit-payment/(:num)']         = 'mobile_bank_controller/edit_payment/$1';
$route['admin/update-payment-post']         = 'mobile_bank_controller/update_payment_post';
$route['admin/get-payments']                = 'mobile_bank_controller/get_payments';
$route['admin/pending-payments']            = 'mobile_bank_controller/pending_payments';
$route['admin/get-pending-payments']        = 'mobile_bank_controller/get_pending_payments';
$route['admin/refunded-payments']           = 'mobile_bank_controller/refunded_payments';
$route['admin/get-refunded-payments']       = 'mobile_bank_controller/get_refunded_payments';
$route['admin/trash-payments']              = 'mobile_bank_controller/trash_payments';
$route['admin/get-trash-payments']          = 'mobile_bank_controller/get_trash_payments';



/**
 * Bank Payment Section
 */

$route['admin/bank-payments']               = 'bank_controller/bank_payments';
$route['admin/get-bank-payments']           = 'bank_controller/get_bank_payments';
$route['admin/pending-bank-payments']       = 'bank_controller/pending_bank_payments';
$route['admin/get-pending-bank-payments']   = 'bank_controller/get_pending_bank_payments';
$route['admin/refunded-bank-payments']      = 'bank_controller/refunded_bank_payments';
$route['admin/get-refunded-bank-payments']  = 'bank_controller/get_refunded_bank_payments';
$route['admin/trash-bank-payments']         = 'bank_controller/trash_bank_payments';
$route['admin/get-trash-bank-payments']     = 'bank_controller/get_trash_bank_payments';



/**
 * Global Payment Section
 */

$route['admin/global-payments']               = 'global_controller/global_payments';
$route['admin/get-global-payments']           = 'global_controller/get_global_payments';
$route['admin/pending-global-payments']       = 'global_controller/pending_global_payments';
$route['admin/get-pending-global-payments']   = 'global_controller/get_pending_global_payments';
$route['admin/refunded-global-payments']      = 'global_controller/refunded_global_payments';
$route['admin/get-refunded-global-payments']  = 'global_controller/get_refunded_global_payments';
$route['admin/trash-global-payments']         = 'global_controller/trash_global_payments';
$route['admin/get-trash-global-payments']     = 'global_controller/get_trash_global_payments';


/**
 * Stored Data Section
 */

$route['admin/stored-data']                 = 'stored_data_controller/stored_data';
$route['admin/get-stored-data']             = 'stored_data_controller/get_stored_data';
$route['admin/add-stored-data']             = 'stored_data_controller/add_stored_data';
$route['admin/add-stored-data-post']        = 'stored_data_controller/add_stored_data_post';
$route['admin/trash-stored-data']           = 'stored_data_controller/trash_stored_data';
$route['admin/get-trash-stored-data']       = 'stored_data_controller/get_trash_stored_data';
$route['admin/stored-data-status']          = 'stored_data_controller/stored_data_status';
$route['admin/restore-stored-data']         = 'stored_data_controller/restore_item';
$route['admin/edit-stored-data/(:num)']     = 'stored_data_controller/edit_stored_data/$1';
$route['admin/edit-stored-data-post']       = 'stored_data_controller/edit_stored_data_post';
$route['admin/approve-multi-stored-items']  = 'stored_data_controller/approve_multi_items';

/**
 * Iovoice Section
 */

$route['admin/manage-invoice']              = 'invoice_controller/invoice_list';
$route['admin/invoice-link']                = 'invoice_controller/invoice_link';
$route['admin/add-invoice']                 = 'invoice_controller/add_invoice';
$route['admin/add-invoice-post']            = 'invoice_controller/add_invoice_post';
$route['admin/edit-invoice/(:num)']         = 'invoice_controller/edit_invoice/$1';
$route['admin/edit-invoice-post']           = 'invoice_controller/edit_invoice_post';
$route['admin/send-invoice-email']          = 'invoice_controller/send_invoice_email';

/**
 * Brand Section
 */

$route['admin/manage-brand']                = 'brand_controller/brand_list';
$route['admin/add-brand']                   = 'brand_controller/add_brand';
$route['admin/add-brand-post']              = 'brand_controller/add_brand_post';
$route['admin/edit-brand/(:num)']           = 'brand_controller/edit_brand/$1';
$route['admin/edit-brand-post']             = 'brand_controller/edit_brand_post';



/**
 * Mobile Bank Settings Section
 */

// Manual
$route['admin/payment/bkash']               = 'mobile_bank_controller/bkash_settings';
$route['admin/payment/rocket']              = 'mobile_bank_controller/rocket_settings';
$route['admin/payment/nagad']               = 'mobile_bank_controller/nagad_settings';
$route['admin/payment/upay']                = 'mobile_bank_controller/upay_settings';
$route['admin/payment/cellfin']             = 'mobile_bank_controller/cellfin_settings';
$route['admin/payment/tap']                 = 'mobile_bank_controller/tap_settings';
$route['admin/payment/okwallet']            = 'mobile_bank_controller/okwallet_settings';
$route['admin/payment/ipay']                = 'mobile_bank_controller/ipay_settings';
$route['admin/update-mobile-bank']          = 'mobile_bank_controller/update_mobile_bank_post';

// API
$route['admin/manage-mobile-bank-api']       = 'mobile_bank_controller/mobile_bank_list';
$route['admin/add-mobile-bank']              = 'mobile_bank_controller/add_mobile_bank';
$route['admin/add-mobile-bank-post']         = 'mobile_bank_controller/add_mobile_bank_post';
$route['admin/edit-mobile-bank/(:num)']      = 'mobile_bank_controller/edit_mobile_bank/$1';
$route['admin/edit-mobile-bank-post']        = 'mobile_bank_controller/edit_mobile_bank_post';


/**
 * Bank Settings Section
 */

$route['admin/manage-bank']                  = 'bank_controller/bank_list';
$route['admin/add-bank']                     = 'bank_controller/add_bank';
$route['admin/add-bank-post']                = 'bank_controller/add_bank_post';
$route['admin/edit-bank/(:num)']             = 'bank_controller/edit_bank/$1';
$route['admin/edit-bank-post']               = 'bank_controller/edit_bank_post';
$route['admin/bank-status']                  = 'bank_controller/bank_status';


/**
 * International Settings Section
 */
$route['admin/international-method/paypal']                 = 'international_controller/paypal';
$route['admin/international-method/paypal-personal']        = 'international_controller/paypal_personal';
$route['admin/international-method/stripe']                 = 'international_controller/stripe';
$route['admin/international-method/paddle']                 = 'international_controller/paddle';
$route['admin/international-method/perfect-money']          = 'international_controller/perfect_money';
$route['admin/update-international-methods']                = 'international_controller/update_methods';

$route['admin/manage-international-methods']        = 'international_controller/list';
$route['admin/add-international-method']            = 'international_controller/add';
$route['admin/store-international-method']          = 'international_controller/store';
$route['admin/edit-international-method/(:num)']    = 'international_controller/edit/$1';
$route['admin/update-international-method']         = 'international_controller/update';


/**
 * FAQ Section
 */

$route['admin/manage-faq']                  = 'faq_controller/faq_list';
$route['admin/add-faq']                     = 'faq_controller/add_faq';
$route['admin/add-faq-post']                = 'faq_controller/add_faq_post';
$route['admin/edit-faq/(:num)']             = 'faq_controller/edit_faq/$1';
$route['admin/edit-faq-post']               = 'faq_controller/edit_faq_post';


/**
 * ResellerClub Section
 */

$route['admin/manage-resellerclub-api']       = 'resellerclub_controller/resellerclub_api_list';
$route['admin/add-resellerclub-api']          = 'resellerclub_controller/add_resellerclub_api';
$route['admin/add-resellerclub-api-post']     = 'resellerclub_controller/add_resellerclub_api_post';
$route['admin/edit-resellerclub-api/(:num)']  = 'resellerclub_controller/edit_resellerclub_api/$1';
$route['admin/edit-resellerclub-api-post']    = 'resellerclub_controller/edit_resellerclub_api_post';


/**
 * ResellerCamp Section
 */

$route['admin/manage-resellercamp-api']       = 'resellercamp_controller/resellercamp_api_list';
$route['admin/add-resellercamp-api']          = 'resellercamp_controller/add_resellercamp_api';
$route['admin/add-resellercamp-api-post']     = 'resellercamp_controller/add_resellercamp_api_post';
$route['admin/edit-resellercamp-api/(:num)']  = 'resellercamp_controller/edit_resellercamp_api/$1';
$route['admin/edit-resellercamp-api-post']    = 'resellercamp_controller/edit_resellercamp_api_post';



/**
 * Staff Section
 */

$route['admin/manage-staffs']                  = 'addons/staffs_controller/list';
$route['admin/add-staff']                      = 'addons/staffs_controller/add_staff';
$route['admin/add-staff-post']                 = 'addons/staffs_controller/add_staff_post';
$route['admin/edit-staff/(:num)']              = 'addons/staffs_controller/edit_staff/$1';
$route['admin/edit-staff-post']                = 'addons/staffs_controller/edit_staff_post';

/**
 * Role Section
 */

$route['admin/manage-roles']                    = 'addons/staffs_controller/role_list';
$route['admin/add-role']                        = 'addons/staffs_controller/add_role';
$route['admin/add-role-post']                   = 'addons/staffs_controller/add_role_post';
$route['admin/edit-role/(:num)']                = 'addons/staffs_controller/edit_role/$1';
$route['admin/edit-role-post']                  = 'addons/staffs_controller/edit_role_post';


/**
 * System Settings Section
 */

$route['admin/app-settings']                = 'settings_controller/app_settings';
$route['admin/cron-settings']               = 'settings_controller/cron_settings';
$route['admin/template-settings']           = 'settings_controller/template_settings';
$route['admin/custom-css']                  = 'settings_controller/custom_css';
$route['admin/mail-settings']               = 'settings_controller/mail_settings';
$route['admin/test-mail']                   = 'settings_controller/test_mail';
$route['admin/sms-settings']                = 'settings_controller/sms_settings';
$route['admin/sms-template']                = 'settings_controller/sms_template';
$route['admin/test-sms']                    = 'settings_controller/test_sms';
$route['admin/notification/onesignal']      = 'settings_controller/onesignal_notification';
$route['admin/notification/email']          = 'settings_controller/email_notification';
$route['admin/notification/sms']            = 'settings_controller/sms_notification';


/**
 * Addon
 */

$route['admin/manage-addons']              = 'settings_controller/manage_addons';
$route['admin/upload-addon']               = 'settings_controller/upload_addon';
$route['admin/activate-addon']             = 'settings_controller/activate_addon';
$route['admin/deactive-addon']             = 'settings_controller/deactive_addon';



/**
 * Active License
 */

$route['admin/active-license']              = 'admin_controller/active_license';
$route['admin/active-license-post']         = 'admin_controller/active_license_post';


/**
 * Password Reset Section
 */

$route['admin/change-password']             = 'admin_controller/change_password';
$route['admin/change-password-post']        = 'admin_controller/change_password_post';


/**
 * Update Section
 */

$route['admin/check-updates']               = 'admin_controller/check_updates';
