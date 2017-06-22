<?php
// echo "<pre>"; print_r($params); echo "</pre>";
$uuid = $params['uuid'];
$rec_from_text = self::process_uuid($uuid);
$monitor = self::get_monitor_record($uuid);

// echo "<pre>"; print_r($monitor); echo "</pre>";
// echo "<pre>"; print_r($rec_from_text); echo "</pre>";

/*
Array
(
    [selector] => Array
        (
            [taxonSelector] => Animalia|Insecta
            [wktString] => ENVELOPE(-150,-50,40,10)
            [traitSelector] => 
            [uuid] => 55e4b0a0-bcd9-566f-99bc-357439011d85
        )
    [status] => ready
    [recordCount] => 111211058
)
*/
$str = "Monitor info";
if($params['monitorAPI'] == 1) $str .= " | Monitors API Mode";
else                           $str .= " | Monitors Manual Mode";
?>

<div id="accordion_open2">
    <h3><?php echo $str ?></h3>
    <div>
    
        <div id="tabs1">
            <ul>
                <li><a href="#tabs-0">Un-delete</a></li>
                <li><a href="#tabs-1">Add</a></li>
            </ul>
            <div id="tabs-0">
                <span id = "login_form2">
                <table>
                <tr><td colspan="2"><hr><b>Archive Info:</b><hr></td></tr>
                <?php
                $fields = array("uuid_archive", "Taxa", "Status", "Records", "Trait_selector", "String");
                foreach($fields as $field) echo "<tr><td>$field:</td><td id='value'>".$rec_from_text[$field]."</td></tr>";
                ?>
                <tr><td colspan="2"><hr><b>Additional Fields:</b><hr></td></tr>
                <?php
                $fields = array("Title", "Description", "URL", "Training_materials", "Contact");
                foreach($fields as $field) echo "<tr><td>$field:</td><td id='value'>".$rec_from_text[$field]."</td></tr>";
                ?>
                </table>
                <?php require_once("templates/freshdata/monitor-undelete.php"); ?>
                </span>
                <div id="stage2" style = "background-color:white;"></div>
            </div>

            <div id="tabs-1">
            </div>

        </div>
    
    </div>
</div>
