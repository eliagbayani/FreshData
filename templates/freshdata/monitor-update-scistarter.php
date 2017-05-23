<script type = "text/javascript" language = "javascript">
$(document).ready(function() {
  $("#driver").click(function(event){
    
    $('.help-block').remove(); // remove the error text
    
    var uuid = $("#uuid").val();
    
    var name = $("#name").val();
    var description = $("#description").val();
    var url = $("#url").val();
    var contact_name = $("#contact_name").val();
    var contact_affiliation = $("#contact_affiliation").val();
    var contact_email = $("#contact_email").val();
    var contact_phone = $("#contact_phone").val();
    var contact_address = $("#contact_address").val();
    var presenting_org = $("#presenting_org").val();
    var origin = $("#origin").val();
    var video_url = $("#video_url").val();
    var blog_url = $("#blog_url").val();
    var twitter_name = $("#twitter_name").val();
    var facebook_page = $("#facebook_page").val();
    var status = $("#status").val();
    var preregistration = $('input[name="preregistration"]:checked').val();
    var goal = $("#goal").val();
    var task = $("#task").val();
    var image = $("#image").val();
    var image_credit = $("#image_credit").val();
    var how_to_join = $("#how_to_join").val();
    var special_skills = $("#special_skills").val();
    var gear = $("#gear").val();
    var outdoors = $('input[name="outdoors"]:checked').val();
    var indoors = $('input[name="indoors"]:checked').val();
    var time_commitment = $("#time_commitment").val();
    var project_type = $("#project_type").val();
    var audience = $("#audience").val();
    var regions = $("#regions").val();
    var UN_regions = $("#UN_regions").val();
    
    if(url)
    {   if(!validateURL(url))
        {
            $('#stage').append('<div id="memo" class="help-block">Invalid URL</div>');
            return;
        }
    }
    if(video_url)
    {   if(!validateURL(video_url))
        {
            $('#stage').append('<div id="memo" class="help-block">Invalid video_url</div>');
            return;
        }
    }
    if(blog_url)
    {   if(!validateURL(blog_url))
        {
            $('#stage').append('<div id="memo" class="help-block">Invalid blog_url</div>');
            return;
        }
    }

    $("#stage").load('templates/freshdata/monitor-save-scistarter.php', {"uuid":uuid, "name":name, "description":description, "url":url, "contact_name":contact_name, "contact_affiliation":contact_affiliation, "contact_email":contact_email, "contact_phone":contact_phone, "contact_address":contact_address, 
    "presenting_org":presenting_org, "origin":origin, "video_url":video_url, "blog_url":blog_url, "twitter_name":twitter_name, "facebook_page":facebook_page, "status":status, "preregistration":preregistration, 
    "goal":goal, "task":task, "image":image, "image_credit":image_credit, "how_to_join":how_to_join, "special_skills":special_skills, "gear":gear, "outdoors":outdoors, "indoors":indoors, "time_commitment":time_commitment, 
    "project_type":project_type, "audience":audience, "regions":regions, "UN_regions":UN_regions} );
    $("#login_form").hide();
    $('#stage').append('<div class="help-block"><br>Please wait, saving...<br><br></div>'); // add the actual error message under our input

    });
});

