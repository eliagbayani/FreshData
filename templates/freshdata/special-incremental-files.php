<?php
echo "<br><br>Incremental files:";
foreach($incrementals as $inc)
{
    $base = pathinfo($inc, PATHINFO_FILENAME);
    $zip_path = "TSV_files/$base".".tsv";
    $display = str_replace($uuid."_inc", "Latest_Data", $base);
    $display = str_replace("-","",$display);
    echo "<br><a href='$zip_path'>$display</a>";
}
?>

