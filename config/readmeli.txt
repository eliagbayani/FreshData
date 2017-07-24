to run gimmefreshdata:

cd to ~/GitHub_Pages/gimmefreshdata.github.io/

$ jekyll server --incremental --watch

-> then open in browser localhost:4000

===========================================
chmod 755 /Library/WebServer/Documents/eol_php_code/vendor/google_client_library/json/sheets.googleapis.com-php-quickstart.json
============================================
best jquery+ajax tutorial
https://www.tutorialspoint.com/jquery/jquery-ajax.htm
===========================================
Jira for this task: https://eol-jira.bibalex.org/browse/DATA-1621
===========================================
check if job exists:
curl -XGET 'http://localhost:8080/checkJobName?value=EoEarth_PHP_backup_script' --user eli:b2e5ca02f73b5c7d716449c763e120dd


get crumb on command-line:
curl -s 'http://eli:b2e5ca02f73b5c7d716449c763e120dd@localhost:8080/crumbIssuer/api/xml?xpath=concat(//crumbRequestField,":",//crumb)'

get crumb on PHP script:
$crumb = shell_exec("curl -s 'http://eli:b2e5ca02f73b5c7d716449c763e120dd@localhost:8080/crumbIssuer/api/xml?xpath=concat(//crumbRequestField,\":\",//crumb)'");
print("<hr>$crumb<hr>");


curl -I -X POST -H "Jenkins-Crumb:64377cccf355db2cc6fe0c0726012401" http://eli:b2e5ca02f73b5c7d716449c763e120dd@localhost:8080/job/FreshData_PHP_backup_script/buildWithParameters?myShell="cd /Library/WebServer/Documents/FreshData && php app/test.php"

works OK: enter the 'cd' statement in the configuration and just pass the 'php' statement via curl:
curl -I -X POST -H "Jenkins-Crumb:64377cccf355db2cc6fe0c0726012401" http://eli:b2e5ca02f73b5c7d716449c763e120dd@localhost:8080/job/FreshData_PHP_backup_script/buildWithParameters?myShell=php+app%2Ftest.php


cd /Library/WebServer/Documents/FreshData && php app/test.php

====================================================
Jenkins tutorials:
http://www.inanzzz.com/index.php/post/jnrg/running-jenkins-build-via-command-line
https://gist.github.com/stuart-warren/7786892
others:
https://support.cloudbees.com/hc/en-us/articles/218889337-How-to-build-a-job-using-the-REST-API-and-cURL
https://stackoverflow.com/questions/18697422/send-xml-data-to-webservice-using-php-curl
others:
https://modess.io/jenkins-php/
http://jenkins-php.org/
https://alexbilbie.com/2015/04/setting-up-jenkins/

sh:
https://www.shellscript.sh/

===================================================
// $c = escapeshellcmd($c);
// $c = escapeshellarg($c);

=============================================================
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
/*
worked command-line
wget -O TSV_files/eli.tsv "http://api.effechecka.org/occurrences.tsv?taxonSelector=Aphaenogaster&traitSelector=&wktString=POLYGON%20((-138.8671875%2044,%20-138.8671875%2070,%20-47.8125%2070,%20-47.8125%2044,%20-138.8671875%2044))"
*/

======================
from monitors-form.php

<!--- temporarily commented, working but no ajax effect
<div id="tabs-4"> Special Queries
    <span id = "login_form4">
        span area
    </span>
    <div id="stage4" style = "background-color:white;"></div>
    <br>
    <form action="index.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="uuid"        value="<?php echo $uuid ?>"                 >
    <input type="hidden" name="monitorAPI"  value="<?php echo $params['monitorAPI'] ?>" >
    <input type="hidden" name="view_type"   value="<?php echo $params['view_type'] ?>"  >
    <input type="hidden" name="queries"     value="2"                                   >
    <?php
    if(file_exists($destination) && filesize($destination) && $disp_total_rows)
    {
        //apply special query: Invasive
        require("templates/freshdata/special-invasive-YN.php");
        ?>
        <br><br><input type="submit" value="Continue 2">
        <?php
    }
    else
    {
        self::display_message(array('type' => "error", 'msg' => "Occurrence TSV file not yet downloaded."));
        self::display_message(array('type' => "error", 'msg' => "Use 'Download TSV' tab"));
    }
    ?>
    </form>
</div>
--->
=============================
$a = get_declared_classes();
print_r($a); exit;
==================================
working but was changed: from monitors-form.php

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
================================================
Matthew Collins mcollins@acis.ufl.edu
Thompson, Alexander M godfoder@acis.ufl.edu

