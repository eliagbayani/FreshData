<?php
// echo "<pre>"; print_r($params); echo "</pre>";
$uuid = $params['uuid'];
$rec_from_text = self::process_uuid($uuid);

if(!self::manually_added_monitor($uuid)) $monitor = self::get_monitor_record($uuid);

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
                <li><a href="#tabs-0">Edit</a></li>
                <li><a href="#tabs-2">Delete</a></li>
                <li><a href="#tabs-1">Create a new monitor</a></li>
            </ul>
            <div id="tabs-0">
                <?php 
                if(!self::manually_added_monitor($uuid)) require("templates/freshdata/monitor-orig-api-data.php"); 
                ?>
                <?php require_once("templates/freshdata/monitor-update.php"); ?>
            </div>

            <div id="tabs-1">
                <?php require_once("templates/freshdata/monitor-add.php"); ?>
            </div>

            <div id="tabs-2">
                <span id = "login_form2">
                <table>
                
                <?php
                if(self::manually_added_monitor($uuid)) self::display_message(array('type' => "error", 'msg' => "Since this is a manually added monitor, deletion is permanent. There is no 'un-delete' for manually added monitors."));
                else 
                {
                    self::display_message(array('type' => "highlight", 'msg' => "Originally API-driven monitors can still be retrieved once deleted."));
                    self::display_message(array('type' => "highlight", 'msg' => "Go to: Admin Page -> Admin: Deleted Records -> Choose a record -> Click 'Un-delete' button"));
                    
                }
                ?>
                
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
                <?php require_once("templates/freshdata/monitor-delete.php"); ?>
                </span>
                <div id="stage2" style = "background-color:white;"></div>
            </div>
        
        </div>
    
    </div>
</div>
