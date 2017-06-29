<?php 
include_once(dirname(__FILE__) . "/../config/settings.php");

// /*
$params =& $_GET;
if(!$params) $params =& $_POST;
// */

require_once(dirname(__FILE__) . "/../../LiteratureEditor/Custom/lib/Functions.php");
require_once(dirname(__FILE__) . "/../controllers/other.php");
require_once(dirname(__FILE__) . "/../controllers/freshdata.php");


$ctrler = new freshdata_controller($params);
$ctrler->start_backup();
?>

