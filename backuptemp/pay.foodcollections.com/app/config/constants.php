<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code



defined('RT_API_DEBUG')                             OR define("RT_API_DEBUG", (ENVIRONMENT !== 'production') ? true : false);
defined('RT_SHOW_UPDATE_PROGRESS')                  OR define("RT_SHOW_UPDATE_PROGRESS", true);
defined('RT_TEXT_CONNECTION_FAILED')                OR define("RT_TEXT_CONNECTION_FAILED", 'Server is unavailable at the moment, please try again.');
defined('RT_TEXT_INVALID_RESPONSE')                 OR define("RT_TEXT_INVALID_RESPONSE", 'Server returned an invalid response, please contact support.');
defined('RT_TEXT_VERIFIED_RESPONSE')                OR define("RT_TEXT_VERIFIED_RESPONSE", 'Verified! Thanks for purchasing.');
defined('RT_TEXT_PREPARING_MAIN_DOWNLOAD')          OR define("RT_TEXT_PREPARING_MAIN_DOWNLOAD", 'Preparing to download main update...');
defined('RT_TEXT_MAIN_UPDATE_SIZE')                 OR define("RT_TEXT_MAIN_UPDATE_SIZE", 'Main Update size:');
defined('RT_TEXT_DONT_REFRESH')                     OR define("RT_TEXT_DONT_REFRESH", '(Please do not refresh the page).');
defined('RT_TEXT_DOWNLOADING_MAIN')                 OR define("RT_TEXT_DOWNLOADING_MAIN", 'Downloading main update...');
defined('RT_TEXT_UPDATE_PERIOD_EXPIRED')            OR define("RT_TEXT_UPDATE_PERIOD_EXPIRED", 'Your update period has ended or your license is invalid, please contact support.');
defined('RT_TEXT_UPDATE_PATH_ERROR')                OR define("RT_TEXT_UPDATE_PATH_ERROR", 'Folder does not have write permission or the update file path could not be resolved, please contact support.');
defined('RT_TEXT_MAIN_UPDATE_DONE')                 OR define("RT_TEXT_MAIN_UPDATE_DONE", 'Main update files downloaded and extracted.');
defined('RT_TEXT_UPDATE_EXTRACTION_ERROR')          OR define("RT_TEXT_UPDATE_EXTRACTION_ERROR", 'Update zip extraction failed.');
defined('RT_TEXT_PREPARING_SQL_DOWNLOAD')           OR define("RT_TEXT_PREPARING_SQL_DOWNLOAD", 'Preparing to download SQL update...');
defined('RT_TEXT_SQL_UPDATE_SIZE')                  OR define("RT_TEXT_SQL_UPDATE_SIZE", 'SQL Update size:');
defined('RT_TEXT_DOWNLOADING_SQL')                  OR define("RT_TEXT_DOWNLOADING_SQL", 'Downloading SQL update...');
defined('RT_TEXT_SQL_UPDATE_DONE')                  OR define("RT_TEXT_SQL_UPDATE_DONE", 'SQL update files downloaded.');
defined('RT_TEXT_UPDATE_WITH_SQL_IMPORT_FAILED')    OR define("RT_TEXT_UPDATE_WITH_SQL_IMPORT_FAILED", 'Application was successfully updated but automatic SQL importing failed, please import the downloaded SQL file in your database manually.');
defined('RT_TEXT_UPDATE_WITH_SQL_IMPORT_DONE')      OR define("RT_TEXT_UPDATE_WITH_SQL_IMPORT_DONE", 'Application was successfully updated and SQL file was automatically imported.');
defined('RT_TEXT_UPDATE_WITH_SQL_DONE')             OR define("RT_TEXT_UPDATE_WITH_SQL_DONE", 'Application was successfully updated, please import the downloaded SQL file in your database manually.');
defined('RT_TEXT_UPDATE_WITHOUT_SQL_DONE')          OR define("RT_TEXT_UPDATE_WITHOUT_SQL_DONE", 'Application was successfully updated, there were no SQL updates.');
defined('RT_TEXT_INVALID_DATA')                     OR define("RT_TEXT_INVALID_DATA", 'Invalid Data.');


defined('IS_AJAX')                                  OR define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
defined('DEMO_VERSION')                             OR define('DEMO_VERSION', FALSE);
defined('NOW')                                      OR define("NOW", date("Y-m-d H:i:s"));
