<?php
// namespace php_active_record;

class freshdata_controller extends other_controller
{
    function __construct($params = null)
    {
        // $this->bhl_api_service['booksearch']  = "http://www.biodiversitylibrary.org/api2/httpquery.ashx?op=BookSearch&apikey=" . BHL_API_KEY;
        // $this->bhl_api_service['itemsearch']  = "http://www.biodiversitylibrary.org/api2/httpquery.ashx?op=GetItemMetadata&pages=t&ocr=t&parts=t&apikey=" . BHL_API_KEY;
        // $this->mediawiki_api = "http://" . $_SERVER['SERVER_NAME'] . "/" . MEDIAWIKI_MAIN_FOLDER . "/api.php";
        $this->download_options = array('download_timeout_seconds' => 4800, 'download_wait_time' => 300000, 'expire_seconds' => 43200); //expires in 12 hours

        // /*
        // $this->monitors_api['all'] = "http://api.effechecka.org/monitors";
        // $this->monitors_api['all'] = "http://localhost/FreshData/database/archive/monitors.json";
        $this->monitors_api['all'] = "http://editors.eol.org/FreshData/database/archive/monitors.json";
        
        $this->monitors_api['one'] = "http://api.effechecka.org/monitors?uuid=";
        $this->monitors_api['id']  = "http://api.effechecka.org/monitors?id=";
        $this->monitors_api['source']  = "http://api.effechecka.org/monitors?source=";
        $this->monitors_api['id_source']  = "http://api.effechecka.org/monitors?id=id_val&source=source_val";
        // */

        // $this->monitors_api['all2']          = "http://localhost/FreshData/database/archive/monitors.json";
        $this->monitors_api['all2']          = "http://editors.eol.org/FreshData/database/archive/monitors.json";
        // $this->monitors_api['one']          = "http://api.effechecka.org/zmonitors?uuid=";
        // $this->monitors_api['id']           = "http://api.effechecka.org/zmonitors?id=";
        // $this->monitors_api['source']       = "http://api.effechecka.org/zmonitors?source=";
        // $this->monitors_api['id_source']    = "http://api.effechecka.org/zmonitors?id=id_val&source=source_val";
        
        $this->api['effechecka_occurrences'] = "http://api.effechecka.org/occurrences.tsv";
        
    }

    // start queries ======================================================================
    // end queries ========================================================================
    
    function user_is_logged_in_wiki($view_type)
    {
        if(@$_SESSION["freshdata_user_logged_in"]) return true;
        else
        {
            self::display_message(array('type' => "error", 'msg' => "Cannot open Admin page. <a href='" . "http://" . $_SERVER['SERVER_NAME'] . "/github-php-client/app/login/index.php?view_type=$view_type'>You must login using your GitHub account first</a>."));
            self::display_message(array('type' => "highlight", 'msg' => "Go back to <a href='index.php'>public view</a>."));
            return false;
        }
    }

    function start_backup()
    {
        $file = "http://editors.eol.org/FreshData/database/manually_added_monitors.txt";
        echo "\nbackup starts now...\n";
        $download_params = $this->download_options;
        $download_params['expire_seconds'] = 0;
        $json = Functions::lookup_with_cache($file, $download_params);
        $destination = __DIR__ . "/../app/backup/".date("Y-m-d")."_manually_added_monitors.txt";
        echo "\ndestination: [$destination]\n";
        $fn = fopen($destination, "w");
        fwrite($fn, $json . "\n");
        fclose($fn);
    }

