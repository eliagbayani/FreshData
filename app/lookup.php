<?php 
include_once(dirname(__FILE__) . "/../config/settingz.php");

$params =& $_GET;
if(!$params) $params =& $_POST;

require_once(dirname(__FILE__) . "/../../LiteratureEditor/Custom/lib/Functions.php");
require_once(dirname(__FILE__) . "/../controllers/other.php");
require_once(dirname(__FILE__) . "/../controllers/freshdata.php");

/*
// print_r($argv);
$params['uuid'] = $argv[1];
$params['date_from'] = @$argv[2];
$params['date_to'] = @$argv[3];
$params['search_url'] = @$argv[4];
*/

$ctrler = new freshdata_controller();

print_r($params);

$rec_from_text = $ctrler->get_text_file_value($params['uuid'], "lookup");
// print_r($rec_from_text);
$search_url = $ctrler->generate_freshdata_search_url($rec_from_text); //new
header("Location: $search_url");

?>
