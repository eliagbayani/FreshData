<?php
// namespace php_active_record;
class other_controller
{
    function __construct($params)
    {
        $this->api['search'] = "https://scistarter.com/finder?format=json&key=".SCISTARTER_API_KEY."&q=";
        // Atlantic seabirds and whales lost in the Pacific
        
        // https://scistarter.com/api/project/12977?key=e32de5b4a92bfbb18c519158b2ff93b89016c26f080c39752d8e6584eee6d4cdea496f1e2ce0200adc3263eb8fb09bd867049a2e33d2657751a34e5e5124aa1e
        // https://scistarter.com/finder?format=json&key=e32de5b4a92bfbb18c519158b2ff93b89016c26f080c39752d8e6584eee6d4cdea496f1e2ce0200adc3263eb8fb09bd867049a2e33d2657751a34e5e5124aa1e&q=Fresh%20Data-

        // 17626: Fresh Data- Pacific seabirds and whales lost in the Atlantic
        
        $this->download_options = array('download_timeout_seconds' => 4800, 'download_wait_time' => 300000, 'expire_seconds' => 43200); //expires in 12 hours
    }

    //start invasive ==============================================================================
    function apply_invasive_filter($params)
    {
        $uuid = $params['uuid'];
        // echo "<hr>[$uuid]<hr>eli was here...<hr>";
        $invasives = self::unique_invasive_species_scinames();
        echo "\nInvasive species count: " . count($invasives)."\n";
        
        //prepare for target file
        $filename_target = self::generate_tsv_filepath($uuid."_inv");
        $write = Functions::file_open($filename_target, "w");
        
        //start loop the downloaded TSV and apply the invasive filter, then generate a new filtered TSV
        $filename = self::generate_tsv_filepath($uuid); //param here is basename; basename.tsv
        $fn = Functions::file_open($filename, "r");
        while (($line = fgets($fn)) !== false)
        {
            $arr = explode("\t", $line);
            $taxon = trim($arr[0]);
            if(self::sciname_is_species_and_below($taxon)) //https://eol-jira.bibalex.org/browse/DATA-1682?focusedCommentId=61223&page=com.atlassian.jira.plugin.system.issuetabpanels:comment-tabpanel#comment-61223
            {
                if(!self::taxon_in_filter_list($taxon, $invasives)) //https://eol-jira.bibalex.org/browse/DATA-1682?focusedCommentId=61224&page=com.atlassian.jira.plugin.system.issuetabpanels:comment-tabpanel#comment-61224
                {
                    // echo "<br>[$taxon]";
                    fwrite($write, $line);
                }
            }
        }
        fclose($fn);
        fclose($write);
        self::gzip_file($uuid."_inv");
        self::create_incremental_file_if_needed($params);
    }
    
    private function create_incremental_file_if_needed($params)
    {
        echo "date from: ".$params['date_from'];
        echo "date to: ".$params['date_to'];
        $filename = self::generate_tsv_filepath($params['uuid']."_inv");
        $filename_target = self::generate_tsv_filepath($params['uuid']."_inc_".$params['date_to']); //date("Y-m-d")
        $write = Functions::file_open($filename_target, "w");
        
        $fn = Functions::file_open($filename, "r");
        $i = 0;
        $delete_file = true; //default is true
        while (($line = fgets($fn)) !== false)
        {
            $i++;
            if($i == 1)
            {
                $fields = explode("\t", $line);
                fwrite($write, $line);
            }
            $arr = explode("\t", $line);
            $rec = array(); $k = 0;
            foreach($fields as $field)
            {
                $rec[$field] = $arr[$k];
                $k++;
            }
            //start processing $rec
            // echo "\n[$params[date_from]] - [$params[date_to]]\n";   // firstAddedDate > Jul 1 and firstAddedDate <= Jul 8
            $date = substr($rec['firstAddedDate'],0,10);               // 2017-07-02
            if($date > $params['date_from'] && $date <= $params['date_to'])
            {
                fwrite($write, $line);
                //echo "\n[$date]";
                $delete_file = false;
            }
            //else echo "\nnot - [$date]";
        }
        fclose($fn);
        fclose($write);
        if($delete_file) unlink($filename_target);
        else
        {   //you can tweet the creation of an increment file
            self::tweet_about_the_increment_file($params, $filename_target);
        }
        // self::tweet_about_the_increment_file($params, $filename_target);
        
    }
    
