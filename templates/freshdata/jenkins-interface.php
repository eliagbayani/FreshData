<span id = "login_form<?php echo $form_elements_index ?>">
<?php
    $disp_total_rows = false;
    $disp_dl_button = false;

    if(file_exists($destination) && filesize($destination))
    {
        // echo "<hr>went here 01<hr>";
        $button_text  = "Refresh";
        if(self::is_there_an_unfinished_job_for_this_uuid($task, $basename)) self::display_message(array('type' => "highlight", 'msg' => "Task is currently running. Please check back soon *.")); //saw this already
        elseif(self::is_task_in_queue($task, $basename))                     self::display_message(array('type' => "highlight", 'msg' => "Task is currently running. Please check back soon **.")); //has not seen this yet
        else
        {
            $disp_total_rows = true;
            $button_text  = "Submit";
            self::display_message(array('type' => "highlight", 'msg' => "Task has finished. &nbsp; File size: ".filesize($destination)." bytes."));
            if($job_type == "download occurrence tsv")
            {
                self::display_message(array('type' => "highlight", 'msg' => "You can now proceed with [Special Queries] tab"));
            }
            elseif($job_type == "apply invasive filter to occurrence") {}

            $zip_path = "TSV_files/$basename".".tsv.gz";
            if(file_exists($zip_path)) echo "<hr><a href='$zip_path'>Download here.</a>";
            else
            {
                echo "Zip does not exist";
                self::gzip_file($basename);
            }
            
            if($job_type == "apply invasive filter to occurrence")
            {
                require_once("templates/freshdata/special-invasive-date-ranges.php");
                require_once($php_form_script);
                
            }
            
        }
    }
    else
    {
        // echo "<hr>went here 02<hr>";
        if(self::is_task_in_queue($task, $basename))
        {
            $button_text  = "Refresh";
            self::display_message(array('type' => "highlight", 'msg' => "This task is already on queue. Please check back soon.")); //saw this already
        }
        elseif(!self::is_there_an_unfinished_job_for_this_uuid($task, $basename))
        {
            // echo "<hr>went bbb<hr>";
            $disp_dl_button = false;
            require_once($php_form_script);
        }
        elseif(!self::is_task_in_queue($task, $basename))
        {
            // echo "<hr>went aaa<hr>";
            $disp_dl_button = false;
            require_once($php_form_script);
        }
        else
        {
            $button_text  = "Refresh";
            self::display_message(array('type' => "highlight", 'msg' => "Task is currently running. Please check back soon ***.")); //has not seen this yet
        }
    }
?>
</span>
<div id="stage<?php echo $form_elements_index ?>" style = "background-color:white;"></div>
<br>
<form action="index.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="uuid"        value="<?php echo $uuid ?>"                 >
<input type="hidden" name="monitorAPI"  value="<?php echo $params['monitorAPI'] ?>" >
<input type="hidden" name="view_type"   value="<?php echo $params['view_type'] ?>"  >
<input type="hidden" name="queries"     value="<?php echo $queries_tab_index ?>"    >
<?php
if(file_exists($destination) && filesize($destination) && $disp_total_rows)
{
    ?>
    <hr>Count total rows:
    <select name="get_count<?php echo $form_elements_index ?>" id="toggleYN">
        <option>
        <?php $yn = array('Yes', 'No');
        foreach($yn as $ans) {
            $selected = "";
            if(@$params['get_count'.$form_elements_index] == $ans) $selected = "selected";
            echo '<option value="' . $ans . '" ' . $selected . '>' . $ans . '</option>';
        }?>
    </select>
    <?php 
    if(@$params['get_count'.$form_elements_index]=='Yes') echo "<br><br>Total rows: ".self::get_total_rows($basename); //param is basename of .tsv filename
    
    ?>
    <hr>Delete TSV:
    <select name="del_tsv<?php echo $form_elements_index ?>" id="toggleYN">
        <option>
        <?php $yn = array('Yes', 'No');
        foreach($yn as $ans) {
            $selected = "";
            if(@$params['del_tsv'.$form_elements_index] == $ans) $selected = "selected";
            echo '<option value="' . $ans . '" ' . $selected . '>' . $ans . '</option>';
        }?>
    </select>
    <?php 
    if(@$params['del_tsv'.$form_elements_index]=='Yes')
    {
        $status = self::delete_tsv_file($basename); //param is basename of .tsv filename
        self::display_message(array('type' => "highlight", 'msg' => "$status [ <i>$basename".".tsv</i> ].  &nbsp; Click [Refresh] to continue."));
        ?><input type="submit" value="Refresh"><?php
    }

    /*
    //apply special query: Invasive
    require_once("templates/freshdata/special-invasive-YN.php");
    */
}
if(!$disp_dl_button)
{
    ?>
    <br><br><input type="submit" value="<?php echo $button_text ?>">
    <?php
}
?>
</form>
