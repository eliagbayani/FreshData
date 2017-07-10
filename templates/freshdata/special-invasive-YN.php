<hr>Apply filter 'Invasive Species':
<select name="apply_invasive" id="toggleYN">
    <option>
    <?php $yn = array('Yes', 'No');
    foreach($yn as $ans) {
        $selected = "";
        if(@$params['apply_invasive'] == $ans) $selected = "selected";
        echo '<option value="' . $ans . '" ' . $selected . '>' . $ans . '</option>';
    }?>
</select>
<?php 
if(@$params['apply_invasive']=='Yes') echo "<br><br>Invasiveness applied";
?>
