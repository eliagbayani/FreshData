<?php
require_once("../../../LiteratureEditor/Custom/lib/Functions.php");
require_once("../../controllers/other.php");
require_once("../../controllers/freshdata.php");

$params =& $_GET;
if(!$params) $params =& $_POST; //it is actually just a POST

$ctrler = new freshdata_controller($params);
sleep(1);

// echo "<pre>"; print_r($params); echo "</pre>";
if($ctrler->save_to_text_scistarter($params))
{
    ?>
    <br><span id='memo'>Project Info Saved OK</span><br>
    <table border="1" cellspacing="0">
        <?php
            $fields = other_controller::all_scistarter_fields();
            foreach($fields as $field) 
            {
                echo "<tr><td>$field:</td><td>";
                if(in_array($field, array("description"))) echo "<textarea rows='8' cols='100' readonly>$params[$field]</textarea>";
                elseif(in_array($field, array("contact_address"))) echo "<textarea rows='4' cols='100' readonly>$params[$field]</textarea>";
                else                                       echo $params[$field];
                echo "</td></tr>";
            }
        ?>
    </table>
    <br>
    Please review your entries. Click button to proceed.<br><br>
    
    <form action="index.php" method="post" enctype="multipart/form-data"> <!--- target="_blank" --->

    <?php
    foreach($fields as $field)
    {
        echo "<input type='hidden' name='$field'  value='$params[$field]'>";
    }
    ?>
    <input type="submit" value="Add Project to SciStarter">
    <a href="javascript:history.go(-1)">Cancel</a>
    </form>
    
    <?php
}
?>
