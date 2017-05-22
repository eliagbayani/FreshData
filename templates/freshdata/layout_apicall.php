<div id="tabs_main">
    <ul>
        <li><a href="#tabs_main-1">Monitors</a></li>
        <li><a onClick="tab2_clicked()" href="#tabs_main-2">Admin Page ››</a></li>
        <li><a onClick="tab3_clicked()" href="#tabs_main-3">Back to Fresh Data ››</a></li>
        <li><a href="#tabs_main-4">Refresh cache</a></li>
        <li><a href="#tabs_main-5">API Call</a></li>
    </ul>
    <div id="tabs_main-1">
        <?php 
            print $ctrler->render_template('monitors-list', array('params' => @$params));
        ?>
    </div>
    <div id="tabs_main-2">Loading...</div>
    <div id="tabs_main-3">Loading...</div>
    <div id="tabs_main-4">
        <?php
        $ctrler->display_message(array('type' => "highlight", 'msg' => "You only need to refresh if new monitors are added/deleted."));
        $ctrler->display_message(array('type' => "highlight", 'msg' => "Cache refreshes automatically every 12 hours."));
        echo "<br><a href='index.php?refresh_cache='>Refresh now</a>.";
        ?>
    </div>
    <div id="tabs_main-5">
        <?php
        require_once("apicall.php")
        ?>

        <?php
        /* if we want to display it, possible todo:
        $json = Functions::lookup_with_cache($api_call, array('cache' => 0));
        echo "<br><br><span>$json</span>";
        */
        ?>
        
    </div>
</div>

<?php
    $back = FRESHDATA_DOMAIN;
    $admin = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/index.php?admin_view=";
    $refresh = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/index.php?refresh_cache=";
    $api = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/index.php?api_call=";
?>
<script>
function tab2_clicked() { location.href = '<?php echo $admin ?>'; }
function tab3_clicked() { location.href = '<?php echo $back ?>'; }
/* 
function tab4_clicked() { location.href = '<?php echo $refresh ?>'; }
*/
function tab5_clicked() { location.href = '<?php echo $api ?>'; }
</script>