    private function tweet_about_the_increment_file($params, $filename_target)
    {   /*
        [2017-07-03]Array
        01:13:38 (
        01:13:38     [uuid] => 5b6d8474-fcb4-5e16-b5cf-8f8a9a502fc3
        01:13:38     [date_from] => 2017-07-01
        01:13:38     [date_to] => 2017-07-20
        01:13:38 )
        01:13:38 <hr>/Library/WebServer/Documents/FreshData/controllers/../TSV_files/5b6d8474-fcb4-5e16-b5cf-8f8a9a502fc3_inc_2017-07-20.tsv<hr>Finished: SUCCESS
        */
        // print_r($params);
        // echo "<hr>$filename_target<hr>";
        // echo "\n[$params[search_url]]\n"; //is correctly passed but it is too long for a tweet
        // http://127.0.0.1/FreshData/app/lookup.php?uuid=5b6d8474-fcb4-5e16-b5cf-8f8a9a502fc3
        // print_r($_SERVER);

        $link = "http://".DOMAIN_NAME."/FreshData/app/lookup.php?uuid=$params[uuid]";
        $tweet = "Monitor $link produced an increment file. Last: $params[date_from]. Latest: $params[date_to]";
        echo "\ntweet: $tweet\n";

        require("twitter.php");
        $func = new twitter_controller("elix");
        $func->tweet_now($tweet);
    }
    
    function get_incremental_files($uuid)
    {   //5b6d8474-fcb4-5e16-b5cf-8f8a9a502fc3_inc_2017-07-19.tsv
        $arr = array();
        $files = __DIR__ . "/../TSV_files/".$uuid."_inc_*";
        foreach(glob($files) as $filename)
        {
            $arr[] = $filename;
        }
        return $arr;
    }
    
    private function taxon_in_filter_list($taxon, $invasives)
    {
        if(in_array($taxon, $invasives)) return true;
        if(in_array(Functions::canonical_form($taxon), $invasives)) return true;
        foreach($invasives as $invasive)
        {
            if(self::str_exists_infront_of_string($taxon, $invasive)) return true;
        }
        return false;
    }
    private function str_exists_infront_of_string($str, $string)
    {
        $str = trim($str);
        $string = trim($string);
        $count_str = strlen($str);
        if($str == substr($string,0,$count_str)) return true;
        else return false;
    }
    
    private function sciname_is_species_and_below($name)
    {
        if($name == "taxonName") return true; //meaning 1st row, the headers
        $tmp = explode(" ", trim($name));
        if(count($tmp) === 1) return false;
        else
        {
            $second_word = $tmp[1];
            if(ctype_upper($second_word[0])) return false;
            else return true;
        }
        /* echo "<hr>start test<hr>"; $arr = array("Lampyridae Latreille, 1817", "Lampyridae", "Lampyridae ", "Gadus morhua ogac", "Gadus morhua Eli", "Gadus Eli", "Chanos chanos", "Chanos", "chanos");
        foreach($arr as $name)
        {
            echo "<br>$name - ";
            $tmp = explode(" ", trim($name));
            if(count($tmp) === 1) echo "false";
            else
            {
                $second_word = $tmp[1];
                if(ctype_upper($second_word[0])) echo "false";
                else echo "true";
            }
        } echo "<hr>end test<hr>"; */
    }

    function generate_gzip_cmd($basename)
    {
        $source = self::generate_tsv_filepath($basename);
        $target = $source.".gz";
        if(file_exists($source))
        {
            $cmd = "/usr/bin/gzip -c " . $source . " >" . $target;
            $cmd .= " 2>&1";
            return $cmd;
        }
        else return false;
    }
    
