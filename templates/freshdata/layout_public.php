<div id="tabs_main">
    <ul>
        <li><a href="#tabs_main-1">Monitors</a></li>
        <li><a onClick="tab2_clicked()" href="#tabs_main-2">Admin ››</a></li>
        <li><a onClick="tab3_clicked()" href="#tabs_main-3">Back to Fresh Data ››</a></li>
    </ul>
    <div id="tabs_main-1">
        <?php 
            // print $ctrler->render_layout(@$params, 'monitors-list')
            print $ctrler->render_template('monitors-list', array('params' => @$params));
        ?>
    </div>
    <div id="tabs_main-2">Loading...</div>
    <div id="tabs_main-3">Loading...</div>
</div>

<?php 
    $back = FRESHDATA_DOMAIN;
    $admin_view = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/index.php";
    
?>
<script>
function tab2_clicked() { location.href = '<?php echo $admin_view ?>'; }
function tab3_clicked() { location.href = '<?php echo $back ?>'; }
</script>

