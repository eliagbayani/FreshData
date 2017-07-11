<?php
require_once("../../../LiteratureEditor/Custom/lib/Functions.php");
require_once("../../controllers/other.php");
require_once("../../controllers/freshdata.php");

$params =& $_GET;
if(!$params) $params =& $_POST;
$ctrler = new freshdata_controller($params);
sleep(1);

echo "<pre>"; print_r($params); echo "</pre>";

// if($ctrler->save_to_text($params))
if(true)
{
    $ctrler->display_message(array('type' => "highlight", 'msg' => "Invasive: Processing done."));
    ?>
    <?php
}
?>

<form action="index.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="uuid"        value="<?php echo $params['uuid'] ?>">
<input type="hidden" name="monitorAPI"  value="0">
<input type="hidden" name="view_type"   value="admin">
<input type="hidden" name="queries"     value="2"><!---Special Queries--->
<br><br><input type="submit" value="Continue 4">

