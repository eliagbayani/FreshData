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
$cmd = WGET_PATH.' -O '.$params['destination'].' "'.$params['url'].'"'; //working well with shell_exec()
$cmd = WGET_PATH.' -O '.$params['destination'].' "'.$params['url'].'"';

$cmd .= " 2>&1";
//$shell_debug = shell_exec($cmd);

$c = '/usr/bin/curl -I -X POST -H "Jenkins-Crumb:64377cccf355db2cc6fe0c0726012401" http://eli:b2e5ca02f73b5c7d716449c763e120dd@localhost:8080/job/wget_job/buildWithParameters?myShell='.$cmd;

// $cmd = 'echo "eli is here..."';
// /* new
$destination = __DIR__ . "/../../sh_files/eli.sh";
$cmd = "exec $destination";
$cmd .= " 2>&1";
// */

// $cmd = "echo 'eliboy'";
$c = '/usr/bin/curl -I -X POST -H "Jenkins-Crumb:64377cccf355db2cc6fe0c0726012401" http://eli:b2e5ca02f73b5c7d716449c763e120dd@localhost:8080/job/wget_job/buildWithParameters?myShell='.urlencode($cmd);
$c .= " 2>&1";

// $c = escapeshellcmd($c);
// $c = escapeshellarg($c);


// $shell_debug = shell_exec($cmd);
$shell_debug = shell_exec($c);

echo "<pre><hr>$cmd<hr>$c<hr>[$shell_debug]</pre>";




/* when TSV is not ready:
[--2017-07-05 01:21:58-- http://api.effechecka.org/occurrences.tsv?taxonSelector=aphaenogaster%20picea%7Caphaenogaster%20fulva%7Caphaenogaster%20rudis&traitSelector=&wktString=POLYGON%20((-138.8671875%2044,%20-138.8671875%2070,%20-47.8125%2070,%20-47.8125%2044,%20-138.8671875%2044)) Resolving api.effechecka.org... 128.227.166.240 Connecting to api.effechecka.org|128.227.166.240|:80... connected. 
HTTP request sent, awaiting response... 404 Not Found 2017-07-05 01:21:59 ERROR 404: Not Found. ] 
*/
if(stripos($shell_debug, "404 Not Found") !== false) //string is found
{
    echo "<hr>filesize:".filesize($params['destination'])."<hr>";
    unlink($params['destination']);
    $ctrler->display_message(array('type' => "error", 'msg' => "Occurrences for this search is NOT yet ready."));
    // $ctrler->display_message(array('type' => "error", 'msg' => "<a href='".$params['search_url']."'>Search in Effechecka</a>"));
    echo "<a href='".$params['search_url']."'>Search in Effechecka</a>";
}
?>
