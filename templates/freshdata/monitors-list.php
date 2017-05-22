<?php
// namespace php_active_record;
/* Expects: $params */


// echo "<pre>"; print_r($params); echo "</pre>";
if(isset($params['admin_view']))  $public_view = false;
else                              $public_view = true;




$rek = self::monitors_list($params);
$rows = $rek['recs'];
$str = " n = " . count($rows);

// echo "<pre>"; print_r($rek); echo "</pre>";

?>
<div id="accordion_open">
    <h3><?php echo $str ?></h3>
    <div>
        <?php
        if($rows)
        {
            // echo "<pre>"; print_r($rows); echo "</pre>";
            $data = array('group' => 'monitors', 'records' => $rows, 'public_view' => $public_view);
            print self::render_template('monitors-table', array('data' => @$data));
        }
        ?>
    </div>
</div>
