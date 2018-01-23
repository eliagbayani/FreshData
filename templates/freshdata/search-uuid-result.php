<?php
require_once("../../config/settingz.php");
require_once("../../../LiteratureEditor/Custom/lib/Functions.php");
require_once("../../controllers/other.php");
require_once("../../controllers/freshdata.php");

$params =& $_GET;
if(!$params) $params =& $_POST;

// echo "<pre>"; print_r($params); echo "</pre>";

$ctrler = new freshdata_controller($params);
sleep(1);
$uuid = $params['uuid'];



// if($monitor = $ctrler->get_monitor_record($uuid)) {
if($monitor = $ctrler->get_text_file_value($uuid, "lookup")) {
    if($monitor['String'])
    {
        $ctrler->display_message(array('type' => "error", 'msg' => "Monitor with UUID [$uuid] already exists in Monitors V2"));
        ?>
        <br>
        <form action="index.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="monitorAPI"  value="0">
        <input type="hidden" name="view_type"   value="create_new_monitor">
        <input type="submit" value="Search another...">
        </form>
        <?php
    }
    else 
    {
        // $ctrler->display_message(array('type' => "highlight", 'msg' => "Monitor with UUID [$uuid] DOES NOT EXIST Monitors V2 01")); //debug purposes only
        if($monitor = $ctrler->search_effechecka_uuid($uuid)) {
            // print_r($monitor);
            $ctrler->display_message(array('type' => "highlight", 'msg' => "Monitor exists. You can create a monitor for this UUID: <i><b>$uuid</b></i>."));
            // require("templates/freshdata/monitor-orig-api-data.php");
            require("../../templates/freshdata/monitor-orig-api-data.php");
            require_once("../../config/script-below-entry.html");
        }
        else {
            $ctrler->display_message(array('type' => "error", 'msg' => "UUID not found in effechecka server."));
        }
    }
}
else //may not go here ever...
{
    $ctrler->display_message(array('type' => "highlight", 'msg' => "Monitor with UUID [$uuid] DOES NOT Monitors V2 02"));
}



?>
<br>
<form action="index.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="monitorAPI"  value="0">
<input type="hidden" name="view_type"   value="admin">
<input type="submit" value="Proceed">
</form>
<?php


/* copied elsewhere...
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
*/

?>





