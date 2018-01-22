<?php
require_once("../../../LiteratureEditor/Custom/lib/Functions.php");
require_once("../../controllers/other.php");
require_once("../../controllers/freshdata.php");

$params =& $_GET;
if(!$params) $params =& $_POST;

$ctrler = new freshdata_controller($params);
sleep(1);

if($ctrler->save_to_text($params))
{
    $ctrler->display_message(array('type' => "highlight", 'msg' => "Record has been successfully un-deleted."));
    ?>
    <?php
}
?>
