<span id = "login_form<?php echo $form_elements_index ?>">
<?php
    $disp_total_rows = false;
    $disp_dl_button = false;

    if(file_exists($destination) && filesize($destination))
    {
        // echo "<hr>went here 01<hr>";
        $button_text  = "Refresh";
        if(self::is_there_an_unfinished_job_for_this_uuid($short_task, $basename)) self::display_message(array('type' => "highlight", 'msg' => "Task is currently running. Please check back soon *.")); //saw this already
        elseif(self::is_task_in_queue($short_task, $basename))                     self::display_message(array('type' => "highlight", 'msg' => "Task is in queue. Please check back soon **.")); //sqw this already
        else
        {
            $disp_total_rows = true;
            $button_text  = "Submit";
            self::display_message(array('type' => "highlight", 'msg' => "$done_msg (".date("Y-m-d",filectime($destination)).") &nbsp; File size: ".Functions::formatSizeUnits(filesize($destination))));
            if($job_type == "download occurrence tsv")
            {
                self::display_message(array('type' => "highlight", 'msg' => "You can now proceed with  &nbsp;<b>[Special Queries]</b> &nbsp;tab."));
            }
            elseif($job_type == "apply invasive filter to occurrence") {}

            $zip_path = "TSV_files/$basename".".tsv.gz";
            if(file_exists($zip_path)) echo "<hr><a href='$zip_path'>Download here.</a>";
            else
            {
                echo "Zip does not exist";
                // self::gzip_file($basename); //no longer needed since when downloading (wget) - gzip follows wget in sh file
            }
            
            if($job_type == "apply invasive filter to occurrence")
            {
                require_once("templates/freshdata/special-invasive-date-ranges.php");
                require_once($php_form_script);
                if($incrementals = self::get_incremental_files($uuid))
                {
                    require_once("templates/freshdata/special-incremental-files.php");
                }
            }
            
        }
    }
    else
    {
        // echo "<hr>went here 02<hr>";
        if(self::is_task_in_queue($short_task, $basename))
        {
            $button_text  = "Refresh";
            self::display_message(array('type' => "highlight", 'msg' => "This task is already on queue. Please check back soon.")); //saw this already
        }
        elseif(!self::is_there_an_unfinished_job_for_this_uuid($short_task, $basename))
        {
            $disp_dl_button = false;
            require_once($php_form_script);
        }
        elseif(!self::is_task_in_queue($short_task, $basename))
        {
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
    if($val = @$params['inc_del_file'])
    {
        $status = self::delete_tsv_file($val);
        // echo "<hr>Deletedx: $status [$val]<hr>"; //debug
        $params['inc_del_file'] = ''; //delete in first pass of jenkins-interface.php
    }
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
    <br><br>
    <?php echo $del_label ?> <!---<?php echo "[$basename]" ?>--->
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
        self::display_message(array('type' => "highlight", 'msg' => "$status &nbsp; Click <b>Refresh</b> to continue.")); //[<i>$basename".".tsv</i>]
        ?><br><input type="submit" value="Refresh"><?php
    }

    /*
    //apply special query: Invasive
    require_once("templates/freshdata/special-invasive-YN.php");
    */
}
if(!$disp_dl_button)
{
    if(!in_array($button_text, array("Continue 1", "Continue 2")))
    {
        ?>
        <br><br><input type="submit" value="<?php echo $button_text ?>">
        <?php
    }
}
?>
</form>
