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
                <li><a href="#tabs-3">Queries</a></li>
                
            </ul>
            <div id="tabs-3">
            
                <span id = "login_form3">
                <?php
                    // echo "<pre>"; print_r($rec_from_text); echo "</pre>";

                    /*
                    worked command-line
                    wget -O TSV_files/eli.tsv "http://api.effechecka.org/occurrences.tsv?taxonSelector=Aphaenogaster&traitSelector=&wktString=POLYGON%20((-138.8671875%2044,%20-138.8671875%2070,%20-47.8125%2070,%20-47.8125%2044,%20-138.8671875%2044))"
                    */

                    $search_url = FRESHDATA_DOMAIN."?taxonSelector=".$rec_from_text['Taxa']."&traitSelector=".$rec_from_text['Trait_selector']."&wktString=".$rec_from_text['String'];
                    $url = $this->api['effechecka_occurrences']."?taxonSelector=".$rec_from_text['Taxa']."&traitSelector=".$rec_from_text['Trait_selector']."&wktString=".$rec_from_text['String'];
                    $url = $this->api['effechecka_occurrences']."?taxonSelector=".$rec_from_text['Taxa']."&traitSelector=".$rec_from_text['Trait_selector']."&wktString=".$rec_from_text['String'];


                    $destination = __DIR__ . "/../../TSV_files/$uuid.tsv";
                    if(file_exists($destination) && filesize($destination)) 
                    {
                        echo "<hr>TSV already downloaded<hr>";
                        echo "<hr>".filesize($destination)."<hr>";
                        
                        
                    }
                    else
                    {
                        require_once("templates/freshdata/monitor-q-download-tsv.php");
                        /*
                        //worked on script
                        $cmd = WGET_PATH.' -O '.$destination.' "'.$url.'"';
                        $cmd .= " 2>&1";
                        $shell_debug = shell_exec($cmd);
                        echo "<a href='$url'>link</a><hr>[$cmd]<hr><hr>[$shell_debug]";
                        if(stripos($shell_debug, "404 Not Found") !== false) //string is found
                        {
                            echo "<hr>filesize:".filesize($destination)."<hr>";
                            unlink($destination);
                        }
                        */
                    }
                    
                    // if(other_controller::is_tsv_ready($search_url))
                    // {
                    //     echo "TSV is ready";
                    // }
                    // else echo "TSV is NOT YET READY.";
                ?>
                </span>
                <div id="stage3" style = "background-color:white;"></div>
                <form action="index.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="uuid"        value="<?php echo $uuid ?>"                 >
                <input type="hidden" name="monitorAPI"  value="<?php echo $params['monitorAPI'] ?>" >
                <input type="hidden" name="view_type"   value="<?php echo $params['view_type'] ?>"  >
                <input type="hidden" name="queries"     value="1"                                   >
                <input type="submit" value="Continue">
                </form>
            </div>
            
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
                
                <?php
                if(self::has_scistarter_project_name($uuid)) self::display_message(array('type' => "error", 'msg' => "Cannot delete because it is used in SciStarter."));
                else
                {
                    if(self::manually_added_monitor($uuid))
                    {
                        self::display_message(array('type' => "error", 'msg' => "Since this is a manually added monitor, deletion will be permanent. There is no 'un-delete' for manually added monitors."));
                        self::display_message(array('type' => "error", 'msg' => "You can print or write this down for reference so you can add it again if needed."));
                    }
                    else 
                    {
                        self::display_message(array('type' => "highlight", 'msg' => "Original API-driven monitors can still be retrieved once deleted."));
                        self::display_message(array('type' => "highlight", 'msg' => "Go to: Admin Page -> Deleted Records -> Choose a record -> Click 'Un-delete' button"));
                    }
                    ?>
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
                    <?php require_once("templates/freshdata/monitor-delete.php"); ?>
                    <?php
                }
                ?>
                </span>
                <div id="stage2" style = "background-color:white;"></div>
                
            </div>
        
        </div>
    
    </div>
</div>


<!--- did not use
<?php
    $queries = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/index.php?view_type=queries&uuid=".$uuid;
?>
<script>
function tab3_clicked() { location.href = '<?php echo $queries ?>'; }
</script>
--->
