<?php
require_once("config/settings.php");
require_once("../LiteratureEditor/Custom/lib/Functions.php");
require_once("controllers/other.php");
require_once("controllers/freshdata.php");
$params = array();
$ctrler = new freshdata_controller($params);

/* working normal operation
$json = $ctrler->append_additional_fields();
header('Content-Type: application/json');
echo $json;
*/

$params =& $_GET;
if(!$params) $params =& $_POST;

if(!$params)                     $json = $ctrler->append_additional_fields();
elseif($uuid = @$params['uuid']) $json = $ctrler->params_is_uuid($uuid);
else
{
    $id = @$params['id'];
    $source = @$params['source'];
    $json = $ctrler->append_additional_fields($id, $source);
}

header('Content-Type: application/json');
echo $json;

/*
json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
$jsonurl='http://website.com/international.json';
$json = file_get_contents($jsonurl,0,null,null);
$json_output = json_decode($json, JSON_PRETTY_PRINT);
echo $json_output;
*/
?>