<?php
// namespace php_active_record;

class freshdata_controller extends other_controller
{
    function __construct($params)
    {
        // $this->bhl_api_service['booksearch']  = "http://www.biodiversitylibrary.org/api2/httpquery.ashx?op=BookSearch&apikey=" . BHL_API_KEY;
        // $this->bhl_api_service['itemsearch']  = "http://www.biodiversitylibrary.org/api2/httpquery.ashx?op=GetItemMetadata&pages=t&ocr=t&parts=t&apikey=" . BHL_API_KEY;
        // $this->mediawiki_api = "http://" . $_SERVER['SERVER_NAME'] . "/" . MEDIAWIKI_MAIN_FOLDER . "/api.php";
        $this->download_options = array('download_timeout_seconds' => 4800, 'download_wait_time' => 300000, 'expire_seconds' => false);
        $this->monitors_api['all'] = "http://api.effechecka.org/monitors";
        $this->monitors_api['one'] = "http://api.effechecka.org/monitors?uuid=";
    }

    function user_is_logged_in_wiki()
    {
        if(@$_SESSION["freshdata_user_logged_in"]) return true;
        else
        {
            self::display_message(array('type' => "error", 'msg' => "Cannot proceed. <a href='" . "http://" . $_SERVER['SERVER_NAME'] . "/github-php-client/app/login/'>You must login from GitHub first</a>."));
            return false;
        }
    }
    
    function monitors_list()
    {
        $download_params = array("expire_seconds" => false);
        $json = Functions::lookup_with_cache($this->monitors_api['all'], $download_params);
        $monitors = json_decode($json, true);
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
            $info = array();
            $info['taxonSelector']  = $m['selector']['taxonSelector'];
            $info['wktString']      = $m['selector']['wktString'];
            $info['traitSelector']  = $m['selector']['traitSelector'];
            $info['uuid']           = $m['selector']['uuid'];
            $info['status']         = $m['status'];
            $info['recordCount']    = $m['recordCount'];
            $recs[] = $info;
        }
        return array("total" => count($recs), "recs" => $recs);
    }
    
    function process_uuid($uuid)
    {
        self::create_text_file_if_does_not_exist($uuid);
        $rec = self::get_text_file_value($uuid);
        // echo "<pre>"; print_r($rec); echo "</pre>";
        return $rec;
    }
    
    function get_monitor_record($uuid)
    {
        $json = Functions::lookup_with_cache($this->monitors_api['one'].$uuid, $this->download_options);
        $monitor = json_decode($json, true);
        return $monitor;
    }
    
    function get_text_file_value($uuid)
    {
        $fields = array("Title", "Description", "URL", "field4", "field5");
        $filename = self::get_uuid_text_file_path($uuid);
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
            }
            else
            {
                $final = array();
                foreach($fields as $field) $final[$field] = "";
            }
        }
        else
        {
            $final = array();
            foreach($fields as $field) $final[$field] = "";
        }
        return $final;
    }
    
    function create_text_file_if_does_not_exist($uuid)
    {
        $filename = self::get_uuid_text_file_path($uuid);
        if(!file_exists($filename))
        {
            $fn = Functions::file_open($filename, "w");
            fwrite($fn, "\t\t\t\t"); //creates five fields
            fclose($fn);
            // echo "<br>file created<br>"; //debug
        }
        // else echo "<br>file already created<br>"; //debug
    }

    function get_uuid_text_file_path($uuid)
    {
        return "database/uuid/$uuid" . ".txt";
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
        $filename = "../../" . self::get_uuid_text_file_path($uuid); //added extra ../ bec. curdir is inside templates/freshdata/monitor-save.php
        if($fn = Functions::file_open($filename, "w"))
        {
            fwrite($fn, $params['Title'] . "\t" . $params['Description'] . "\t" . $params['URL'] . "\t\t"); //saves five fields
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
            // else exit("<br>investigate pls.[$template]<br>");
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
    
    function display_message($options)
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
    

}