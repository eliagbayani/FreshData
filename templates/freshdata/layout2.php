<div id="tabs_main">
    <ul>
        <li><a onClick="tab1_clicked()" href="#tabs_main-1">Monitors >></a></li>
        <li><a href="#tabs_main-2">Maintenance</a></li>
        <li><a onClick="tab3_clicked()" href="#tabs_main-3">Back to Fresh Data ››</a></li>
    </ul>
    <div id="tabs_main-1">Loading...</div>
    <div id="tabs_main-2">
        Click a monitor to update
        <?php
             // if(isset($params))
             // {
             //     print $ctrler->render_layout(@$params, 'monitors-form')
             // }
        ?>
        
    </div>
    <div id="tabs_main-3">Loading...</div>
</div>

<?php 
      // $back = "http://" . $_SERVER['SERVER_NAME'] . "/" . MEDIAWIKI_MAIN_FOLDER . "/";
      // $other = "http://" . $_SERVER['SERVER_NAME'] . "/" . MEDIAWIKI_MAIN_FOLDER . "/Custom/bhl_access/index.php";
      $back = FRESHDATA_DOMAIN;
?>
<script>

function tab1_clicked() { location.href = '<?php echo "index.php" ?>'; }
function tab3_clicked() { location.href = '<?php echo $back ?>'; }
</script>