    function gzip_file($basename)
    {
        $source = self::generate_tsv_filepath($basename);
        $target = $source.".gz";
        if(file_exists($source))
        {
            if(filesize($source))
            {
                $cmd = "/usr/bin/gzip -c " . $source . " >" . $target;
                $cmd .= " 2>&1";
                $output = shell_exec($cmd);
            }
        }
        else echo "\nCannot gzip. File does not exist: [$source]\n";
    }
    
    private function unique_invasive_species_scinames()
    {
        $scinames = array();
        // $names = self::get_google_sheet(); //uncomment in real operation
        $names = array(); //debug
        foreach($names as $name)
        {
            if($val = @$name[0]) $scinames[$val] = '';
        }
        $scinames = array_keys($scinames);
        $scinames = array_map('trim', $scinames);
        // print_r($scinames);
        echo "<hr>invasives=".count($scinames)."<hr>";
        return $scinames;
    }
    
    private function get_google_sheet() //sheet found here: https://eol-jira.bibalex.org/browse/DATA-1682?focusedCommentId=61079&page=com.atlassian.jira.plugin.system.issuetabpanels:comment-tabpanel#comment-61079
    {
        include(__DIR__ . '/../../eol_php_code/lib/connectors/GoogleClientAPI.php');
        $func = new php_active_record\GoogleClientAPI(); //get_declared_classes(); will give you how to access all available classes
        $params['spreadsheetID'] = '1KMxy2mjx2JRX6CKCqOUXoGbWTGNUTyuOfmFa3Y4d20M';
        $params['range']         = 'Compiled list #2- For the Filter!F2:F'; //where "A" is the starting column, "C" is the ending column, and "2" is the starting row.
        return $func->access_google_sheet($params);
    }
    
    function generate_tsv_filepath($basename)
    {
        return __DIR__ . "/../TSV_files/".$basename.".tsv";
    }

    function loop_tsv_utility($basename) //utility
    {
        $filename_target = self::generate_tsv_filepath($basename);
        $fn = Functions::file_open($filename, "r");
        while (($line = fgets($fn)) !== false)
        {
            $arr = explode("\t", $line);
            $taxon = trim($arr[0]);
            if(stripos($taxon, "Chrysemys picta") !== false) exit("<hr>may problem<hr>");//string is found
        }
    }
    
    //end invasive ================================================================================ uuid


    //start queries ============================================================================
    function generate_exec_command($basename)
    {
        $sh_destination = self::generate_sh_filepath($basename); //pass the desired basename of the filename
        $cmd = "exec $sh_destination";
        $cmd .= " 2>&1";
        return $cmd;
    }

    function generate_sh_filepath($basename)
    {
        return __DIR__ . "/../sh_files/".$basename.".sh";
    }
    
    function build_curl_cmd_for_jenkins($cmd, $jenkins_job, $cmd2 = null) //for download of TSV files
    {
        $c = '/usr/bin/curl -I -X POST -H "'.JENKINS_CRUMB.'" http://'.JENKINS_USER_TOKEN.'@'.JENKINS_DOMAIN.'/job/'.$jenkins_job.'/buildWithParameters?myShell='.urlencode($cmd);
        // if($cmd2) $c .= '&myShell='.urlencode($cmd2); ---> does not work
        $c .= " 2>&1";
        return $c;
    }
    
    function write_to_sh($uuid, $cmd) //uuid is basename for .sh file
    {
        $destination = __DIR__ . "/../sh_files/".$uuid.".sh";
        shell_exec("chmod 755 $destination"); //https://www.shellscript.sh/
        // shell_exec("chmod +x $destination"); //https://www.shellscript.sh/
        if($fn = Functions::file_open($destination, "w"))
        {
            fwrite($fn, "#!/bin/sh" . "\n");
            fwrite($fn, $cmd . "\n");
            fclose($fn);
        }
        else echo "<br>Write to file failed.<br>";
        // sleep(10); //delay for the chmod to take effect
    }
    
