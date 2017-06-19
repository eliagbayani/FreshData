<?php
// namespace php_active_record;
/* Expects: $params */

// echo "<pre>"; print_r($params); echo "</pre>";

$rek = self::monitors_list($params);
$rows = $rek['recs'];
$str = " n = " . count($rows);

if($params['monitorAPI'] == 1) $str .= " | Monitors API Mode";
else                           $str .= " | Monitors Manual Mode";


// echo "<pre>"; print_r($rek); echo "</pre>";

?>
<div id="accordion_open">
    <h3><?php echo $str ?></h3>
    <div>
        <?php
        if($rows)
        {
            // echo "<pre>"; print_r($rows); echo "</pre>";
            $data = array('group' => 'monitors', 'records' => $rows, 'view_type' => $params['view_type'], 'params' => $params);
            print self::render_template('monitors-table', array('data' => @$data));
        }
        ?>
    </div>
</div>
