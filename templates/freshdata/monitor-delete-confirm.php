<?php
require_once("../../../LiteratureEditor/Custom/lib/Functions.php");
require_once("../../controllers/other.php");
require_once("../../controllers/freshdata.php");

$params =& $_GET;
if(!$params) $params =& $_POST;

// echo "<pre>"; print_r($params); echo "</pre>";

$ctrler = new freshdata_controller($params);
sleep(1);

if($ctrler->save_to_text($params)) {
    $ctrler->display_message(array('type' => "highlight", 'msg' => "Record has been successfully deleted. Click <b><a href='index.php?view_type=admin&monitorAPI=0'>Proceed</a></b>."));
    if($ctrler->manually_added_monitor($params['uuid_archive'])) $ctrler->delete_manually_added_uuid($params);
    ?>
    <br>
    <form action="index.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="monitorAPI"  value="0">
    <input type="hidden" name="view_type"   value="admin">
    <input type="submit" value="Proceed">
    <?php
}
?>
