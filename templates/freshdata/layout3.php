<div id="tabs_main">
    <ul>
        <li><a onClick="tab1_clicked()" href="#tabs_main-1">Admin SciStarter ››</a></li>
        <li><a href="#tabs_main-2">Maintenance</a></li>
        <li><a onClick="tab3_clicked()" href="#tabs_main-3">Monitors ››</a></li>
    </ul>
    <div id="tabs_main-1">Loading...</div>
    <div id="tabs_main-2">
        <?php
        if    (isset($params['contact_name'])) print $ctrler->render_template('monitor_add_project_scistarter', array('params' => @$params)); //add project to SciStarter
        elseif(isset($params['scistarter'])) print $ctrler->render_template('monitors-form-scistarter', array('params' => @$params));         //scistarter
        ?>
    </div>
    <div id="tabs_main-3">Loading...</div>
</div>

<?php
    $public = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/index.php?view_type=public&monitorAPI=".$params['monitorAPI'];
?>

<script>
function tab1_clicked() { location.href = '<?php echo "index.php?view_type=scistarter&monitorAPI=".$params['monitorAPI'] ?>'; }
function tab3_clicked() { location.href = '<?php echo $public ?>'; }
</script>
