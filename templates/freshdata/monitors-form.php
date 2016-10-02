<?php

// echo "<pre>"; print_r($params); echo "</pre>";
$uuid = $params['uuid'];

self::process_uuid($uuid);

$monitor = self::get_monitor_record($uuid);
// echo "<pre>"; print_r($monitor); echo "</pre>";
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

?>




<div id="accordion_open2">
    <h3><?php echo "elix" ?></h3>
    <div>
        
        
        <table>
            <tr>
                <td>Taxa</td>   <td>: <?php echo $monitor['selector']['taxonSelector'] ?></td>
            </tr>
            <tr>
                <td>Status</td> <td>: <?php echo $monitor['status'] ?></td>
            </tr>
            <tr>
                <td>Records</td><td>: <?php echo $monitor['recordCount'] ?></td>
            </tr>
        </table>
        
    </div>
</div>
