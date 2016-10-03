<?php require_once("config/settings.php"); ?>
<!doctype html>
<html lang="us">
<head>
    <div id="loadOverlay" style="background-color:#333; position:absolute; top:0px; left:0px; width:100%; height:100%; z-index:2000; color:white; font-size:120%;">Loading, please wait ...</div>
    <title>Fresh Data: Monitors Maintenance</title>
    <?php require_once("config/head-entry.html") ?>
</head>
<body>

<?php
$params =& $_GET;
if(!$params) $params =& $_POST;

// print_r($params);// exit;

require_once("../LiteratureEditor/Custom/lib/Functions.php");
require_once("controllers/other.php");
require_once("controllers/freshdata.php");
$ctrler = new freshdata_controller($params);
?>

<script type="text/javascript">
$(window).load(function () { $("#loadOverlay").css("display","none"); });
</script>

<?php

// echo "<pre>"; print_r($_COOKIE); echo "</pre>";

if(isset($params['admin_view']))
{
    if(!$ctrler->user_is_logged_in_wiki()) return;
}



//start assignment ------------------------------------------
if(isset($params['Title'])) $ctrler->save_monitor($params);

if($val = @$params['search_type'])
{
    if($val == "move24harvest")
    {
        if($params['wiki_title'] == $_SESSION['working_proj']) $_SESSION['working_proj'] = false;
    }
}
//end ------------------------------------------

if(isset($params['uuid']))           require_once("templates/freshdata/layout2.php");
elseif(isset($params['admin_view'])) require_once("templates/freshdata/layout_admin.php");
else                                 require_once("templates/freshdata/layout_public.php"); //default

// else print $ctrler->render_template('layout', array('params' => @$params));


?>

<!--- for spinner effect: http://spin.js.org/ --->
<div id="el"></div>
<script type="text/javascript">
var spinner = new Spinner().spin();
target.appendChild(spinner.el);
$('#el').spin('large'); //start spinning
</script>

<?php
print $ctrler->render_layout(@$params, 'result');

if(isset($params['uuid'])) print $ctrler->render_template('monitors-form', array('params' => @$params));
if(isset($params['part_more_info'])) print $ctrler->render_template('part-more-info', array('arr' => @$params['part_more_info']));
if(isset($params['search_type']))
{
    if    ($params['search_type'] == "titlelist")     print $ctrler->render_template('titlelist-result', array('letter' => @$params['radio']));
}
require_once("config/script-below-entry.html");

//for layout
if    (isset($params['uuid']))          print '<script>$( "#tabs_main" ).tabs( "option", "active", 1 );</script>';

?>
</body>
</html>
