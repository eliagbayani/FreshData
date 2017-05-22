<?php
// namespace php_active_record;
class other_controller
{
    function __construct($params)
    {
        $this->form_fields = array( //default from https://docs.google.com/spreadsheets/d/1gHdrWRaZbEKp3bCI7kXhN95le-jGvQOXXxeVpgmypJ4/edit?ts=5919e683#gid=0
        "contact_name" => "Jen Hammock",
        "contact_affiliation" => "Encyclopedia of Life",
        "contact_email" => "hammockj@si.edu",
        "contact_address" => "National Museum of Natural History<br>Smithsonian Institution<br>P.O. Box 37012, MRC 106<br>Washington, DC  20013-7012",
        "origin" => "Fresh Data",
        "status" => "active",
        "preregistration" => false,
        "goal" => "Collect wildlife observations to support ongoing research and monitoring projects",
        "task" => "photograph and report wildlife online",
        "image" => "http://opendata.eol.org/uploads/group/2017-05-15-172001.731090FDlogo.jpg",
        "image_credit" => "derived from a work by Gerd Altmann, CC0",
        "how_to_join" => "You may report wildlife observations through a variety of platforms. If you do not have a favorite platform already, we suggest joining http://www.inaturalist.org/ to make observations for this project.",
        "special_skills" => "Photography- it needn't be art, but it should be well lit and in focus",
        "gear" => 'Camera + internet. A mobile device will do nicely, but if you prefer a "real camera", you\'ll need to be able to upload the photo later, and make a note of your location and the time when you took it.',
        "outdoors" => true,
        "indoors" => false,
        "time_commitment" => "five minutes per data contribution",
        "project_type" => "Project",
        "audience" => "High School (14 - 17 years), College, Graduate students, Adults, Families");
        
    }

    function update_proj_when_article_moves($params)
    {   
    }
    
}
?>
