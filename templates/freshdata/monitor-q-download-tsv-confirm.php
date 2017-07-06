<?php
require_once("../../config/settings.php");
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

// $cmd = 'echo "eli is here..."';

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

echo "<pre><hr>$cmd<hr>$c<hr>[$shell_debug]</pre>";

/* when TSV is not ready:
[--2017-07-05 01:21:58-- http://api.effechecka.org/occurrences.tsv?taxonSelector=aphaenogaster%20picea%7Caphaenogaster%20fulva%7Caphaenogaster%20rudis&traitSelector=&wktString=POLYGON%20((-138.8671875%2044,%20-138.8671875%2070,%20-47.8125%2070,%20-47.8125%2044,%20-138.8671875%2044)) Resolving api.effechecka.org... 128.227.166.240 Connecting to api.effechecka.org|128.227.166.240|:80... connected. 
HTTP request sent, awaiting response... 404 Not Found 2017-07-05 01:21:59 ERROR 404: Not Found. ] 
*/
// if(stripos($shell_debug, "404 Not Found") !== false) //string is found
// if($ctrler->is_build_ok()) 
if(file_exists($params['destination']) && filesize($params['destination']))
{
    $ctrler->display_message(array('type' => "highlight", 'msg' => "Job completed: OK"));
    $build_no = $ctrler->get_last_build_number();
    echo "<hr>".$ctrler->get_last_build_console_text()."<hr>";
}
else
{
    echo "<hr>".$params['destination']."<hr>";
    if(file_exists($params['destination']) && filesize($params['destination']))
    {
        $ctrler->display_message(array('type' => "highlight", 'msg' => "Downloading, please check later."));
    }
    else
    {
        $ctrler->display_message(array('type' => "error", 'msg' => "Occurrences for this search is NOT yet ready."));
        echo "<br><a href='".$params['search_url']."' target='blank'>Search in Fresh Data first.</a><br><br>";
        $build_no = $ctrler->get_last_build_number();
        echo "<hr>".$ctrler->get_last_build_console_text()."<hr>";
    }
}
?>