    function manually_added_monitor($uuid)
    {
        if(substr($uuid,0,2) == "m-") return true;
        return false;
    }
    function save_manually_added_uuid($uuid)
    {
        $manually_added_uuids = self::get_manually_added_uuids();
        $manually_added_uuids[] = $uuid;
        self::save_manually_added_ids_2text($manually_added_uuids);
    }
    private function save_manually_added_ids_2text($manually_added_uuids)
    {
        // $manually_added_uuids = array_filter($manually_added_uuids); //remove null arrays
        $manually_added_uuids = array_values($manually_added_uuids); //reindex key
        
        
        $json = json_encode($manually_added_uuids);
        $filename = __DIR__ . "/../database/manually_added_monitors.txt"; //added extra ../ bec. curdir is inside templates/freshdata/
        $fn = fopen($filename, "w");
        fwrite($fn, $json . "\n");
        fclose($fn);
        
    }
    private function get_manually_added_uuids()
    {
        $filename = __DIR__ . "/../database/manually_added_monitors.txt"; //added extra ../ bec. curdir is inside templates/freshdata/
        if(!file_exists($filename))
        {
            $fn = fopen($filename, "w");
            // fwrite($fn, $json . "\n");
            fclose($fn);
        }
        $json = file_get_contents($filename);
        return json_decode($json, true);
    }
    private function get_manually_added_monitors($monitors)
    {
        $manually_added_uuids = self::get_manually_added_uuids();
        // echo"<pre>"; print_r($manually_added_uuids); echo "</pre>";
        if($manually_added_uuids)
        {
            foreach($manually_added_uuids as $uuid) $monitors[] = array("selector" => array("uuid" => $uuid));
        }
        return $monitors;
    }
    function delete_manually_added_uuid($params)
    {
        $manually_added_uuids = self::get_manually_added_uuids();
        // echo"<pre>"; print_r($manually_added_uuids); echo "</pre>";
        $manually_added_uuids = array_diff($manually_added_uuids, [$params['uuid_archive']]); //used to delete an array based on an array list of values
        self::save_manually_added_ids_2text($manually_added_uuids);
        // echo"<pre>"; print_r($manually_added_uuids); echo "</pre>";
        
        // delete here the text file in /database/
        $filename = __DIR__ . "/../" . self::get_uuid_text_file_path($params['uuid_archive']); //added extra ../ bec. curdir is inside templates/freshdata/
        unlink($filename);
        // echo "<br>Deleted: [$filename]<br>";
    }
    function monitors_list($params)
    {
        /*
        self::display_message(array('type' => "highlight", 'msg' => "System maintenance, please try again later."));
        self::display_message(array('type' => "highlight", 'msg' => "Original <a href='http://api.effechecka.org/monitors'>Monitors API</a> truncated."));
        return;
        */
        
        if(in_array($params['view_type'], array('delRecs', 'manRecs'))) $manual_mode = true;
        else                                                            $manual_mode = false;
        
        $download_params = $this->download_options;
        if(isset($params['refresh_cache']))
        {
            $download_params['expire_seconds'] = true;
            self::display_message(array('type' => "highlight", 'msg' => "Cache refreshed."));
        }
        
        $json = Functions::lookup_with_cache($this->monitors_api['all'], $download_params);
        if(!$json)
        {
            echo "<br>Original Monitors API discontinued 01.<br>";
            $json = Functions::lookup_with_cache($this->monitors_api['all2'], $download_params);
        }
        
        $monitors = json_decode($json, true);
        //--------------
        if($params['monitorAPI'] == 0 || $manual_mode) $monitors = self::get_manually_added_monitors($monitors); //unhooked
        //--------------
        $recs = array();
        foreach($monitors as $m)
        {   /*
            Array
            (
                [selector] => Array
                    (
                        [taxonSelector] => Puffinus puffinus
                        [wktString] => POLYGON((-98.98681640625 21.207458730482653, -98.98681640625 30.41078179084589, -81.71630859375 30.41078179084589, -81.71630859375 21.207458730482653, -98.98681640625 21.207458730482653))
                        [traitSelector] => 
                        [uuid] => 38361b26-7a71-5134-aaf3-edb58a439941
                    )
                [status] => ready
                [recordCount] => 10
            )
            */
            if($params['monitorAPI'] == 0 || $manual_mode) //unhooked
            {
                $uuid = $m['selector']['uuid'];
                $rec_from_text = self::get_text_file_value($uuid);
                $info = array();
                // print_r($rec_from_text);
                /* Array ( [Title] => [Description] => [URL] => [Training_materials] => [Contact] => [uuid_archive] => [Taxa] => [Status] => [Records] => [Trait_selector] => [String] => ) */
                $info['taxonSelector']  = $rec_from_text['Taxa'];
                $info['wktString']      = $rec_from_text['String'];
                $info['traitSelector']  = $rec_from_text['Trait_selector'];
                // $info['uuid']           = $rec_from_text['uuid_archive'];
                $info['uuid']           = $uuid;
                $info['status']         = $rec_from_text['Status'];
                $info['recordCount']    = $rec_from_text['Records'];
                if($params['view_type'] == 'scistarter')
                {
                    if(self::has_title_desc_url($rec_from_text['uuid_archive'])) $recs[] = $info;
                }
                elseif($params['view_type'] == 'public' || $params['view_type'] == 'admin')
                {
                    if(self::valid_for_public($info)) $recs[] = $info;
                }
                elseif($params['view_type'] == 'delRecs')
                {
                    if(self::valid_for_deleted_recs($info))
                    {
                        // $recs[] = $info; //orig but gives blank records as expected
                        $m = self::get_monitor_record($info['uuid']);
                        $info = array();
                        $info['taxonSelector']  = $m['selector']['taxonSelector'];
                        $info['wktString']      = $m['selector']['wktString'];
                        $info['traitSelector']  = $m['selector']['traitSelector'];
                        $info['uuid']           = $m['selector']['uuid'];
                        $info['status']         = @$m['status'];
                        $info['recordCount']    = $m['recordCount'];
                        $recs[] = $info;
                    }
                }
                elseif($params['view_type'] == 'manRecs')
                {
                    if(self::valid_for_manual_recs($info)) $recs[] = $info;
                }
                else $recs[] = $info;
            }
            elseif($params['monitorAPI'] == 1)
            {
                $info = array();
                $info['taxonSelector']  = $m['selector']['taxonSelector'];
                $info['wktString']      = $m['selector']['wktString'];
                $info['traitSelector']  = $m['selector']['traitSelector'];
                $info['uuid']           = $m['selector']['uuid'];
                $info['status']         = @$m['status'];
                $info['recordCount']    = $m['recordCount'];
                if($params['view_type'] == 'scistarter')
                {
                    if(self::has_title_desc_url($m['selector']['uuid'])) $recs[] = $info;
                }
                elseif($params['view_type'] == 'public')
                {
                    if(self::valid_for_public($info)) $recs[] = $info;
                }
                elseif($params['view_type'] == 'delRecs')
                {
                    if(self::valid_for_deleted_recs($info)) $recs[] = $info;
                }
                elseif($params['view_type'] == 'manRecs')
                {
                    if(self::valid_for_manual_recs($info)) $recs[] = $info;
                }
                else $recs[] = $info;
            }
            
            
        }
        return array("total" => count($recs), "recs" => $recs);
    }
    