    function is_there_an_unfinished_job_for_this_uuid($task, $basename)
    {
        $status = self::get_last_build_console_text($task, $basename);
        if(stripos($status, "$basename.sh") !== false) //string is found
        {
            if(self::is_build_currently_running($status)) return true;
        }
        return false;
    }
    
    function is_task_in_queue($task, $basename)
    {
        $url = "http://".JENKINS_USER_TOKEN."@".JENKINS_DOMAIN."/queue/api/xml";
        // http://localhost:8080/queue/api/xml
        // $url = "http://localhost/queue.xml";
        // echo "<hr>$url<hr>";
        
        $options = $this->download_options;
        $options['expire_seconds'] = 0;
        if($xml = Functions::lookup_with_cache($url, $options))
        {
            $xml = simplexml_load_string($xml);
            // echo"<pre>";print_r($xml);echo"</pre>";
            foreach($xml->item as $item)
            {
                if($item->task->name == $task && stripos($item->params, "$basename.sh") !== false) return true; //string is found
                // echo "<hr>".$item->task->name;
                // echo "<hr>".$item->params;
            }
        }
        return false;
    }
    
    function get_last_build_console_text($task, $basename, $build_no = false) //$id is basename of .sh filename
    {
        //step 1: get_last_build_number
        $last_build_no = self::get_last_build_number($task);
        //step 2: loop downwards, one step at a time
        for($build_no = $last_build_no; $build_no >= ($last_build_no-10); $build_no--)
        {
            // echo "<br> - [$build_no]";
            $status = self::get_task_build_status($task, $build_no);
            if(stripos($status, "$basename.sh") !== false) return $status; //string is found
        }
        return "";
    }
    
    function get_task_build_status($task, $build_no) //get status of this task with this build_no
    {
        $url = "http://".JENKINS_USER_TOKEN."@".JENKINS_DOMAIN."/job/$task/$build_no/consoleText";    //http://localhost:8080/job/wget_job/190/consoleText
        $options = $this->download_options;
        $options['expire_seconds'] = 0;
        if($html = Functions::lookup_with_cache($url, $options)) return $html;
        else echo "<hr>Jenkins API last_build info is not ready 01 [$task].<hr>";
        return false;
    }
    
    function get_last_build_number($task) //e.g. $task = "wget_job"
    {
        // http://localhost:8080/job/wget_job/lastBuild/buildNumber
        $url = "http://".JENKINS_USER_TOKEN."@".JENKINS_DOMAIN."/job/$task/lastBuild/buildNumber";
        $options = $this->download_options;
        $options['expire_seconds'] = 0;
        if($build_no = Functions::lookup_with_cache($url, $options)) return $build_no;
        else echo "<hr>Jenkins API last_build info is not ready 02 [$task].<hr>";
        return false;
    }
    
    function did_build_fail($status)
    {
        if(stripos($status, "404 Not Found") !== false) return true; //string is found
        elseif(stripos($status, "marked build as failure") !== false) return true; //string is found
        elseif(stripos($status, "Finished: FAILURE") !== false) return true; //string is found
        else return false;
    }
    
    function is_build_currently_running($status)
    {
        if(!self::did_build_fail($status) && !self::is_build_finish($status)) return true;
        else return false;
    }
    
    function is_build_finish($status)
    {
        if    (stripos($status, "Finished: SUCCESS") !== false) return true; //string is found
        elseif(stripos($status, "Finished: FAILURE") !== false) return true; //string is found
        else return false;
    }
    
    function get_total_rows($basename) //basename of .tsv filename
    {
        $file = __DIR__ . "/../TSV_files/".$basename.".tsv";
        if(file_exists($file)) return number_format(Functions::count_rows_from_text_file($file)-1);
        else echo "<hr>File does not exist: [$file]<hr>";
    }

    function delete_tsv_file($basename) //basename of .tsv filename
    {
        $file = __DIR__ . "/../TSV_files/".$basename.".tsv";
        $file_gz = $file.".gz";
        if(file_exists($file))
        {
            unlink($file);
            if(file_exists($file_gz)) unlink($file_gz);
            return "File deleted.";
        }
        else return "File does not exist.";
    }
    
