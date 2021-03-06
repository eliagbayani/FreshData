<?php
require_once("../../../LiteratureEditor/Custom/lib/Functions.php");
require_once("../../controllers/other.php");
require_once("../../controllers/freshdata.php");

$params =& $_GET;
if(!$params) $params =& $_POST;

$ctrler = new freshdata_controller($params);
sleep(1);

// echo "<pre>"; print_r($params); echo "</pre>";
if($ctrler->save_to_text($params))
{
    $ctrler->save_manually_added_uuid($params['uuid_archive']);
    
    // echo "<br><span id='memo'>Saved OK</span><br>";
    $ctrler->display_message(array('type' => "highlight", 'msg' => "Record has been successfully created. Click <b>Proceed</b>."));
    ?>
    <br>
    <form action="index.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="uuid"        value="<?php echo $params['uuid'] ?>">
    <input type="hidden" name="monitorAPI"  value="">
    <input type="hidden" name="view_type"   value="admin">
    <input type="hidden" name="queries"     value="0">
    <input type="submit" value="Proceed">
    
    <table>
    <tr><td colspan="2"><hr><b>Archive Info:</b><hr></td></tr>
    <?php
    $ctrler->main_fields_display($params);
    ?>
    <tr><td colspan="2"><hr><b>Additional Fields:</b><hr></td></tr>
    <tr><td>Title:</td>        <td id="value"><?php echo $params['Title']       ?></td></tr>
    <tr><td>Description:</td>  <td id="value"><?php echo $params['Description'] ?></td></tr>
    <tr><td>URL:</td>          <td id="value"><?php echo $params['URL']         ?></td></tr>
    <tr><td>Training materials:</td> <td id="value"><?php echo $params['Training_materials'] ?></td></tr>
    <tr><td>Contact:</td>            <td id="value"><?php echo $params['Contact']            ?></td></tr>
    </table>
    <?php
}
?>