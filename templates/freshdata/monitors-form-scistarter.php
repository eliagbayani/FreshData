<?php
// echo "<pre>"; print_r($params); echo "</pre>";
$uuid = $params['uuid'];

$rec_from_text1 = self::process_uuid($uuid);
$rec_from_text2 = self::process_uuid($uuid, 'scistarter');
$monitor = self::get_monitor_record($uuid);
$rec_from_text2 = other_controller::get_default_values_if_blank($rec_from_text2, $rec_from_text1, $monitor); //get default value if blank

// echo "<pre>"; print_r($monitor); echo "</pre>";
// echo "<pre>"; print_r($rec_from_text1); echo "</pre>";
// echo "<pre>"; print_r($rec_from_text2); echo "</pre>";
// echo "<pre>"; print_r($params); echo "</pre>";

$str = "SciStarter Project info";
if($params['monitorAPI'] == 1) $str .= " | Monitors API Mode";
else                           $str .= " | Monitors Manual Mode";


?>
<div id="accordion_open2">
    <h3><?php echo $str ?></h3>
    <div>
        <table>
            <tr>
            <?php
            if($params['monitorAPI'] == 1)
            {
               ?>
               <td>uuid:</td>      <td id="value"><?php echo $monitor['selector']['uuid'] ?></td>
               <td>Taxa:</td>      <td id="value"><?php echo $monitor['selector']['taxonSelector'] ?></td>
               <td>Status:</td>    <td id="value"><?php echo @$monitor['status'] ?></td>
               <td>Records:</td>   <td id="value"><?php echo number_format($monitor['recordCount']) ?></td>
               <?php
            }
            else
            {
                ?>
                <td>uuid:</td>      <td id="value"><?php echo $rec_from_text1['uuid_archive'] ?></td>
                <td>Taxa:</td>      <td id="value"><?php echo $rec_from_text1['Taxa'] ?></td>
                <td>Status:</td>    <td id="value"><?php echo $rec_from_text1['Status'] ?></td>
                <td>Records:</td>   <td id="value"><?php echo number_format($rec_from_text1['Records']) ?></td>
                <?php
            }
            ?>
            </tr>
        </table>
        <?php
        require_once("templates/freshdata/monitor-update-scistarter.php");
        ?>
    </div>
</div>
