<?php

/**
 * UddoktaPay
 *
 * UddoktaPay is a self-hosted payment automation software. Which is made for small entrepreneurs in Bangladesh.
 *
 * @package	UddoktaPay
 * @author UddoktaPay Team
 * @license	https://uddoktapay.com
 * @copyright Copyright (c) 2021-2023, UddoktaPay. (https://uddoktapay.com)
 */



/*
 * Set timezone to Asia/Dhaka.
 */
date_default_timezone_set("Asia/Dhaka");

/*
 * Check minimum requirements.
 */

if (version_compare(PHP_VERSION, '7.4.0') < 0) {
	die("Current PHP version is " . phpversion() . "! PHP version required for running UddoktaPay is PHP 7.4. Please check and upgrade your current PHP version.");
}

if (!function_exists('ioncube_loader_version')) {
	die("ionCube Loader function is missing! UddoktaPay requires ionCube Loader function to run, Please check and enable the extension or Contact with hosting provider.");
}

function GetIonCubeLoaderVersionForUddoktaPay()
{
	if (function_exists('ioncube_loader_version')) {
		$version = ioncube_loader_version();
		$a = explode('.', $version);
		$count = count($a);
		if ($count == 3) {
			return $version;
		} elseif ($count == 2) {
			return $version . ".0";
		} elseif ($count == 1) {
			return $version . ".0.0";
		}
		$version = implode('.', array_slice($a, 0, 3));
		return $version;
	}
	return 'Not Found!';
}

if (version_compare(GetIonCubeLoaderVersionForUddoktaPay(), '12.0.0') < 0) {
	die("Current ionCube Loader version is " . GetIonCubeLoaderVersionForUddoktaPay() . "! minimum ionCube Loader version required for running UddoktaPay is 12.0.0. Please check and upgrade your current ionCube Loader version or Contact with hosting provider.");
}

if (!extension_loaded('mysqli')) {
	die("Mysqli PHP extension missing! UddoktaPay requires Mysqli PHP extension to run, Please check and enable the extension.");
}
if (!extension_loaded('curl')) {
	die("cURL PHP extension missing! UddoktaPay requires cURL PHP extension to run, Please check and enable the extension.");
}
if (!extension_loaded('fileinfo')) {
	die("Fileinfo PHP extension missing! UddoktaPay requires Fileinfo PHP extension to run, Please check and enable the extension.");
}
if (!extension_loaded('openssl')) {
	die("Openssl PHP extension missing! UddoktaPay requires Openssl PHP extension to run, Please check and enable the extension.");
}
if (!extension_loaded('zip')) {
	die("ZIP PHP extension missing! UddoktaPay requires ZIP PHP extension to run, Please check and enable the extension.");
}
if (!extension_loaded('bcmath')) {
	die("BCMath PHP extension missing! UddoktaPay requires BCMath PHP extension to run, Please check and enable the extension.");
}
if (!extension_loaded('ctype')) {
	die("Ctype PHP extension missing! UddoktaPay requires Ctype PHP extension to run, Please check and enable the extension.");
}
if (!extension_loaded('json')) {
	die("JSON PHP extension missing! UddoktaPay requires JSON PHP extension to run, Please check and enable the extension.");
}
if (!extension_loaded('mbstring')) {
	die("Mbstring PHP extension missing! UddoktaPay requires Mbstring PHP extension to run, Please check and enable the extension.");
}
if (!extension_loaded('xml')) {
	die("XML PHP extension missing! UddoktaPay requires XML PHP extension to run, Please check and enable the extension.");
}
if (!extension_loaded('tokenizer')) {
	die("Tokenizer PHP extension missing! UddoktaPay requires Tokenizer PHP extension to run, Please check and enable the extension.");
}

/*
 * Check if the UddoktaPay installation file exists.
 */
$installFile = "install/install.uddoktapay";
if (is_file($installFile)) {
	header('Location: install');
	exit();
}


/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     testing
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 */
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'production');

/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */
switch (ENVIRONMENT) {
	case 'development':
		error_reporting(-1);
		ini_set('display_errors', 1);
		break;

	case 'testing':
	case 'production':
		ini_set('display_errors', 0);
		if (version_compare(PHP_VERSION, '5.3', '>=')) {
			error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
		} else {
			error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
		}
		break;

	default:
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'The application environment is not set correctly.';
		exit(1); // EXIT_ERROR
}

/*
 *---------------------------------------------------------------
 * SYSTEM DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" directory.
 * Set the path if it is not in the same directory as this file.
 */
$system_path = 'core';

