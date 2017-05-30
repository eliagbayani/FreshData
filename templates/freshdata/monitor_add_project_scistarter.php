<?php
$params =& $_GET;
if(!$params) $params =& $_POST;
?>

<div id="accordion_open2">
    <h3><?php echo "SciStarter Project info" ?></h3>
    <div>
        <?php
        // echo "<pre>"; print_r($params); echo "</pre>"; 

        $info = other_controller::submit_add_project($params);
        print_r($info);
        echo "<hr>$info<hr>";
        ?>

    </div>
</div>
