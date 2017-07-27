<?php
include_once(dirname(__FILE__) . "/../config/settingz.php");

phpinfo();

// /* works OK
$crumb = shell_exec("curl -s 'http://" . JENKINS_USER_TOKEN . "@" . JENKINS_DOMAIN . "/crumbIssuer/api/xml?xpath=concat(//crumbRequestField,\":\",//crumb)'");
echo "<hr>$crumb<hr>";
// */

// echo "\nEli was here...\n";
// shell_exec("touch eli.txt");

// $s = "cd /Library/WebServer/Documents/FreshData ; php app/test.php";
// echo urlencode($s)."\n\n";
// 
// $s = "http://eli.eol.org?eli1=eli is here&eli2=eli cha";
// echo urlencode($s);


/*
echo "<pre>";
print_r($_SERVER);
$_SERVER['HTTP_HOST']
echo "</pre>";
*/

?>