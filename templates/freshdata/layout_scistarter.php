<div id="tabs_main">
    <ul>
        <li><a onClick="tab1_clicked()" href="#tabs_main-1">Monitors ››</a></li>
        <li><a onClick="tab2_clicked()" href="#tabs_main-2">Admin Page ››</a></li>
        <li><a                          href="#tabs_main-6">Admin SciStarter</a></li>
        <li><a onClick="tab3_clicked()" href="#tabs_main-3">Back to Fresh Data ››</a></li>
        <li><a                          href="#tabs_main-4">Refresh cache</a></li>
        <li><a                          href="#tabs_main-5">API Call</a></li>
    </ul>
    <div id="tabs_main-1">Loading...</div>
    <div id="tabs_main-2">Loading...</div>
    <div id="tabs_main-6"><?php print $ctrler->render_template('monitors-list', array('params' => @$params)); ?></div>
    <div id="tabs_main-3">Loading...</div>
    <div id="tabs_main-4"><?php require_once("layout_refresh.php") ?></div>
    <div id="tabs_main-5"><?php require_once("apicall.php") ?></div>
</div>

<?php
    $back = FRESHDATA_DOMAIN;
    $public = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/index.php?view_type=public";
    $admin = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/index.php?view_type=admin";
    $api = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/index.php?api_call=";
?>
<script>
function tab1_clicked() { location.href = '<?php echo $public ?>'; }
function tab2_clicked() { location.href = '<?php echo $admin ?>'; }
function tab3_clicked() { location.href = '<?php echo $back ?>'; }
/* working but not used atm.
function tab5_clicked() { location.href = '<?php echo $api ?>'; }
*/
</script>
