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
$admin_link = "index.php?view_type=admin&monitorAPI=".$params['monitorAPI'];

// if($monitor = $ctrler->get_monitor_record($uuid)) {
if($monitor = $ctrler->get_text_file_value($uuid, "lookup")) {
    if($monitor['String']) {
        $ctrler->display_message(array('type' => "error", 'msg' => "Monitor with UUID <i><b>$uuid</b></i> &nbsp;already exists in Monitors V2."));
        require("../../templates/freshdata/search-another-uuid-form.php");
    }
    else 
    {
        // $ctrler->display_message(array('type' => "highlight", 'msg' => "Monitor with UUID [$uuid] DOES NOT EXIST Monitors V2 01.")); //debug purposes only
        if($monitor = $ctrler->search_effechecka_uuid($uuid)) {
            // echo "<pre>"; print_r($monitor); echo "</pre>";
            $ctrler->display_message(array('type' => "highlight", 'msg' => "Monitor exists in effechecka with this UUID: <i><b>$uuid</b></i>. &nbsp;You can create this monitor here in Monitors V2."));
            require("../../templates/freshdata/monitor-orig-api-data.php");
            require("../../templates/freshdata/monitor-add-via-uuid.php");
            require_once("../../config/script-below-entry.html");
            // echo "<a href='".$admin_link."'>Cancel</a>"; //seems not needed anymore...
        }
        else {
            $ctrler->display_message(array('type' => "error", 'msg' => "UUID not found in effechecka server."));
            require("../../templates/freshdata/search-another-uuid-form.php");
        }
    }
}
else { //may not go here ever...
    $ctrler->display_message(array('type' => "highlight", 'msg' => "Monitor with UUID [$uuid] DOES NOT Monitors V2 02."));
}
?>
