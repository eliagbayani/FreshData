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
    echo "<br><span id='memo'>Saved OK</span><br><br>";
    ?>
    <table>
    <tr><td>Title:</td>        <td id="value"><?php echo $params['Title']       ?></td></tr>
    <tr><td>Description:</td>  <td id="value"><?php echo $params['Description'] ?></td></tr>
    <tr><td>URL:</td>          <td id="value"><?php echo $params['URL']         ?></td></tr>
    <tr><td>Training materials:</td> <td id="value"><?php echo $params['Training_materials'] ?></td></tr>
    <tr><td>Contact:</td>            <td id="value"><?php echo $params['Contact']            ?></td></tr>
    
    <tr><td colspan="2"><hr>Archive Monitor Info<hr></td></tr>
    <?php
    $fields = array("uuid_archive", "Taxa", "Status", "Records", "Trait_selector", "String");
    foreach($fields as $field)
    {
        echo "<tr><td>$field:</td><td id='value'>".$params[$field]."</td></tr>";
    }
    ?>
    
    </table>
    <?php
}
?>