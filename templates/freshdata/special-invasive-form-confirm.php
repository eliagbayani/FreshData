<?php
/*
require_once("../../../LiteratureEditor/Custom/lib/Functions.php");
require_once("../../controllers/other.php");
require_once("../../controllers/freshdata.php");
$params =& $_GET;
if(!$params) $params =& $_POST;
$ctrler = new freshdata_controller($params);
sleep(1);
echo "<pre>"; print_r($params); echo "</pre>";
if(true)
{
    $ctrler->display_message(array('type' => "highlight", 'msg' => "Invasive: Processing done."));
    ?>
    <?php
}
*/
require_once("../../config/settingz.php");
require_once("../../../LiteratureEditor/Custom/lib/Functions.php");
require_once("../../controllers/other.php");
require_once("../../controllers/freshdata.php");
$task = "process_invasive_job";
$params =& $_GET;
if(!$params) $params =& $_POST;

$ctrler = new freshdata_controller($params);
// sleep(1);

//worked on script
$cmd = PHP_PATH.' app/invasive_filter.php '.$params['uuid'];
$cmd .= " 2>&1";
$ctrler->write_to_sh($params['uuid']."_inv", $cmd);

$cmd = $ctrler->generate_exec_command($params['uuid']."_inv"); //pass the desired basename of the .sh filename (e.g. xxx.sh then pass "xxx")
$c = $ctrler->build_curl_cmd_for_jenkins($cmd, $task);

/* to TSV destination here...
if(file_exists($params['destination'])) unlink($params['destination']);
*/

$shell_debug = shell_exec($c);
sleep(10);

// echo "<pre><hr>$cmd<hr>$c<hr></pre>";
echo "<pre><hr>[$shell_debug]<hr></pre>"; //debug only

// the $build_status should come from the status for uuid in question not just the currently last_build
$build_status = $ctrler->get_last_build_console_text($task, $params['uuid']."_inv");
if($ctrler->did_build_fail($build_status))
{
    $ctrler->display_message(array('type' => "error", 'msg' => "Build failed. Will need to investigate."));
}
elseif($ctrler->is_build_currently_running($build_status))
{
    $ctrler->display_message(array('type' => "highlight", 'msg' => "Processing... Has not completed yet."));
    $ctrler->display_message(array('type' => "highlight", 'msg' => "Please check back later."));
}
else
{
    if(file_exists($params['destination']) && filesize($params['destination'])) $ctrler->display_message(array('type' => "highlight", 'msg' => "Job completed: OK"));
    else                                                                        $ctrler->display_message(array('type' => "highlight", 'msg' => "Build is in unknown state. Will investigate"));
}
echo "<hr><pre>".$build_status."</pre><hr>"; //debug only

?>

<form action="index.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="uuid"        value="<?php echo $params['uuid'] ?>">
<input type="hidden" name="monitorAPI"  value="0">
<input type="hidden" name="view_type"   value="admin">
<input type="hidden" name="queries"     value="2"><!---Special Queries--->
<br><br><input type="submit" value="Refresh B">

