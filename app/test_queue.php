<?php 
include_once(dirname(__FILE__) . "/../config/settingz.php");

// /*
$params =& $_GET;
if(!$params) $params =& $_POST;
// */

require_once(dirname(__FILE__) . "/../../LiteratureEditor/Custom/lib/Functions.php");
require_once(dirname(__FILE__) . "/../controllers/other.php");
require_once(dirname(__FILE__) . "/../controllers/freshdata.php");


$ctrler = new freshdata_controller($params);
$job_name = $ctrler->get_least_number_from_queued_items('eol_stats_job');
echo "\n[$job_name]\n";
?>

