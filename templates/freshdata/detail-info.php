<?php
// namespace php_active_record;
/* Expects: $params */

// echo "<pre>"; print_r($params); echo "</pre>";
$uuid = $params['uuid'];
// $rek = self::monitors_list($params);
// echo "<pre>"; print_r($rek); echo "</pre>";

$rec_from_text = $rec_from_text = self::get_text_file_value($uuid);
$search_url = self::generate_freshdata_search_url($rec_from_text);


require("templates/freshdata/monitor-text-data.php");
if($incrementals = self::get_incremental_files($uuid))
{
    require_once("templates/freshdata/special-incremental-files.php");
}



?>

<!---
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
--->