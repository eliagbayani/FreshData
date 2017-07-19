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
$params['uuid'] = $argv[1];
$params['date_from'] = @$argv[2];
$params['date_to'] = @$argv[3];

$ctrler = new freshdata_controller();
$ctrler->apply_invasive_filter($params);
?>
