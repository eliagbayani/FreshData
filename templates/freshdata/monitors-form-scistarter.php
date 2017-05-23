<?php
// echo "<pre>"; print_r($params); echo "</pre>";
$uuid = $params['uuid'];

$rec_from_text1 = self::process_uuid($uuid);
$rec_from_text2 = self::process_uuid($uuid, 'scistarter');
$monitor = self::get_monitor_record($uuid);
$rec_from_text2 = other_controller::get_default_values($rec_from_text2, $rec_from_text1, $monitor); //get default value if blank

// echo "<pre>"; print_r($monitor); echo "</pre>";
// echo "<pre>"; print_r($rec_from_text1); echo "</pre>";
// echo "<pre>"; print_r($rec_from_text2); echo "</pre>";

?>
<div id="accordion_open2">
    <h3><?php echo "SciStarter Project info" ?></h3>
    <div>
        <table>
            <tr>
            <td>uuid:</td>      <td id="value"><?php echo $monitor['selector']['uuid'] ?></td>
            <td>Taxa:</td>      <td id="value"><?php echo $monitor['selector']['taxonSelector'] ?></td>
            <td>Status:</td>    <td id="value"><?php echo @$monitor['status'] ?></td>
            <td>Records:</td>   <td id="value"><?php echo number_format($monitor['recordCount']) ?></td>
            </tr>
            <!---
            <tr><td>uuid:</td>           <td id="value"><?php echo $monitor['selector']['uuid'] ?></td></tr>
            <tr><td>Taxa:</td>           <td id="value"><?php echo $monitor['selector']['taxonSelector'] ?></td></tr>
            <tr><td>Status:</td>         <td id="value"><?php echo @$monitor['status'] ?></td></tr>
            <tr><td>Records:</td>        <td id="value"><?php echo number_format($monitor['recordCount']) ?></td></tr>
            --->
            <!---
            <tr><td>Trait selector:</td> <td id="value"><?php echo $monitor['selector']['traitSelector'] ?></td></tr>
            <tr><td>String:</td>         <td id="value"><?php echo $monitor['selector']['wktString'] ?></td></tr>
            --->
        </table>
        <?php
        require_once("templates/freshdata/monitor-update-scistarter.php");
        ?>
    </div>
</div>