/*
 *---------------------------------------------------------------
 * APPLICATION DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * directory than the default one you can set its name here. The directory
 * can also be renamed or relocated anywhere on your server. If you do,
 * use an absolute (full) server path.
 * For more info please see the user guide:
 *
 * https://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
 */
$application_folder = 'app';

/*
 *---------------------------------------------------------------
 * VIEW DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * If you want to move the view directory out of the application
 * directory, set the path to it here. The directory can be renamed
 * and relocated anywhere on your server. If blank, it will default
 * to the standard location inside your application directory.
 * If you do move this, use an absolute (full) server path.
 *
 * NO TRAILING SLASH!
 */
$view_folder = '';


/*
 * --------------------------------------------------------------------
 * DEFAULT CONTROLLER
 * --------------------------------------------------------------------
 *
 * Normally you will set your default controller in the routes.php file.
 * You can, however, force a custom routing by hard-coding a
 * specific controller class/function here. For most applications, you
 * WILL NOT set your routing here, but it's an option for those
 * special instances where you might want to override the standard
 * routing in a specific front controller that shares a common CI installation.
 *
 * IMPORTANT: If you set the routing here, NO OTHER controller will be
 * callable. In essence, this preference limits your application to ONE
 * specific controller. Leave the function name blank if you need
 * to call functions dynamically via the URI.
 *
 * Un-comment the $routing array below to use this feature
 */
// The directory name, relative to the "controllers" directory.  Leave blank
// if your controller is not in a sub-directory within the "controllers" one
// $routing['directory'] = '';

// The controller class file name.  Example:  mycontroller
// $routing['controller'] = '';

// The controller function you wish to be called.
// $routing['function']	= '';


/*
 * -------------------------------------------------------------------
 *  CUSTOM CONFIG VALUES
 * -------------------------------------------------------------------
 *
 * The $assign_to_config array below will be passed dynamically to the
 * config class when initialized. This allows you to set custom config
 * items or override any default config values found in the config.php file.
 * This can be handy as it permits you to share one application between
 * multiple front controller files, with each file containing different
 * config values.
 *
 * Un-comment the $assign_to_config array below to use this feature
 */
// $assign_to_config['name_of_config_item'] = 'value of config item';



// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE
// --------------------------------------------------------------------

/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */

// Set the current directory correctly for CLI requests
if (defined('STDIN')) {
	chdir(dirname(__FILE__));
}

if (($_temp = realpath($system_path)) !== FALSE) {
	$system_path = $_temp . DIRECTORY_SEPARATOR;
} else {
	// Ensure there's a trailing slash
	$system_path = strtr(
		rtrim($system_path, '/\\'),
		'/\\',
		DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
	) . DIRECTORY_SEPARATOR;
}

// Is the system path correct?
if (!is_dir($system_path)) {
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: ' . pathinfo(__FILE__, PATHINFO_BASENAME);
	exit(3); // EXIT_CONFIG
}

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */
// The name of THIS file
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

// Path to the system directory
define('BASEPATH', $system_path);

// Path to the front controller (this file) directory
define('FCPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);

// Name of the "system" directory
define('SYSDIR', basename(BASEPATH));

// The path to the "application" directory
if (is_dir($application_folder)) {
	if (($_temp = realpath($application_folder)) !== FALSE) {
		$application_folder = $_temp;
	} else {
		$application_folder = strtr(
			rtrim($application_folder, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
		);
	}
} elseif (is_dir(BASEPATH . $application_folder . DIRECTORY_SEPARATOR)) {
	$application_folder = BASEPATH . strtr(
		trim($application_folder, '/\\'),
		'/\\',
		DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
	);
} else {
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: ' . SELF;
	exit(3); // EXIT_CONFIG
}

define('APPPATH', $application_folder . DIRECTORY_SEPARATOR);

// The path to the "views" directory
if (!isset($view_folder[0]) && is_dir(APPPATH . 'views' . DIRECTORY_SEPARATOR)) {
	$view_folder = APPPATH . 'views';
} elseif (is_dir($view_folder)) {
	if (($_temp = realpath($view_folder)) !== FALSE) {
		$view_folder = $_temp;
	} else {
		$view_folder = strtr(
			rtrim($view_folder, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
		);
	}
} elseif (is_dir(APPPATH . $view_folder . DIRECTORY_SEPARATOR)) {
	$view_folder = APPPATH . strtr(
		trim($view_folder, '/\\'),
		'/\\',
		DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
	);
} else {
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: ' . SELF;
	exit(3); // EXIT_CONFIG
}

define('VIEWPATH', $view_folder . DIRECTORY_SEPARATOR);

/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 */
require_once BASEPATH . 'core/CodeIgniter.php';