    function append_additional_fields($id = null, $source = null)
    {
        if($id && $source)
        {
            $url = $this->monitors_api['id_source'];
            $url = str_replace("id_val", $id, $url);
            $url = str_replace("source_val", $source, $url);
            $json = Functions::lookup_with_cache($url, $this->download_options);
        }
        elseif($id)     $json = Functions::lookup_with_cache($this->monitors_api['id'].$id, $this->download_options);
        elseif($source) $json = Functions::lookup_with_cache($this->monitors_api['source'].$source, $this->download_options);
        else
        {
            $json = Functions::lookup_with_cache($this->monitors_api['all'], $this->download_options);
            if(!$json)
            {
                echo "<br>Original Monitors API discontinued 02.<br>";
                $json = Functions::lookup_with_cache($this->monitors_api['all2'], $this->download_options);
            }
        }
        $rows = json_decode($json, true);
        $i = 0;
        foreach($rows as $r)
        {
            $rek = array();
            if($id && $source) $rek = self::get_text_file_value(@$r['uuid']);
            else               $rek = self::get_text_file_value(@$r['selector']['uuid']);
            
            if($rek)
            {
                if($id && $source)
                {
                    $rows[$i]['Title']          = $rek['Title'];
                    $rows[$i]['Description']    = $rek['Description'];
                    $rows[$i]['URL']            = $rek['URL'];
                    $rows[$i]['Training_materials'] = $rek['Training_materials'];
                    $rows[$i]['Contact']            = $rek['Contact'];
                }
                else
                {
                    $rows[$i]['selector']['Title']          = $rek['Title'];
                    $rows[$i]['selector']['Description']    = $rek['Description'];
                    $rows[$i]['selector']['URL']            = $rek['URL'];
                    $rows[$i]['selector']['Training_materials'] = $rek['Training_materials'];
                    $rows[$i]['selector']['Contact']            = $rek['Contact'];
                }
            }
            $i++;
        }
        //from array to json
        $json = json_encode($rows, JSON_PRETTY_PRINT);
        return $json;
    }
    
