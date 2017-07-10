<?php
require_once("../../config/settingz.php");
require_once("../../../LiteratureEditor/Custom/lib/Functions.php");
require_once("../../controllers/other.php");
require_once("../../controllers/freshdata.php");

$params =& $_GET;
if(!$params) $params =& $_POST;

$ctrler = new freshdata_controller($params);
// sleep(1);

//worked on script
$cmd = WGET_PATH.' --tries=3 -O '.$params['destination'].' "'.$params['url'].'"'; //working well with shell_exec()
$cmd = WGET_PATH.' --tries=3 -O '.$params['destination'].' "'.$params['url'].'"';
$cmd .= " 2>&1";
$ctrler->write_to_sh($params['uuid'], $cmd);
//$shell_debug = shell_exec($cmd);

$c = '/usr/bin/curl -I -X POST -H "Jenkins-Crumb:64377cccf355db2cc6fe0c0726012401" http://eli:b2e5ca02f73b5c7d716449c763e120dd@localhost:8080/job/wget_job/buildWithParameters?myShell='.$cmd;

// /* new
// $destination = __DIR__ . "/../../sh_files/eli.sh";
$destination = __DIR__ . "/../../sh_files/".$params['uuid'].".sh";
$cmd = "exec $destination";
$cmd .= " 2>&1";
// */

$c = '/usr/bin/curl -I -X POST -H "Jenkins-Crumb:64377cccf355db2cc6fe0c0726012401" http://eli:b2e5ca02f73b5c7d716449c763e120dd@localhost:8080/job/wget_job/buildWithParameters?myShell='.urlencode($cmd);
$c .= " 2>&1";

if(file_exists($params['destination'])) unlink($params['destination']);

// $shell_debug = shell_exec($cmd);
$shell_debug = shell_exec($c);
sleep(10);

// echo "<pre><hr>$cmd<hr>$c<hr></pre>";
echo "<pre><hr>[$shell_debug]<hr></pre>"; //debug only

// the $build_status should come from the status for uuid in question not just the currently last_build
$build_status = $ctrler->get_last_build_console_text("wget_job", $params['uuid']);
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
    else                                                                        $ctrler->display_message(array('type' => "highlight", 'msg' => "Build is in unknown state. Will investigate"));
}
echo "<hr><pre>".$build_status."</pre><hr>"; //debug only
?>


<form action="index.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="uuid"        value="<?php echo $params['uuid'] ?>"       >
<input type="hidden" name="monitorAPI"  value="<?php echo $params['monitorAPI'] ?>" >
<input type="hidden" name="view_type"   value="<?php echo $params['view_type'] ?>"  >
<input type="hidden" name="queries"     value="1"                                   >
<br><br><input type="submit" value="Continue 3">
</form>



