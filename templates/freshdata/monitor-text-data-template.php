<table>
    <tr><td colspan="2"><hr><b>Archive Info:</b><hr></td></tr>
    <?php
    $fields = array("uuid_archive", "Taxa", "Status", "Records", "Trait_selector", "String");
    foreach($fields as $field) echo "<tr><td>$field:</td><td id='value'>".$rec_from_text[$field]."</td></tr>";
    ?>
    <tr><td colspan="2"><hr><b>Additional Fields:</b><hr></td></tr>
    <?php
    $fields = array("Title", "Description", "URL", "Training_materials", "Contact");
    foreach($fields as $field) echo "<tr><td>$field:</td><td id='value'>".$rec_from_text[$field]."</td></tr>";
    ?>
</table>
