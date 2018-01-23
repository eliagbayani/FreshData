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
                <li><a href="#tabs-6">Create a new monitor for an existing UUID</a></li>
                <li><a href="#tabs-1">Create a new monitor</a></li>
                <li><a href="#tabs-3">Download Occurrence TSV</a></li>
                <li><a href="#tabs-4">Special Queries</a></li>
                <li><a href="#tabs-5">Public link</a></li>
            </ul>

            <div id="tabs-5"><!---Public link--->
                <?php
                echo "<a href='index.php?view_type=monDetail&uuid=$uuid'>Public link</a>"
                ?>
            </div>

            <div id="tabs-3"><!---Download Occurrence TSV--->
                <?php 
                
                /*
                if(self::is_task_running("process_invasive_job")) echo "<hr>invasive job IS RUNNING...</hr>";
                else echo "<hr>invasive job is NOT running...</hr>";
                */
                
                require("templates/freshdata/monitor-text-data.php");
                $search_url = FRESHDATA_DOMAIN."?taxonSelector=".$rec_from_text['Taxa']."&traitSelector=".$rec_from_text['Trait_selector']."&wktString=".$rec_from_text['String'];

                /*
                $search_url2 = self::generate_freshdata_search_url($rec_from_text); //new
                if($search_url != $search_url2) exit("<hr>something is wrong");
                else echo "<hr>tama na!!!<hr>";
                */
                
                $url = $this->api['effechecka_occurrences']."?taxonSelector=".$rec_from_text['Taxa']."&traitSelector=".$rec_from_text['Trait_selector']."&wktString=".$rec_from_text['String'];
                // $url = "http://editors.eol.org/test.tsv"; //debug only

                //vars to be filled-up for other tabs e.g. Special Queries
                $button_text  = "Continue 1";
                $basename = $uuid;
                $destination_jenkins = self::generate_tsv_filepath($basename, "jenkins");
                $destination         = self::generate_tsv_filepath($basename);
                $destination_dl_tsv  = $destination;
                $short_task = "wget_job";
                $form_elements_index = 3;
                $php_form_script = "templates/freshdata/monitor-q-download-tsv.php";
                $queries_tab_index = 1;
                $done_msg = "Occurrence TSV downloaded.";
                $del_label = "Delete downloaded TSV:";
                $job_type = "download occurrence tsv";
                require("templates/freshdata/jenkins-interface.php");
                ?>
            </div><!---end: Queries--->

            <div id="tabs-4"><!---Special Queries--->
                <?php
                if($uuid != "653727f3-3da8-5062-b2f8-94948687afff") { //Title: "Invader Detectives DC"
                    echo "No special queries assigned for this monitor.";
                }
                else {
                    require("templates/freshdata/monitor-text-data.php");

                    //vars to be filled-up for other tabs
                    $button_text  = "Continue 2";
                    $basename = $uuid."_inv";
                    $destination = self::generate_tsv_filepath($basename);
                    $short_task = "process_invasive_job";
                    $form_elements_index = 4;

                    if(file_exists($destination) && filesize($destination)) $inv_button_label = "Re-generate invasive species filter";
                    else                                                    $inv_button_label = "Generate invasive species filter";
                    $php_form_script = "templates/freshdata/special-invasive-form.php";

                    $queries_tab_index = 2;
                    $done_msg = "Invasive species filter applied.";
                    $del_label = "Delete full file:";
                    $job_type = "apply invasive filter to occurrence";
                    // echo "<hr>$destination_dl_tsv<hr>"; //debug
                    if(file_exists($destination_dl_tsv) && filesize($destination_dl_tsv)) require("templates/freshdata/jenkins-interface.php");
                    else require("templates/freshdata/jenkins-interface.php");
                    // else echo "<p>Occurrence TSV not yet downloaded."; //orig, replaced by above
                }
                ?>
            </div><!---end: Special Queries--->

            <div id="tabs-0"><!---Edit--->
                <?php 
                    if(!self::manually_added_monitor($uuid)) require("templates/freshdata/monitor-orig-api-data.php");
                    require_once("templates/freshdata/monitor-update.php");
                ?>
            </div>
            <div id="tabs-1"><!---Create a new monitor--->
                <?php require_once("templates/freshdata/monitor-add.php"); ?>
            </div>
            <div id="tabs-6"><!---Create a new monitor with UUID --->
                <?php
                self::display_message(array('type' => "highlight", 'msg' => "Enter UUID:"));
                ?>
                <?php //require("templates/freshdata/monitor-orig-api-data.php"); ?>
                
                <span id = "login_form2">
                <table>
                <tr><td colspan="2"><hr><b>Archive Info:</b><hr></td></tr>
                <?php
                // self::main_fields_display($rec_from_text);
                ?>
                </table>
                <?php 
                    require_once("templates/freshdata/search-uuid.php"); 
                    //require_once("templates/freshdata/monitor-undelete.php"); 
                ?>
                </span>
                <div id="stage2" style = "background-color:white;"></div>
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
                    require("templates/freshdata/monitor-text-data-template.php");
                    require_once("templates/freshdata/monitor-delete.php");
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
    $queries = HTTP_PROTOCOL . $_SERVER['SERVER_NAME'] . "/FreshData/index.php?view_type=queries&uuid=".$uuid;
?>
<script>
function tab3_clicked() { location.href = '<?php echo $queries ?>'; }
</script>
--->
