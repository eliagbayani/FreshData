to run gimmefreshdata:

cd to ~/GitHub_Pages/gimmefreshdata.github.io/

$ jekyll server --incremental --watch

-> then open in browser localhost:4000

===========================================
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