    /* not used yet
    function is_tsv_ready($url)
    {
        echo "<hr>elix<hr>";
        $options = $this->download_options;
        $options['expire_seconds'] = 0;
        $options['download_timeout_seconds'] = 10;
        
        if($html = Functions::lookup_with_cache($url, $options))
        {
            echo $html;
        }
        else return false;
    }
    */
    //end queries ==============================================================================
    
    function scistarter_fields()
    {
        return array( //default from https://docs.google.com/spreadsheets/d/1gHdrWRaZbEKp3bCI7kXhN95le-jGvQOXXxeVpgmypJ4/edit?ts=5919e683#gid=0
        "contact_name" => "Jen Hammock",
        "contact_affiliation" => "Encyclopedia of Life",
        "contact_email" => "hammockj@si.edu",
        "contact_address" => "National Museum of Natural History\nSmithsonian Institution\nP.O. Box 37012, MRC 106\nWashington, DC  20013-7012",
        "origin" => "Fresh Data",
        "status" => "active",
        "preregistration" => 'false',
        "goal" => "Collect wildlife observations to support ongoing research and monitoring projects",
        "task" => "photograph and report wildlife online",
        "image" => "http://opendata.eol.org/uploads/group/2017-05-15-172001.731090FDlogo.jpg",
        "image_credit" => "derived from a work by Gerd Altmann, CC0",
        "how_to_join" => "You may report wildlife observations through a variety of platforms. If you do not have a favorite platform already, we suggest joining http://www.inaturalist.org/ to make observations for this project.",
        "special_skills" => "Photography- it needn't be art, but it should be well lit and in focus",
        "gear" => 'Camera + internet. A mobile device will do nicely, but if you prefer a "real camera", you\'ll need to be able to upload the photo later, and make a note of your location and the time when you took it.',
        "outdoors" => 'true',
        "indoors" => 'false',
        "time_commitment" => "five minutes per data contribution",
        "project_type" => "Project",
        "audience" => "High School (14 - 17 years), College, Graduate students, Adults, Families");
    }
    
    static function all_scistarter_fields()
    {
        return array("name", "description", "url", "contact_name", "contact_affiliation", "contact_email", "contact_phone", "contact_address", "presenting_org", "origin", "video_url", "blog_url", "twitter_name", "facebook_page", "status", "preregistration", "goal", "task", "image", "image_credit", "how_to_join", "special_skills", "gear", "outdoors", "indoors", "time_commitment", "project_type", "audience", "regions", "UN_regions", "ProjectID");
    }

    function get_default_values_if_blank($arr, $text1, $monitor)
    {
        $scistarter_fields = self::scistarter_fields();
        $fields = array_keys($arr);
        foreach($fields as $field)
        {
            if(!$arr[$field]) $arr[$field] = @$scistarter_fields[$field];
        }
        if(!$arr['name']) $arr['name'] = "Fresh Data - " . $text1['Title'];
        if(!$arr['description']) $arr['description'] = "Welcome to ".$text1['Title']."! We are eager for online reports of particular wildlife, accompanied by photographs. \n\n".$text1['Description']."\n\nAs with all Fresh Data projects, the simplest way to participate is by submitting your observation and photo through iNaturalist. The iNat community can help you with species identification, and our research team will be notified that you’ve provided fresh data for this research project.";
        if(!$arr['url']) $arr['url'] = $text1['URL'];
        if(!$arr['regions']) $arr['regions'] = self::convert_GEOMETRYCOLLECTION_to_MULTIPOLYGON($monitor['selector']['wktString']);
        return $arr;
    }
    
    public function submit_add_project($params, $uuid)
    {
        $params['key'] = SCISTARTER_API_KEY;
        $params['ProjectName'] = $params['name'];
        $info = self::curl_post_request(SCISTARTER_ADD_PROJECT_API, $params);
        if($obj = self::if_add_is_successful($info))
        {
            echo "<b>Print information below for your reference.</b><p>
            Project Name: $params[name]<br>
            Project ID: $obj->project_id<br>";
            self::put_project_id_in_project($obj, $uuid);
        }
        return $info;
    }
    
