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

$admin_link = "index.php?view_type=admin&monitorAPI=".$params['monitorAPI']

?>

<div id="accordion_open2">
    <h3><?php echo $str ?></h3>
    <div>
    
        <div id="tabs1">
            <ul>
                <li><a href="#tabs-0">Edit</a></li>
                <li><a href="#tabs-2">Delete</a></li>
                <li><a href="#tabs-1">Create a new monitor</a></li>
                <li><a href="#tabs-3">Download Occurrence TSV</a></li>
                <li><a href="#tabs-4">Special Queries</a></li>
            </ul>


            <div id="tabs-3"><!---Queries--->
                <span id = "login_form3">
                <?php
                    $search_url = FRESHDATA_DOMAIN."?taxonSelector=".$rec_from_text['Taxa']."&traitSelector=".$rec_from_text['Trait_selector']."&wktString=".$rec_from_text['String'];
                    $url = $this->api['effechecka_occurrences']."?taxonSelector=".$rec_from_text['Taxa']."&traitSelector=".$rec_from_text['Trait_selector']."&wktString=".$rec_from_text['String'];

                    $disp_total_rows = false;
                    $disp_dl_button = false;
                    $button_text  = "Continue 1";
                    
                    // $destination = __DIR__ . "/../../TSV_files/$uuid.tsv"; working but re-factor code
                    $destination = self::generate_tsv_filepath($uuid);
                    
                    if(file_exists($destination) && filesize($destination))
                    {
                        echo "<hr>went here 01<hr>";
                        $button_text  = "Refresh";
                        if(self::is_there_an_unfinished_job_for_this_uuid("wget_job", $uuid)) self::display_message(array('type' => "highlight", 'msg' => "There is an on-going download of occurrence for this monitor. Please check back soon *.")); //saw this already
                        elseif(self::is_task_in_queue("wget_job", $uuid))                     self::display_message(array('type' => "highlight", 'msg' => "There is an on-going download of occurrence for this monitor. Please check back soon **.")); //has not seen this yet
                        else
                        {
                            $disp_total_rows = true;
                            $button_text  = "Submit";
                            self::display_message(array('type' => "highlight", 'msg' => "Occurrence TSV file already downloaded. &nbsp; File size: ".filesize($destination)." bytes."));
                            self::display_message(array('type' => "highlight", 'msg' => "You can now proceed with 'Special Queries' tab"));
                        }
                    }
                    else
                    {
                        echo "<hr>went here 02<hr>";
                        if(self::is_task_in_queue("wget_job", $uuid))
                        {
                            $button_text  = "Refresh";
                            self::display_message(array('type' => "highlight", 'msg' => "This task is already on queue. Please check back soon ****.")); //saw this already
                        }
                        elseif(!self::is_there_an_unfinished_job_for_this_uuid("wget_job", $uuid))
                        {
                            echo "<hr>went bbb<hr>";
                            $disp_dl_button = false;
                            require_once("templates/freshdata/monitor-q-download-tsv.php");
                        }
                        elseif(!self::is_task_in_queue("wget_job", $uuid))
                        {
                            echo "<hr>went aaa<hr>";
                            $disp_dl_button = false;
                            require_once("templates/freshdata/monitor-q-download-tsv.php");
                        }
                        else
                        {
                            $button_text  = "Refresh";
                            self::display_message(array('type' => "highlight", 'msg' => "There is an on-going download of occurrence for this monitor. Please check back soon ***.")); //has not seen this yet
                        }
                    }
                ?>
                </span>
                <div id="stage3" style = "background-color:white;"></div>
                <br>
                <form action="index.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="uuid"        value="<?php echo $uuid ?>"                 >
                <input type="hidden" name="monitorAPI"  value="<?php echo $params['monitorAPI'] ?>" >
                <input type="hidden" name="view_type"   value="<?php echo $params['view_type'] ?>"  >
                <input type="hidden" name="queries"     value="1"                                   >
                <?php
                if(file_exists($destination) && filesize($destination) && $disp_total_rows)
                {
                    ?>
                    Count total rows:
                    <select name="get_count" id="toggleYN">
                        <option>
                        <?php $yn = array('Yes', 'No');
                        foreach($yn as $ans) {
                            $selected = "";
                            if(@$params['get_count'] == $ans) $selected = "selected";
                            echo '<option value="' . $ans . '" ' . $selected . '>' . $ans . '</option>';
                        }?>
                    </select>
                    <?php 
                    if(@$params['get_count']=='Yes') echo "<br><br>Total rows: ".self::get_total_rows($uuid);
                    /*
                    //apply special query: Invasive
                    require_once("templates/freshdata/special-invasive-YN.php");
                    */
                }
                if(!$disp_dl_button)
                {
                    ?>
                    <br><br><input type="submit" value="<?php echo $button_text ?>">
                    <?php
                }
                ?>
                </form>
            </div><!---end: Queries--->


            <div id="tabs-4"><!---Special Queries--->
                <span id = "login_form4">
                <?php
                    $destination_inv = self::generate_tsv_filepath($uuid."_inv");
                    require_once("templates/freshdata/special-invasive-form.php");
                ?>
                </span>
                <div id="stage4" style = "background-color:white;"></div>
                <br>
            </div><!---end: Special Queries--->


            <div id="tabs-0"><!---Edit--->
                <?php 
                if(!self::manually_added_monitor($uuid)) require("templates/freshdata/monitor-orig-api-data.php"); 
                ?>
                <?php require_once("templates/freshdata/monitor-update.php"); ?>
            </div>

            <div id="tabs-1"><!---Create a new monitor--->
                <?php require_once("templates/freshdata/monitor-add.php"); ?>
            </div>

            <div id="tabs-2"><!---Delete--->
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
