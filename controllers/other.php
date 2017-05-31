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
    }

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
        if(!$arr['regions']) $arr['regions'] = $monitor['selector']['wktString'];
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
        $obj = json_decode($info);
        if($obj->project_id && $obj->result == "success") return $obj;
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
        // echo "<hr>$data_string<hr>";
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

        if(0 == curl_errno($ch))
        {
            curl_close($ch);
            return $result;
        }
        echo "<hr>Curl error ($url): " . curl_error($ch)."<hr>";
        return false;
    }

}
?>
