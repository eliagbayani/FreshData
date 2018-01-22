<?php
require_once("../../../LiteratureEditor/Custom/lib/Functions.php");
require_once("../../controllers/other.php");
require_once("../../controllers/freshdata.php");

$params =& $_GET;
if(!$params) $params =& $_POST;

// echo "<pre>"; print_r($params); echo "</pre>";

$ctrler = new freshdata_controller($params);
sleep(1);

if($ctrler->save_to_text($params))
{
    $ctrler->display_message(array('type' => "highlight", 'msg' => "Record has been successfully deleted. Click <b><a href='index.php?view_type=admin&monitorAPI=0'>Proceed</a></b>."));
    if($ctrler->manually_added_monitor($params['uuid_archive'])) $ctrler->delete_manually_added_uuid($params);
    ?>
    <br>
    <form action="index.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="monitorAPI"  value="0">
    <input type="hidden" name="view_type"   value="admin">
    <input type="submit" value="Proceed">
    
    <!--- working for the longest time, but no longer needed now.
    <table>
    <tr><td colspan="2"><hr><b>Archive Info:</b><hr></td></tr>
    <?php
    $fields = array("uuid_archive", "Taxa", "Status", "Records", "Trait_selector", "String", "tsv_url");
    foreach($fields as $field)
    {
        echo "<tr><td>$field:</td><td id='value'>".$params[$field]."</td></tr>";
    }
    ?>
    <tr><td colspan="2"><hr><b>Additional Fields:</b><hr></td></tr>
    <tr><td>Title:</td>        <td id="value"><?php echo $params['Title']       ?></td></tr>
    <tr><td>Description:</td>  <td id="value"><?php echo $params['Description'] ?></td></tr>
    <tr><td>URL:</td>          <td id="value"><?php echo $params['URL']         ?></td></tr>
    <tr><td>Training materials:</td> <td id="value"><?php echo $params['Training_materials'] ?></td></tr>
    <tr><td>Contact:</td>            <td id="value"><?php echo $params['Contact']            ?></td></tr>
    </table>
    --->
    <?php
}
?>