    function has_title_desc_url($uuid)
    {
        $rec = self::get_text_file_value($uuid);
        if($rec['Title'] && $rec['Description'] && $rec['URL']) return true;
        return false;
    }
    
    function has_scistarter_project_name($uuid)
    {
        $rec = self::get_text_file_value($uuid, "scistarter");
        // echo"<pre>"; print_r($rec); echo"</pre>";
        if($rec['name'] && $rec['contact_name']) return true;
        else return false;
    }
    
    private function valid_for_public($info)
    {
        if($info['taxonSelector'] || $info['wktString'] || $info['traitSelector'] || $info['status'] || $info['recordCount']) return true; //at least one with value
        else return false;    
    }

    private function valid_for_deleted_recs($info)
    {
        if(!$info['taxonSelector'] && !$info['wktString'] && !$info['traitSelector'] && !$info['status'] && !$info['recordCount']) return true; //all 5 fields must be blank
        else return false;    
    }

    private function valid_for_manual_recs($info)
    {
        if(self::manually_added_monitor($info['uuid'])) return true;
        else return false;
    }

    function process_uuid($uuid, $what = null)
    {
        self::create_text_file_if_does_not_exist($uuid, $what);
        $rec = self::get_text_file_value($uuid, $what);
        // echo "<pre>"; print_r($rec); echo "</pre>";
        return $rec;
    }
    
    function get_monitor_record($uuid)
    {
        // if($json = Functions::lookup_with_cache($this->monitors_api['one'].$uuid, $this->download_options))
        if(false)
        {
            
            $monitor = json_decode($json, true);
            print_r($monitor);
            echo "<hr>here 01<hr>";
            echo "<hr>".$this->monitors_api['one'].$uuid."<hr>";
        }
        else //use cached monitors and get the single monitor from it
        {
            $json = Functions::lookup_with_cache($this->monitors_api['all2'], $this->download_options);
            $monitors = json_decode($json, true);
            foreach($monitors as $monitor)
            {
                if($monitor['selector']['uuid'] == $uuid) return $monitor;
                // echo "<pre>";print_r($monitor);echo "</pre>";
            }
        }
        return array();
    }
    
    //start params scheme
    function params_is_uuid($uuid)
    {
        $json = Functions::lookup_with_cache($this->monitors_api['one'].$uuid, $this->download_options);
        $row = json_decode($json, true);
        if($rek = self::get_text_file_value($uuid))
        {
            $row['selector']['Title']          = $rek['Title'];
            $row['selector']['Description']    = $rek['Description'];
            $row['selector']['URL']            = $rek['URL'];
            $row['selector']['Training_materials']  = $rek['Training_materials'];
            $row['selector']['Contact']             = $rek['Contact'];
        }
        //from array to json
        $json = json_encode($row, JSON_PRETTY_PRINT);
        return $json;
    }
    //end params scheme
    
    function get_field_value($uuid, $fieldname, $what)
    {
        $arr = self::get_text_file_value($uuid, $what);
        return $arr[$fieldname];
    }
    
