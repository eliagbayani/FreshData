<?php
// namespace php_active_record;
/* Expects: $params */


$rek = self::monitors_list('active', false, true);
$rows = $rek['recs'];
$str = " n = " . count($rows);

// echo "<pre>"; print_r($rek); echo "</pre>";
// exit;

?>
<div id="accordion_open">
    <h3><?php echo $str ?></h3>
    <div>
        <?php
        if($rows)
        {
            // echo "<pre>"; print_r($rows); echo "</pre>";
            $data = array('group' => 'monitors', 'records' => $rows);
            print self::render_template('monitors-table', array('data' => @$data));
        }
        
        ?>
    </div>
</div>