function validateURL(textval)
{
    //to add ftp: (https?|ftp)
    var urlregex = /^(https?):\/\/([a-zA-Z0-9.-]+(:[a-zA-Z0-9.&%$-]+)*@)*((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9][0-9]?)(\.(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])){3}|([a-zA-Z0-9-]+\.)*[a-zA-Z0-9-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(:[0-9]+)*(\/($|[a-zA-Z0-9.,?'\\+&%$#=~_-]+))*$/;
    return urlregex.test(textval);
}
</script>

<?php
// print_r(other_controller::scistarter_fields());
?>

<span id = "login_form">
  <p>Update project info:</p>
  <table>
  <tr><td>name:</td>                    <td><input type="text" id="name" size="100" value="<?php echo $rec_from_text2['name'] ?>" /></td></tr>
  <tr valign="top"><td>description:</td><td valign="top"><textarea id="description" rows="8" cols="100" name="Description"><?php echo $rec_from_text2['description'] ?></textarea></td></tr>
  <tr><td>url:</td>                <td><input type="text" id="url"                 size="100" value="<?php echo $rec_from_text2['url'] ?>" /></td></tr>
  <tr><td>contact_name:</td>       <td><input type="text" id="contact_name"        size="100" value="<?php echo $rec_from_text2['contact_name'] ?>" /></td></tr>
  <tr><td>contact_affiliation:</td><td><input type="text" id="contact_affiliation" size="100" value="<?php echo $rec_from_text2['contact_affiliation'] ?>" /></td></tr>
  <tr><td>contact_email:</td>       <td><input type="text" id="contact_email"        size="100" value="<?php echo $rec_from_text2['contact_email'] ?>" /></td></tr>
  <tr><td>contact_phone:</td>       <td><input type="text" id="contact_phone"        size="100" value="<?php echo $rec_from_text2['contact_phone'] ?>" /></td></tr>
  <tr valign="top"><td>contact_address:</td><td valign="top"><textarea id="contact_address" rows="5" cols="100" name="contact_address"><?php echo $rec_from_text2['contact_address'] ?></textarea></td></tr>
  <tr><td>presenting_org:</td>      <td><input type="text" id="presenting_org"      size="100" value="<?php echo $rec_from_text2['presenting_org'] ?>" /></td></tr>
  <tr><td>origin:</td>              <td><input type="text" id="origin"              size="100" value="<?php echo $rec_from_text2['origin'] ?>" /></td></tr>
  <tr><td>video_url:</td>           <td><input type="text" id="video_url"           size="100" value="<?php echo $rec_from_text2['video_url'] ?>" /></td></tr>
  <tr><td>blog_url:</td>            <td><input type="text" id="blog_url"            size="100" value="<?php echo $rec_from_text2['blog_url'] ?>" /></td></tr>
  <tr><td>twitter_name:</td>        <td><input type="text" id="twitter_name"        size="100" value="<?php echo $rec_from_text2['twitter_name'] ?>" /></td></tr>
  <tr><td>facebook_page:</td>       <td><input type="text" id="facebook_page"       size="100" value="<?php echo $rec_from_text2['facebook_page'] ?>" /></td></tr>
  <tr><td>status:</td>              <td><input type="text" id="status"              size="100" value="<?php echo $rec_from_text2['status'] ?>" /></td></tr>

  <tr><td>preregistration:</td><td>
  <?php $preregistration = $rec_from_text2['preregistration'] ?>
  <input type="radio" id="preregistration" value="true" name="preregistration" <?php if($preregistration == 'true') echo "checked" ?>/>True
  &nbsp;&nbsp;&nbsp;
  <input type="radio" id="preregistration" value="false" name="preregistration" <?php if($preregistration == 'false') echo "checked" ?>/>False
  </td></tr>

  <tr><td>goal:</td>                <td><input type="text" id="goal"                size="100" value="<?php echo $rec_from_text2['goal'] ?>" /></td></tr>
  <tr><td>task:</td>                <td><input type="text" id="task"                size="100" value="<?php echo $rec_from_text2['task'] ?>" /></td></tr>
  <tr><td>image:</td>               <td><input type="text" id="image"               size="100" value="<?php echo $rec_from_text2['image'] ?>" /></td></tr>
  <tr><td>image_credit:</td>        <td><input type="text" id="image_credit"        size="100" value="<?php echo $rec_from_text2['image_credit'] ?>" /></td></tr>
  <tr valign="top"><td>how_to_join:</td><td valign="top"><textarea id="how_to_join" rows="3" cols="100" name="how_to_join"><?php echo $rec_from_text2['how_to_join'] ?></textarea></td></tr>
  <tr><td>special_skills:</td>      <td><input type="text" id="special_skills"      size="100" value="<?php echo $rec_from_text2['special_skills'] ?>" /></td></tr>
  <tr valign="top"><td>gear:</td>   <td valign="top"><textarea id="gear" rows="3" cols="100" name="gear"><?php echo $rec_from_text2['gear'] ?></textarea></td></tr>

  <tr><td>outdoors:</td><td>
  <?php $outdoors = $rec_from_text2['outdoors'] ?>
  <input type="radio" id="outdoors" value="true" name="outdoors" <?php if($outdoors == 'true') echo "checked" ?>/>True
  &nbsp;&nbsp;&nbsp;
  <input type="radio" id="outdoors" value="false" name="outdoors" <?php if($outdoors == 'false') echo "checked" ?>/>False
  </td></tr>

  <tr><td>indoors:</td><td>
  <?php $indoors = $rec_from_text2['indoors'] ?>
  <input type="radio" id="indoors" value="true" name="indoors" <?php if($indoors == 'true') echo "checked" ?>/>True
  &nbsp;&nbsp;&nbsp;
  <input type="radio" id="indoors" value="false" name="indoors" <?php if($indoors == 'false') echo "checked" ?>/>False
  </td></tr>

  <tr><td>time_commitment:</td>     <td><input type="text" id="time_commitment"     size="100" value="<?php echo $rec_from_text2['time_commitment'] ?>" /></td></tr>
  <tr><td>project_type:</td>        <td><input type="text" id="project_type"        size="100" value="<?php echo $rec_from_text2['project_type'] ?>" /></td></tr>
  <tr><td>audience:</td>            <td><input type="text" id="audience"            size="100" value="<?php echo $rec_from_text2['audience'] ?>" /></td></tr>
  <tr valign="top"><td>regions:</td><td valign="top"><textarea id="regions" rows="8" cols="100" name="regions"><?php echo $rec_from_text2['regions'] ?></textarea></td></tr>
  <tr><td>UN_regions:</td>          <td><input type="text" id="UN_regions"          size="100" value="<?php echo $rec_from_text2['UN_regions'] ?>" /></td></tr>
  <input type="hidden" id="uuid" value="<?php echo $uuid ?>">
  </table>
  <button id="driver" type="submit">Save</button>
  <button onClick="javascript:history.go(-1)" type="">Cancel</button>
</span>
<div id = "stage" style = "background-color:white;"></div>
