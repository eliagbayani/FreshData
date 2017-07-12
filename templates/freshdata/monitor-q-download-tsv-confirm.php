<?php
require_once("../../config/settingz.php");
require_once("../../../LiteratureEditor/Custom/lib/Functions.php");
require_once("../../controllers/other.php");
require_once("../../controllers/freshdata.php");
$task = "wget_job";

$params =& $_GET;
if(!$params) $params =& $_POST;

$ctrler = new freshdata_controller($params);
// sleep(1);

//worked on script
$cmd = WGET_PATH.' --tries=3 -O '.$params['destination'].' "'.$params['url'].'"'; //working well with shell_exec()
$cmd .= " 2>&1";
$ctrler->write_to_sh($params['uuid'], $cmd);
//$shell_debug = shell_exec($cmd); //worked ok also but we changed strategy

$cmd = $ctrler->generate_exec_command($params['uuid']); //pass the desired basename of the .sh filename (e.g. xxx.sh then pass "xxx")
$c = $ctrler->build_curl_cmd_for_jenkins($cmd, $task);

if(file_exists($params['destination'])) unlink($params['destination']);

// $shell_debug = shell_exec($cmd);
$shell_debug = shell_exec($c);
sleep(10);

// echo "<pre><hr>$cmd<hr>$c<hr></pre>";
echo "<pre><hr>[$shell_debug]<hr></pre>"; //debug only

// the $build_status should come from the status for uuid in question not just the currently last_build
$build_status = $ctrler->get_last_build_console_text($task, $params['uuid']);
if($ctrler->did_build_fail($build_status))
{
    $ctrler->display_message(array('type' => "error", 'msg' => "Occurrences for this search is NOT yet ready in Fresh Data."));
    echo "<br><a href='".$params['search_url']."' target='".$params['uuid']."'>Search in Fresh Data first.</a> If you already did, let us wait for Fresh Data to generate the Occurrence TSV file.<br><br>";
}
elseif($ctrler->is_build_currently_running($build_status))
{
    $ctrler->display_message(array('type' => "highlight", 'msg' => "Download is on-going. Has not completed yet."));
    $ctrler->display_message(array('type' => "highlight", 'msg' => "Please check back later."));
}
else
{
    if(file_exists($params['destination']) && filesize($params['destination'])) $ctrler->display_message(array('type' => "highlight", 'msg' => "Job completed: OK"));
    else                                                                        $ctrler->display_message(array('type' => "highlight", 'msg' => "Build is in unknown state. Will investigate. Click <b>Continue</b>."));
}
echo "<hr><pre>".$build_status."</pre><hr>"; //debug only
?>

<!--- may not need these below; sample $params value:
Array
(
    [uuid] => 5b6d8474-fcb4-5e16-b5cf-8f8a9a502fc3
    [url] => http://api.effechecka.org/occurrences.tsv?taxonSelector=aphaenogaster picea|aphaenogaster fulva|aphaenogaster rudis&traitSelector=&wktString=POLYGON ((-138.8671875 44, -138.8671875 70, -47.8125 70, -47.8125 44, -138.8671875 44))
    [destination] => /Library/WebServer/Documents/FreshData/templates/freshdata/../../TSV_files/5b6d8474-fcb4-5e16-b5cf-8f8a9a502fc3.tsv
    [search_url] => http://gimmefreshdata.github.io/?taxonSelector=aphaenogaster picea|aphaenogaster fulva|aphaenogaster rudis&traitSelector=&wktString=POLYGON ((-138.8671875 44, -138.8671875 70, -47.8125 70, -47.8125 44, -138.8671875 44))
)
<?php echo "<pre>"; print_r($params); echo "</pre>"; ?>
--->
<form action="index.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="uuid"        value="<?php echo $params['uuid'] ?>">
<input type="hidden" name="monitorAPI"  value="0">
<input type="hidden" name="view_type"   value="admin">
<input type="hidden" name="queries"     value="1">
<br><br><input type="submit" value="Continue 3">
</form>
