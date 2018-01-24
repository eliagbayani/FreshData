<table>
    <tr><td colspan="2"><hr><b>Archive Info:</b><hr></td></tr>
    <?php
    self::main_fields_display($rec_from_text);
    if(!isset($search_url)) $search_url = self::generate_freshdata_search_url($rec_from_text);
    if($search_url) {
        ?>
        <tr><td colspan="2">
        <a target="<?php echo $uuid ?>" href="<?php echo $search_url ?>">Search Fresh Data</a>
        </td></tr>
        <?php
    }
    ?>

    <tr><td colspan="2"><hr><b>Additional Fields:</b><hr></td></tr>
    <?php
    $fields = array("Title", "Description", "URL", "Training_materials", "Contact");
    foreach($fields as $field) echo "<tr><td>$field:</td><td id='value'>".$rec_from_text[$field]."</td></tr>";
    ?>
</table>
