<?php
$params =& $_GET;
if(!$params) $params =& $_POST;
?>

<div id="accordion_open2">
    <h3><?php echo "Project Submission to SciStarter" ?></h3>
    <div>
        <?php
        // echo "<pre>"; print_r($params); echo "</pre>"; 

        $info = other_controller::submit_add_project($params, $params['uuid']);
        // print_r($info);
        echo "<hr><b>Actual SciStarter API response:</b><br><br>$info<hr>";
        ?>

    </div>
</div>
