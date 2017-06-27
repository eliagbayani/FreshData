<div id="tabs_main">
    <ul>
        <li><a onClick="tab1_clicked()" href="#tabs_main-1">Deleted Records ››</a></li>
        <li><a href="#tabs_main-2">Maintenance</a></li>
        <li><a onClick="tab3_clicked()" href="#tabs_main-3">Monitors ››</a></li>
    </ul>
    <div id="tabs_main-1">Loading...</div>
    <div id="tabs_main-2"><!---Click a monitor to update--->
        <?php
        print $ctrler->render_template('monitors-form-undelete', array('params' => @$params)); //original admin
        ?>
    </div>
    <div id="tabs_main-3">Loading...</div>
</div>

<?php
    $public = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/index.php?view_type=public&monitorAPI=".$params['monitorAPI'];
?>

<script>
function tab1_clicked() { location.href = '<?php echo "index.php?view_type=delRecs&monitorAPI=".$params['monitorAPI'] ?>'; }
function tab3_clicked() { location.href = '<?php echo $public ?>'; }
</script>
