<div id="tabs_main">
    <ul>
        <li><a href="#tabs_main-1">SciStarter - Admin</a></li>
        <li><a href="#tabs_main-2">Maintenance</a></li>
        <li><a onClick="tab4_clicked()" href="#tabs_main-4">Public View ››</a></li>
        <li><a onClick="tab3_clicked()" href="#tabs_main-3">Back to Fresh Data ››</a></li>
        <li><a href="#tabs_main-5">API Call</a></li>
    </ul>
    <div id="tabs_main-1">
        <?php 
            // print $ctrler->render_layout(@$params, 'monitors-list')
            print $ctrler->render_template('monitors-list', array('params' => @$params));
        ?>
    </div>
    <div id="tabs_main-2">
        Click a monitor to update.
    </div>
    <div id="tabs_main-3">Loading...</div>
    <div id="tabs_main-4">Loading...</div>
    <div id="tabs_main-5">
        <?php
        require_once("apicall.php")
        ?>
    </div>
</div>

<?php 
    $back = FRESHDATA_DOMAIN;
    $public = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/index.php?view_type=public";
    $api = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/index.php?api_call=";
?>
<script>
function tab3_clicked() { location.href = '<?php echo $back ?>'; }
function tab4_clicked() { location.href = '<?php echo $public ?>'; }
/* working but not used atm.
function tab5_clicked() { location.href = '<?php echo $api ?>'; }
*/
</script>

