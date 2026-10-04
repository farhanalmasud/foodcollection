<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config['base_url'] = "https://" . $_SERVER['HTTP_HOST'];
$config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
$config['index_page'] = '';
$config['uri_protocol']    = 'REQUEST_URI';
$config['url_suffix'] = '';
$config['language']    = 'english';
$config['charset'] = 'UTF-8';
$config['enable_hooks'] = FALSE;
$config['subclass_prefix'] = 'Core_';
$config['composer_autoload'] = 'app/third_party/vendor/autoload.php';
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';
$config['allow_get_array'] = TRUE;
$config['log_threshold'] = 0;
$config['log_path'] = '';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format'] = 'Y-m-d H:i:s';
$config['error_views_path'] = '';
$config['cache_path'] = '';
$config['cache_query_string'] = FALSE;
$config['encryption_key'] = 'ebafffcae0bc45d1f42d';
$config['sess_driver'] = 'database';
$config['sess_cookie_name'] = 'rt_8beefc92b0_session';
$config['sess_expiration'] = 86400; // 24 hours
$config['sess_save_path'] = 'ci_sessions';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;
$config['cookie_prefix']    = '';
$config['cookie_domain']    = '';
$config['cookie_path']        = '/';
$config['cookie_secure']    = FALSE;
$config['cookie_httponly']     = FALSE;
$config['standardize_newlines'] = FALSE;
$config['global_xss_filtering'] = FALSE;
$config['csrf_protection'] = TRUE;
$config['csrf_token_name'] = 'csrf_rt_66b314f7e4_token';
$config['csrf_cookie_name'] = 'csrf_rt_db95217d4d_cookie';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = FALSE;
$config['csrf_exclude_uris'] = [
    'login-post',
    'verify-license-post',
    'forgot-password-post',
    'upload.*+',
    'api.*+',
    'callback.*+',
    'checkout.*+',
    'paddle/callback',
    'perfectmoney/callback',
    'paypal-personal/callback'
];

$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips'] = '';