    function get_text_file_value($uuid, $what = null)
    {
        // $fields = array("Title", "Description", "URL", "field4", "field5"); //orig
        
        if($what == 'scistarter') $fields = other_controller::all_scistarter_fields();
        else
        {
            $fields = array("Title", "Description", "URL", "Training_materials", "Contact"); //original Admin
            $fields = array("Title", "Description", "URL", "Training_materials", "Contact", "uuid_archive", "Taxa", "Status", "Records", "Trait_selector", "String"); //new Admin
        }
        
        $filename = self::get_uuid_text_file_path($uuid, $what);
        if(file_exists($filename))
        {
            if($file_size = filesize($filename))
            {
                $fn = Functions::file_open($filename, "r");
                $tsv = fread($fn, $file_size);
                $arr = explode("\t", $tsv);
                /*
                Title (pretty short character limit text box); 
                Description (longer character limit, for a paragraph or so); 
                URL (if there can be validation in here that the content is a url, 
                */
                $i = 0;
                $final = array();
                foreach($arr as $val)
                {
                    // echo "<br>" . $fields[$i]; //debug
                    $final[$fields[$i]] = $val;
                    $i++;
                }
                //=========================================
                if($what != 'scistarter')
                {
                    if(!isset($final['uuid_archive']))
                    {
                        $final = self::fill_up_main_monitor_fields($final, $uuid);
                        echo "<br>passed 111<br>";

                        //these 2 lines are needed to save to text file the main monitor fields, also when txt's are newly pasted in /database/uuid/
                        $final['uuid'] = $uuid;
                        self::save_to_text($final);
                    }
                    else
                    {
                        if(!$final['uuid_archive']) 
                        {
                            $final = self::fill_up_main_monitor_fields($final, $uuid);
                            // echo "<pre>"; print_r($final); echo "</pre>";
                            // echo "<br>passed 222 [$uuid]<br>";
                            
                            //these 2 lines are needed to save to text file the main monitor fields, also is needed when un-deleting record; that is when saving with blank uuid
                            $final['uuid'] = $uuid;
                            self::save_to_text($final);
                        }
                        // else echo "<hr>filled-up OK<hr>";
                    }
                }
                //=========================================
            }
            else
            {
                $final = array();
                foreach($fields as $field) $final[$field] = "";
            }
        }
        else
        {
            // echo "\n111[$filename]\n";
            // echo "\n".__DIR__."\n";
            $final = array();
            foreach($fields as $field) $final[$field] = "";
        }
        return $final;
    }
    
    function generate_freshdata_search_url($arr)
    {
        return FRESHDATA_DOMAIN."?taxonSelector=".$arr['Taxa']."&traitSelector=".$arr['Trait_selector']."&wktString=".$arr['String'];
    }
    
    private function fill_up_main_monitor_fields($final, $uuid)
    {
        // echo "<hr>not yet filled-up<hr>";
        $monitor = self::get_monitor_record($uuid);
        // echo "<pre>"; print_r($monitor); echo "</pre>";
        /*
        Array
        (
            [selector] => Array
                (
                    [taxonSelector] => Animalia|Insecta
                    [wktString] => POLYGON ((-150 10, -150 40, -50 40, -50 10, -150 10))
                    [traitSelector] => 
                    [uuid] => 5ffd7bae-5fe0-5692-b914-bf90e921fa1b
                )
            [status] => ready
            [recordCount] => 111278193
        )
        */
        $final['uuid_archive'] = $monitor['selector']['uuid'];
        $final['Taxa'] = $monitor['selector']['taxonSelector'];
        $final['Status'] = @$monitor['status'];
        $final['Records'] = $monitor['recordCount'];
        $final['Trait_selector'] = $monitor['selector']['traitSelector'];
        $final['String'] = $monitor['selector']['wktString'];
        return $final;
    }
    
    function create_text_file_if_does_not_exist($uuid, $what = null)
    {
        $filename = self::get_uuid_text_file_path($uuid, $what);
        if(!file_exists($filename))
        {
            $fn = Functions::file_open($filename, "w");
            if($what == 'scistarter') fwrite($fn, str_repeat("\t", 30)); //creates total 31 fields: 30 for scistarter forms and 1 for ProjectID
            else
            {
                // fwrite($fn, "\t\t\t\t"); //creates five fields - for original Admin
                fwrite($fn, str_repeat("\t", 10)); //new admin, creates 11 fields
            }
            fclose($fn);
            // echo "<br>[$what]<br>"; //debug
        }
        // else echo "<br>file already created<br>"; //debug
    }

    function get_uuid_text_file_path($uuid, $what = null)
    {
        if($what == "lookup") return __DIR__."/../database/uuid/$uuid.txt";
        else //original
        {
            if($what) return "database/$what/$uuid" . ".txt";
            else      return "database/uuid/$uuid" . ".txt";
        }
    }
    
    // function save_monitor($params)
    // {
    //     // $params =& $_GET;
    //     // if(!$params) $params =& $_POST;
    //     echo "<pre>"; print_r($params); echo "</pre>";
    //     if(self::save_to_text($params))
    //     {
    //         echo "<br>Saved OK<br>";
    //     }
    // }
    
