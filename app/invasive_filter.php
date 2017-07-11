<?php 
include_once(dirname(__FILE__) . "/../config/settingz.php");

/* not for command line
$params =& $_GET;
if(!$params) $params =& $_POST;
*/

require_once(dirname(__FILE__) . "/../../LiteratureEditor/Custom/lib/Functions.php");
require_once(dirname(__FILE__) . "/../controllers/other.php");
require_once(dirname(__FILE__) . "/../controllers/freshdata.php");

// print_r($argv);

$ctrler = new freshdata_controller();
$ctrler->apply_invasive_filter($argv[1]); //argument is the uuid
?>

