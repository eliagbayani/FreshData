<?php require_once("config/settingz.php"); ?>
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

// print_r($params);

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

if(in_array(@$params['view_type'], array('admin', 'scistarter', 'delRecs', 'manRecs')))
{
    if(!$ctrler->user_is_logged_in_wiki($params['view_type'])) return;
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
if(!isset($params['monitorAPI'])) $params['monitorAPI'] = 0; //defaults to unhooked mode or monitor manual mode

if(isset($params['scistarter']))              require_once("templates/freshdata/layout3.php");
elseif(isset($params['contact_name']))        require_once("templates/freshdata/layout3.php");
elseif(isset($params['uuid']) && @$params['view_type'] == 'admin') require_once("templates/freshdata/layout2.php");
elseif(isset($params['uuid']) && @$params['view_type'] == 'delRecs') require_once("templates/freshdata/layout4.php");
elseif(isset($params['uuid']) && @$params['view_type'] == 'manRecs') require_once("templates/freshdata/layout5.php");

elseif(@$params['view_type'] == 'admin')      require_once("templates/freshdata/layout_admin.php");
elseif(@$params['view_type'] == 'scistarter') require_once("templates/freshdata/layout_scistarter.php");
elseif(@$params['view_type'] == 'delRecs')    require_once("templates/freshdata/layout_delRecs.php");
elseif(@$params['view_type'] == 'manRecs')    require_once("templates/freshdata/layout_manRecs.php");

elseif(isset($params['api_call']))            require_once("templates/freshdata/layout_apicall.php");
elseif(@$params['view_type'] == 'public')     require_once("templates/freshdata/layout_public.php"); //default
else
{
    $params['view_type'] = 'public';
    require_once("templates/freshdata/layout_public.php"); //default
}

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

// all these 3 are woking OK, but transferred to layout3.php, layout2.php respectively
// if(isset($params['contact_name'])) print $ctrler->render_template('monitor_add_project_scistarter', array('params' => @$params)); //add project to SciStarter --- transferred to layout3.php
// elseif(isset($params['scistarter'])) print $ctrler->render_template('monitors-form-scistarter', array('params' => @$params));     //scistarter                --- transferred to layout3.php
// elseif(isset($params['uuid'])) print $ctrler->render_template('monitors-form', array('params' => @$params));                      //original admin            --- transferred to layout2.php

if(isset($params['part_more_info'])) print $ctrler->render_template('part-more-info', array('arr' => @$params['part_more_info']));
if(isset($params['search_type']))
{
    if($params['search_type'] == "titlelist") print $ctrler->render_template('titlelist-result', array('letter' => @$params['radio']));
}
require_once("config/script-below-entry.html");

//for layout
if(@$params['view_type'] == 'admin')            print '<script>$( "#tabs_main" ).tabs( "option", "active", 1 );</script>';
elseif(@$params['view_type'] == 'scistarter')   print '<script>$( "#tabs_main" ).tabs( "option", "active", 2 );</script>';

elseif(isset($params['uuid']) && @$params['view_type'] == 'delRecs') print '<script>$( "#tabs_main" ).tabs( "option", "active", 1 );</script>'; //layout4.php
elseif(isset($params['uuid']) && @$params['view_type'] == 'manRecs') print '<script>$( "#tabs_main" ).tabs( "option", "active", 1 );</script>'; //layout5.php

elseif(@$params['view_type'] == 'delRecs')      print '<script>$( "#tabs_main" ).tabs( "option", "active", 2 );</script>'; //layout_delRecs.php orig is 7
elseif(@$params['view_type'] == 'manRecs')      print '<script>$( "#tabs_main" ).tabs( "option", "active", 3 );</script>'; //layout_manRecs.php

elseif(isset($params['contact_name']))          print '<script>$( "#tabs_main" ).tabs( "option", "active", 1 );</script>'; //layout3.php
elseif(isset($params['uuid']))                  print '<script>$( "#tabs_main" ).tabs( "option", "active", 1 );</script>';
elseif(isset($params['api_call']))              print '<script>$( "#tabs_main" ).tabs( "option", "active", 4 );</script>';

if(@$params['queries'] == 1) print '<script>$( "#tabs1" ).tabs( "option", "active", 3 );</script>'; //Queries
if(@$params['queries'] == 2) print '<script>$( "#tabs1" ).tabs( "option", "active", 4 );</script>'; //Special Queries

?>
</body>
</html>