    private function if_add_is_successful($info)
    {
        // {"project_id": 17626, "result": "success"}
        if($obj = json_decode($info))
        {
            if($obj->project_id && $obj->result == "success") return $obj;
            else return false;
        }
        else return false;
    }
    
    private function put_project_id_in_project($obj, $uuid)
    {   
        //stdClass Object ( [project_id] => 17626 [result] => success )
        // self::update_field_with_value('ProjectID', $obj->project_id);
        // echo "<hr>$uuid<hr>";
        
        $rec = freshdata_controller::get_text_file_value($uuid, 'scistarter');
        $rec['uuid'] = $uuid;
        $rec['ProjectID'] = $obj->project_id;
        // print_r($rec);
        freshdata_controller::save_to_text_scistarter($rec);
    }
    
    static function curl_post_request($url, $parameters_array = array())
    {
        $data_string = json_encode($parameters_array);
        echo "<hr><b>Print this if you want to inquire about this project to SciStarter in the future. This is the actual data submitted to their write API.</b><br><br>$data_string<hr>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        if(isset($parameters_array) && is_array($parameters_array)) curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        
        // echo("<hr>Sending post request to $url with params ".print_r($parameters_array, 1).": only attempt<hr>");
        $result = curl_exec($ch);

        $arr = json_decode($result);
        if($arr->result == "success") freshdata_controller::display_message(array('type' => "highlight", 'msg' => "Project sent successfully."));
        
        
        if(0 == curl_errno($ch))
        {
            curl_close($ch);
            return $result;
        }
        // echo "<hr><b>Curl error ($url):</b><br><br>" . curl_error($ch)."<hr>";
        
        freshdata_controller::display_message(array('type' => "error", 'msg' => "Curl error ($url)"));
        freshdata_controller::display_message(array('type' => "error", 'msg' => curl_error($ch)));
        
        
        return false;
    }
    
    private function convert_GEOMETRYCOLLECTION_to_MULTIPOLYGON($str)
    {
        /*
        POLYGON ((-82.6171875 32.54681317351517, -72.7734375 44.84029065139799, -59.765625 53.12040528310657, -67.1484375 57.136239319177434, -74.1796875 60.75915950226991, -84.55078125 66.56, 14.23828125 66.56, 1.0546875 46.55886030311719, -5.2734375 32.84267363195431, -82.6171875 32.54681317351517))
        -> get as is
        
        GEOMETRYCOLLECTION(
            POLYGON ((-175.78125 32.54681317351514, -175.78125 66.51326044311185, -135.703125 61.938950426660604, -121.640625 52.908902047770255, -117.7734375 32.71, -175.78125 32.54681317351514)),
            POLYGON ((116.71874999999999 32.71, 130.78125 47.517200697839414, 137.109375 63.548552232036414, 150.46875 62.59334083012024, 165.9375 63.860035895395306, 175.78125 66.51326044311185, 175.78125 33.137551192346145, 116.71874999999999 32.71))
            )
        -> convert to below:
        MULTIPOLYGON(
            ((-175.78125 32.54681317351514, -175.78125 66.51326044311185, -135.703125 61.938950426660604, -121.640625 52.908902047770255, -117.7734375 32.71, -175.78125 32.54681317351514)),
            ((116.71874999999999 32.71, 130.78125 47.517200697839414, 137.109375 63.548552232036414, 150.46875 62.59334083012024, 165.9375 63.860035895395306, 175.78125 66.51326044311185, 175.78125 33.137551192346145, 116.71874999999999 32.71))
            )
        */
        
        if(stripos($str, "GEOMETRYCOLLECTION") !== false) //string is found
        {
            $str = str_ireplace("POLYGON", "", $str);
            $str = str_ireplace("GEOMETRYCOLLECTION", "MULTIPOLYGON", $str);
        }
        return $str;
    }

}
?>
