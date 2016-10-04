<?php
session_start();
/*
session_start([
    'cookie_lifetime' => 86400,
    'read_and_close'  => true,
]);
*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/New_York');

if(!defined('DOWNLOAD_WAIT_TIME')) define('DOWNLOAD_WAIT_TIME', '300000'); //.3 seconds
define('DOWNLOAD_ATTEMPTS', '2');
if(!defined('DOWNLOAD_TIMEOUT_SECONDS')) define('DOWNLOAD_TIMEOUT_SECONDS', '30');

define('DOC_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('DEVELOPER_EMAIL', 'eagbayani@eol.org');

/*
define('CACHE_PATH', '/var/www/html/cache_LiteratureEditor/');  //for archive
define('FRESHDATA_DOMAIN', 'http://gimmefreshdata.github.io/'); //e.g. http://gimmefreshdata.github.io/monitors.html
*/

define('CACHE_PATH', '/Volumes/MacMini_HD2/cache_LiteratureEditor/');   //for mac mini
define('FRESHDATA_DOMAIN', 'http://localhost:4000/');                   //e.g. http://localhost:4000/monitors.html

?>
