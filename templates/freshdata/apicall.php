<?php
$api_call = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/monitors.php";
$api_call2 = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/monitors.php?uuid=93ac6418-e1a7-5697-a117-fd8ef9453826";
$api_call3 = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/monitors.php?source=inaturalist&id=http://www.inaturalist.org/observations/142322";
?>
List all monitors / active searches: <a href="<?php echo $api_call ?>"><?php echo $api_call ?></a><p>
Select a single monitor by uuid: <a href="<?php echo $api_call2 ?>"><?php echo $api_call2 ?></a><p>
Find monitors that include occurrence id http://www.inaturalist.org/observations/142322 from inaturalist: <a href="<?php echo $api_call3 ?>"><?php echo $api_call3 ?></a><p>