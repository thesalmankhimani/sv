<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

// define constants
define('APP_URL', 'http://mystreamviewer.com/');

define('APP_TITLE', 'Stream Viewer Sample');

// DB
define('DB_HOST', 'localhost');
define('DB_USER', 'db_user');
define('DB_PASS', 'db_pass');
define('DB_NAME', 'db_name');
define('DB_DATE_FORMAT', 'Y-m-d H:i:s');

// GOOGLE
define('GOOGLE_SERVER_KEY', 'myserverkey');
define('GOOGLE_CLIENT_ID', 'myclientid.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', 'client_secret');
define('GOOGLE_SIGNIN_SCOPE', 'profile email');
define('GOOGLE_SITE_VERIFICATION', 'site_verification_key');

// general
define('DIR_VIEWS', 'views/');


// start session
@session_start(); // suppress, as we might be utilizing it in various pages

/**
 * Autoload classes
 */
spl_autoload_register(function ($class_name) {
    include_once 'classes/' . $class_name . '.class.php';
});


// load defaults
$common_class = new Common();