<br>
<?php
    $tsv_file = "TSV_files/$basename".".tsv";
    // echo "Last change: ".date("F d Y H:i:s.",filectime($tsv_file));
    // echo "<br />";
    echo "Last change: ".date("Y-m-d H:i:s",filectime($tsv_file));
    echo "<br />";
    echo "Today is " . date("Y-m-d H:i:s");
    $date_from = date("Y-m-d",filectime($tsv_file));
    $date_to = date("Y-m-d");
?>
