<?php
require_once("../../../LiteratureEditor/Custom/lib/Functions.php");

require_once("../../controllers/other.php");
require_once("../../controllers/freshdata.php");

$params =& $_GET;
if(!$params) $params =& $_POST;

$ctrler = new freshdata_controller($params);

// echo "<pre>"; print_r($params); echo "</pre>";
if($ctrler->save_to_text($params))
{
    echo "<br><span id='memo'>Saved OK</span><br><br>";
    ?>
    <table>
    <tr><td>Title</td>        <td>: <?php echo $params['Title']       ?></td></tr>
    <tr><td>Description</td>  <td>: <?php echo $params['Description'] ?></td></tr>
    <tr><td>URL</td>          <td>: <?php echo $params['URL']         ?></td></tr>
    </table>
    <?php
}
?>