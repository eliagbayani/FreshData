<?php
// namespace php_active_record;
class other_controller
{
    function __construct($params)
    {
        $this->api['search'] = "https://scistarter.com/finder?format=json&key=".SCISTARTER_API_KEY."&q=";
        // Atlantic seabirds and whales lost in the Pacific
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
    
    function all_scistarter_fields()
    {
        return array("name", "description", "url", "contact_name", "contact_affiliation", "contact_email", "contact_phone", "contact_address", "presenting_org", "origin", "video_url", "blog_url", "twitter_name", "facebook_page", "status", "preregistration", "goal", "task", "image", "image_credit", "how_to_join", "special_skills", "gear", "outdoors", "indoors", "time_commitment", "project_type", "audience", "regions", "UN_regions");
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

}
?>
