<?php
$api_call = HTTP_PROTOCOL . $_SERVER['SERVER_NAME'] . "/FreshData/monitors.php";
$api_call2 = HTTP_PROTOCOL . $_SERVER['SERVER_NAME'] . "/FreshData/monitors.php?uuid=93ac6418-e1a7-5697-a117-fd8ef9453826";
$api_call3 = HTTP_PROTOCOL . $_SERVER['SERVER_NAME'] . "/FreshData/monitors.php?source=inaturalist&id=http://www.inaturalist.org/observations/142322";
?>
List all monitors / active searches: <a href="<?php echo $api_call ?>"><?php echo $api_call ?></a><p>
Select a single monitor by uuid: <a href="<?php echo $api_call2 ?>"><?php echo $api_call2 ?></a><p>
Find monitors that include occurrence id <i>http://www.inaturalist.org/observations/142322</i> from <i>inaturalist</i>: <a href="<?php echo $api_call3 ?>"><?php echo $api_call3 ?></a><p>