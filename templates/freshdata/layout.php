<div id="tabs_main">
    <ul>
        <li><a href="#tabs_main-1">Monitors</a></li>
        <li><a onClick="tab2_clicked()" href="#tabs_main-2">Page Search ››</a></li>
        <li><a onClick="tab3_clicked()" href="#tabs_main-3">Back to Fresh Data ››</a></li>
    </ul>
    <div id="tabs_main-1">
        <?php 
            print $ctrler->render_layout(@$params, 'monitors-list')
        ?>
    </div>
    <div id="tabs_main-2">
        <?php 
            print $ctrler->render_layout(@$params, 'monitors-form')
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
function tab3_clicked() { location.href = '<?php echo $back ?>'; }
</script>

