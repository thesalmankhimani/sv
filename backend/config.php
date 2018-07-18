<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

// define constants
if (preg_match('/localhost/', $_SERVER['HTTP_HOST'])) {
    define('APP_URL', 'http://theappsgalore.localhost/sv/');
} else {
    define('APP_URL', 'http://theappsgalore.com/sv/');
}

define('APP_TITLE', 'Stream Viewer Sample');

// DB
define('DB_HOST', 'localhost');
define('DB_USER', 'sv_user');
define('DB_PASS', 'sv_pass123');
define('DB_NAME', 'sv_db');
define('DB_DATE_FORMAT', 'Y-m-d H:i:s');

// GOOGLE
define('GOOGLE_SERVER_KEY', 'AIzaSyCiyZrTTlc6xWtOMX3DcWgKJjbVRl1_E_o');
define('GOOGLE_CLIENT_ID', '666918434391-n8o1qh503r6c1c854hnkfb47m1fej8gh.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', 'xpL93RNSPfGUjGnowXM_mL3C');
define('GOOGLE_SIGNIN_SCOPE', 'profile email');
define('GOOGLE_SITE_VERIFICATION', 'ruaRDD_lNeI396phJkcww2Y5NiSm5oWn9Spgc2pqAfE');

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