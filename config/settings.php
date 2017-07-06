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
// define('SCISTARTER_API_KEY', 'e32de5b4a92bfbb18c519158b2ff93b89016c26f080c39752d8e6584eee6d4cdea496f1e2ce0200adc3263eb8fb09bd867049a2e33d2657751a34e5e5124aa1e'); //Eli's
define('SCISTARTER_API_KEY', '148dccccf90627b4c6eb4c59fb86954758227c86da437c05607acd4e72533874ef9277ffd3d55246d32ccf1f0e43d504e441273df2ecb206abdb14f4bcd245d1'); //Jen's

// /* for Archive server - remote
define('CACHE_PATH', '/var/www/html/cache_LiteratureEditor/');  //for archive
define('FRESHDATA_DOMAIN', 'http://gimmefreshdata.github.io/'); //e.g. http://gimmefreshdata.github.io/monitors.html
define('SCISTARTER_ADD_PROJECT_API', 'https://scistarter.com/api/project/add/');  //for archive
define('WGET_PATH', '/usr/bin/wget');  //for archive
define('JENKINS_DOMAIN', 'http://localhost:8080');  //for archive
define('JENKINS_USER_TOKEN', 'eli:xxx');  //for archive
// */

/* for Mac Mini - local
define('CACHE_PATH', '/Volumes/MacMini_HD2/cache_LiteratureEditor/');   //for mac mini
// define('FRESHDATA_DOMAIN', 'http://localhost:4000/');                   //e.g. http://localhost:4000/monitors.html
define('FRESHDATA_DOMAIN', 'http://gimmefreshdata.github.io/'); //e.g. http://gimmefreshdata.github.io/monitors.html
define('SCISTARTER_ADD_PROJECT_API', 'http://localhost/eli.php');  //for mac mini
define('WGET_PATH', '/opt/local/bin/wget');  //for mac mini
define('JENKINS_DOMAIN', 'localhost:8080');  //for mac mini
define('JENKINS_USER_TOKEN', 'eli:b2e5ca02f73b5c7d716449c763e120dd');  //for mac mini
*/

?>
