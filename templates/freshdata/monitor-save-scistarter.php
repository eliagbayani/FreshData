<?php
require_once("../../../LiteratureEditor/Custom/lib/Functions.php");
require_once("../../controllers/other.php");
require_once("../../controllers/freshdata.php");

$params =& $_GET;
if(!$params) $params =& $_POST;

$ctrler = new freshdata_controller($params);
sleep(1);

// echo "<pre>"; print_r($params); echo "</pre>";
if($ctrler->save_to_text_scistarter($params))
{
    echo "<br><span id='memo'>Saved OK</span><br><br>";
    ?>
    <table>
    <tr><td>name:</td>         <td id="value"><?php echo $params['name'] ?></td></tr>
    <tr><td>description:</td>  <td id="value"><?php echo $params['description'] ?></td></tr>
    <tr><td>url:</td>          <td id="value"><?php echo $params['url'] ?></td></tr>
    <tr><td>contact_name:</td> <td id="value"><?php echo $params['contact_name'] ?></td></tr>
    </table>
    <?php
}
?>