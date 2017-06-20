<div id="tabs_main">
    <ul>
        <li><a onClick="tab1_clicked()" href="#tabs_main-1">Monitors ››</a></li>
        <li><a                          href="#tabs_main-2">Admin Page</a></li>
        <li><a onClick="tab6_clicked()" href="#tabs_main-6">Admin SciStarter ››</a></li>
        <li><a onClick="tab3_clicked()" href="#tabs_main-3">Back to Fresh Data ››</a></li>
        <li><a href="#tabs_main-4">Refresh cache</a></li>
        <li><a href="#tabs_main-5">API Call</a></li>
        
        <?php
        if($params['monitorAPI'] == 1) echo '<li><a onClick="tab7_clicked()" href="#tabs_main-7">Monitors Manual mode ››</a></li>';
        else                           echo '<li><a onClick="tab7_clicked()" href="#tabs_main-7">Monitors API mode ››</a></li>';
        ?>
        
    </ul>
    <div id="tabs_main-1">Loading...</div>
    <div id="tabs_main-2"><?php print $ctrler->render_template('monitors-list', array('params' => @$params)); ?></div>
    <div id="tabs_main-6">Loading...</div>
    <div id="tabs_main-3">Loading...</div>
    <div id="tabs_main-4"><?php require_once("layout_refresh.php") ?></div>
    <div id="tabs_main-5"><?php require_once("apicall.php") ?></div>
</div>

<?php 
    $back = FRESHDATA_DOMAIN;
    $public = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/index.php?view_type=public&monitorAPI=".$params['monitorAPI'];
    $scistarter = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/index.php?view_type=scistarter&monitorAPI=".$params['monitorAPI'];
    $api = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/index.php?api_call=";
    if($params['monitorAPI'] == 0) $admin_unhooked = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/index.php?view_type=admin&monitorAPI=1";
    else                           $admin_unhooked = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/index.php?view_type=admin&monitorAPI=0";
?>
<script>
function tab3_clicked() { location.href = '<?php echo $back ?>'; }
function tab1_clicked() { location.href = '<?php echo $public ?>'; }
function tab6_clicked() { location.href = '<?php echo $scistarter ?>'; }
function tab7_clicked() { location.href = '<?php echo $admin_unhooked ?>'; }
/* working but not used atm.
function tab5_clicked() { location.href = '<?php echo $api ?>'; }
*/
</script>

