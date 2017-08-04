<?php 
include_once(dirname(__FILE__) . "/../config/settingz.php");

$params =& $_GET;
if(!$params) $params =& $_POST;

require_once(dirname(__FILE__) . "/../../LiteratureEditor/Custom/lib/Functions.php");
require_once(dirname(__FILE__) . "/../controllers/other.php");
require_once(dirname(__FILE__) . "/../controllers/freshdata.php");

$ctrler = new freshdata_controller();

print_r($params);

$rec_from_text = $ctrler->get_text_file_value($params['uuid'], "lookup");
// print_r($rec_from_text);
if($search_url = $ctrler->generate_freshdata_search_url($rec_from_text)) header("Location: $search_url");
else echo "<hr>ID not found: ".$params['uuid']."<hr>";
?>
