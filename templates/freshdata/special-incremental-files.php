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

echo "<br><br>Incremental files:";
foreach($incrementals as $inc)
{
    $base = pathinfo($inc, PATHINFO_FILENAME);
    $zip_path = "TSV_files/$base".".tsv";
    $display = str_replace($uuid."_inc", "Latest_Data", $base);
    $display = str_replace("-","",$display);
    echo "<br><a href='$zip_path'>$display</a>";
    
    $flink = $link.$base;
    if($params['view_type'] == 'admin') echo " - <a href='$flink'>Delete</a>";
}
?>

