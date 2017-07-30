<?php

// if($params['view_type'] == 'monDetail') echo "111";
// else echo "222";

/*
    [uuid] => 4c7517a1-0e01-555e-b498-6924ab5021a7
    [monitorAPI] => 0
    [view_type] => admin
    [queries] => 2
    [get_count4] => No
    [del_tsv4] =>

    Array
    (
        [view_type] => monDetail
        [uuid] => 4c7517a1-0e01-555e-b498-6924ab5021a7
        [monitorAPI] => 0
    )
*/
$link = "index.php?uuid=$params[uuid]&monitorAPI=$params[monitorAPI]&view_type=admin&queries=2&get_count4=&del_tsv4=&inc_del_file=";

$full_file = "TSV_files/$params[uuid]"."_inv.tsv.gz";
echo "<br><br>Full file: <a href='$full_file'>Download</a>";

echo "<br><br>Incremental files:";
foreach($incrementals as $inc)
{
    $base = pathinfo($inc, PATHINFO_FILENAME);
    $zip_path = "TSV_files/$base".".gz";
    
    $display = str_replace($uuid."_inc", "Latest_Data", $base);
    $display = str_replace("-","",$display);
    $display = str_replace(".tsv","",$display);
    echo "<br><br> - $display &nbsp;&nbsp; <a href='$zip_path'>Download</a>";

    $base = str_replace(".tsv","",$base);
    $flink = $link.$base;
    if($params['view_type'] == 'admin') echo " | <a href='$flink'>Delete</a>";
}
?>