    function save_to_text($params)
    {
        $uuid = $params['uuid'];
        $filename = __DIR__ . "/../" . self::get_uuid_text_file_path($uuid); //added extra ../ bec. curdir is inside templates/freshdata/monitor-save.php
        if($fn = Functions::file_open($filename, "w"))
        {
            // fwrite($fn, $params['Title'] . "\t" . $params['Description'] . "\t" . $params['URL'] . "\t\t"); //saves five fields //orig
            // fwrite($fn, $params['Title'] . "\t" . $params['Description'] . "\t" . $params['URL'] . "\t" . $params['Training_materials'] . "\t" . $params['Contact']); //saves five fields

            fwrite($fn, $params['Title'] . "\t" . $params['Description'] . "\t" . $params['URL'] . "\t" . $params['Training_materials'] . "\t" . $params['Contact'] . "\t" . 
                        $params['uuid_archive'] . "\t" . $params['Taxa'] . "\t" . $params['Status'] . "\t" . $params['Records'] . "\t" . $params['Trait_selector'] . "\t" . $params['String']);
            

            fclose($fn);
            return true;
        }
        return false;
    }

    function save_to_text_scistarter($params)
    {
        $uuid = $params['uuid'];
        $filename = __DIR__ . "/../" . self::get_uuid_text_file_path($uuid, 'scistarter'); //added extra ../ bec. curdir is inside templates/freshdata/monitor-save-scistarter.php
        if($fn = Functions::file_open($filename, "w"))
        {
            $fields = other_controller::all_scistarter_fields();
            $final = array();
            foreach($fields as $field) $final[$field] = $params[$field];
            $final = implode("\t", $final);
            fwrite($fn, $final); //saves 30 fields
            fclose($fn);
            return true;
        }
        return false;
    }
    
    function get_realname($username)
    {
        $url = "/LiteratureEditor/api.php?action=query&meta=userinfo&uiprop=groups|realname&format=json";
        $json = self::get_api_result($url);
        $obj = json_decode($json);
        if($val = @$obj->query->userinfo->realname) return $val;
        return $username;
    }
    
    function get_api_result($url)
    {
        $session_cookie = MW_DBNAME.'_session';
        if(!isset($_COOKIE[$session_cookie])) return false;
        $url = "http://" . $_SERVER['SERVER_NAME'] . $url;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_COOKIE, $session_cookie . '=' . $_COOKIE[$session_cookie]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $string = curl_exec($ch);
        curl_close($ch);
        return $string;
    }
    
    function get_api_result_via_post($url, $post)
    {
        $session_cookie = MW_DBNAME.'_session';
        if(!isset($_COOKIE[$session_cookie])) return false;
        $url = "http://" . $_SERVER['SERVER_NAME'] . $url;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_COOKIE, $session_cookie . '=' . $_COOKIE[$session_cookie]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $string = curl_exec($ch);
        curl_close($ch);
        return $string;
    }

    public static function index() {}
    
    function render_layout($p, $template)
    {
        if($template == 'result')
        {
            if(in_array(@$p['search_type'], array('booksearch', 'itemsearch', 'titlesearch', 'pagetaxasearch', 'pagesearch')))
            {
                $xml = self::search_bhl($p);
                if(    @$p['search_type'] == 'booksearch')      echo self::render_template('booksearch-result', array('xml' => $xml));
                elseif(@$p['search_type'] == 'itemsearch')      echo self::render_template('itemsearch-result', array('xml' => $xml));
            }
            // else echo "<br>investigate pls.[$template]<br>";
        }
        return self::render_template($template, array('book_title' => @$p['book_title'], 'volume' => @$p['volume'], 'lname' => @$p['lname'], 'use_cache' => @$p['use_cache']));
    }
    
    function render_template($filename, $variables)
    {
        extract($variables); //makes the array index value to become a variable e.g. array("a" => "dog") becomes $a = "dog";
        ob_start();
        require('templates/freshdata/' . $filename . '.php');
        $contents = ob_get_contents(); 
        ob_end_clean();
        return $contents;
    }
    
    static function display_message($options)
    {   //displays Highlight or Error messages
        if($options['type'] == "highlight")
        {
            echo'<div class="ui-widget"><div class="ui-state-highlight ui-corner-all" style="margin-top: 0px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span><strong>Info:</strong>&nbsp; ' . $options['msg'] . '</p></div></div>';
        }
        elseif($options['type'] == "error")
        {
            echo'<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Alert:</strong>&nbsp; ' . $options['msg'] . '</p></div></div>';
        }
    }
    
    function create_guid()
    {
        $tmp = "M-".sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
        return strtolower($tmp);
    }

}