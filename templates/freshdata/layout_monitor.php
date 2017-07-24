<div id="tabs_main">
    <ul>
        <li><a                          href="#tabs_main-2">Monitor Info</a></li>
        <li><a onClick="tab1_clicked()" href="#tabs_main-1">Monitors ››</a></li>
    </ul>
    <div id="tabs_main-2">
        <?php print $ctrler->render_template('detail-info', array('params' => @$params)); ?>
    </div>
    <div id="tabs_main-1">Loading...</div>
</div>

<?php 
    $public = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/index.php?view_type=public&monitorAPI=".$params['monitorAPI'];
?>
<script>
function tab1_clicked() { location.href = '<?php echo $public ?>'; }

/* working but not used atm.
function tab5_clicked() { location.href = '<?php echo $api ?>'; }
*/
</script>

