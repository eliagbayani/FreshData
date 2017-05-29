<?php
// require_once("../../../LiteratureEditor/Custom/lib/Functions.php");
// require_once("../../controllers/other.php");
// require_once("../../controllers/freshdata.php");

$params =& $_GET;
if(!$params) $params =& $_POST;

// $ctrler = new freshdata_controller($params);
// sleep(1);

/*
Array
(
    [name] => Fresh Data - my title elicha
    [description] => Welcome to my title ddd! We are eager for online reports of particular wildlife, accompanied by photographs. the quick brownfox jumpsover the lazydog... end... eeeAs with all Fresh Data projects, the simplest way to participate is by submitting your observation and photo through iNaturalist. The iNat community can help you with species identification, and our research team will be notified that you’ve provided fresh data for this research project.
    [url] => http://eol.org
    [contact_name] => Jen Hammock
    [contact_affiliation] => Encyclopedia of Life
    [contact_email] => hammockj@si.edu
    [contact_phone] => 09173773133
    [contact_address] => National Museum of Natural History Smithsonian InstitutionP.O. Box 37012, MRC 106Washington, DC  20013-7012
    [presenting_org] => 
    [origin] => Fresh Data

    [video_url] => 
    [blog_url] => 
    [twitter_name] => 
    [facebook_page] => 
    [status] => active
    [preregistration] => true
    [goal] => Collect wildlife observations to support ongoing research and monitoring projects
    [task] => photograph and report wildlife online
    [image] => http://opendata.eol.org/uploads/group/2017-05-15-172001.731090FDlogo.jpg
    [image_credit] => derived from a work by Gerd Altmann, CC0

    [how_to_join] => You may report wildlife observations through a variety of platforms. If you do not have a favorite platform already, we suggest joining http://www.inaturalist.org/ to make observations for this project.
    [special_skills] => Photography- it needn
    [gear] => Camera + internet. A mobile device will do nicely, but if you prefer a "real camera", you
    [outdoors] => true
    [indoors] => true
    [time_commitment] => five minutes per data contribution
    [project_type] => Project
    [audience] => High School (14 - 17 years), College, Graduate students, Adults, Families
    [regions] => ENVELOPE(-150,-50,40,10)
    [UN_regions] => 

)
*/
?>

<div id="accordion_open2">
    <h3><?php echo "SciStarter Project info" ?></h3>
    <div>
        <?php 
        
        // echo "<pre>"; print_r($params); echo "</pre>"; 
        // echo "<hr>";
        // echo "<hr>";

        $info = other_controller::submit_add_project($params);
        // print_r($info);
        ?>

        <?php
        // require_once("templates/freshdata/monitor-update-scistarter.php");
        ?>
    </div>
</div>



