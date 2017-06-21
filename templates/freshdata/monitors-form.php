<?php
// echo "<pre>"; print_r($params); echo "</pre>";
$uuid = $params['uuid'];
$rec_from_text = self::process_uuid($uuid);
$monitor = self::get_monitor_record($uuid);

// echo "<pre>"; print_r($monitor); echo "</pre>";
// echo "<pre>"; print_r($rec_from_text); echo "</pre>";

/*
Array
(
    [selector] => Array
        (
            [taxonSelector] => Animalia|Insecta
            [wktString] => ENVELOPE(-150,-50,40,10)
            [traitSelector] => 
            [uuid] => 55e4b0a0-bcd9-566f-99bc-357439011d85
        )
    [status] => ready
    [recordCount] => 111211058
)
*/
$str = "Monitor info";
if($params['monitorAPI'] == 1) $str .= " | Monitors API Mode";
else                           $str .= " | Monitors Manual Mode";
?>

<div id="accordion_open2">
    <h3><?php echo $str ?></h3>
    <div>
    
        <div id="tabs1">
            <ul>
                <li><a href="#tabs-0">Edit</a></li>
                <li><a href="#tabs-1">Add</a></li>
                <li><a href="#tabs-2">Delete</a></li>
            </ul>
            <div id="tabs-0">
                <table>
                    <tr><td>uuid:</td>           <td id="value"><?php echo $monitor['selector']['uuid'] ?></td></tr>
                    <tr><td>Taxa:</td>           <td id="value"><?php echo $monitor['selector']['taxonSelector'] ?></td></tr>
                    <tr><td>Status:</td>         <td id="value"><?php echo @$monitor['status'] ?></td></tr>
                    <tr><td>Records:</td>        <td id="value"><?php echo number_format($monitor['recordCount']) ?></td></tr>
                    <tr><td>Trait selector:</td> <td id="value"><?php echo $monitor['selector']['traitSelector'] ?></td></tr>
                    <tr><td>String:</td>         <td id="value"><?php echo $monitor['selector']['wktString'] ?></td></tr>
                </table>
                <?php require_once("templates/freshdata/monitor-update.php"); ?>
            </div>

            <div id="tabs-1">
            </div>
            <div id="tabs-2">
            </div>
        
        </div>
    
    </div>
</div>
