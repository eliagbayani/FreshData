
<!---
<link rel="stylesheet"            href="../github-php-client/app/css/bootstrap.min.css">
<script type = "text/javascript" src = "../../../../../../../github-php-client/app/js/jquery.min.js"></script>
--->

<script type = "text/javascript" language = "javascript">
$(document).ready(function() {
  $("#driver").click(function(event){
    
    $('.help-block').remove(); // remove the error text
    
    /*
    var username = $("#username").val();
    var password = $("#password").val();
    if(!username) $('#stage').append('<div class="help-block">Please enter Username</div>');
    if(!password) $('#stage').append('<div class="help-block">Please enter Password</div>');
    if(password && username)
    {
    }
    */

    var uuid = $("#uuid").val();
    var Title = $("#Title").val();
    var Description = $("#Description").val();
    var URL = $("#URL").val();
    var Training_materials = $("#Training_materials").val();
    var Contact = $("#Contact").val();
    
    var uuid_archive = $("#uuid_archive").val();
    var Taxa = $("#Taxa").val();
    var Status = $("#Status").val();
    var Records = $("#Records").val();
    var Trait_selector = $("#Trait_selector").val();
    var String = $("#String").val();
    
    if(URL)
    {
        if(!validateURL(URL))
        {
            $('#stage').append('<div id="memo" class="help-block">Invalid URL</div>');
            return;
        }
    }
    if(!uuid_archive)
    {
        $('#stage').append('<div id="memo" class="help-block">uuid cannot be blank!</div>');
        return;
    }

    $("#stage").load('templates/freshdata/monitor-save.php', {"uuid":uuid, "Title":Title, "Description":Description, "URL":URL, "Training_materials":Training_materials, "Contact":Contact, 
                                                              "uuid_archive":uuid_archive, "Taxa":Taxa, "Status":Status, "Records":Records, "Trait_selector":Trait_selector, "String":String} );
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

<span id = "login_form">
  <p>Update metadata for monitor:</p>
  <table>
  <tr><td>Title:</td>                   <td><input type = "text" id = "Title"         size = "100" value="<?php echo $rec_from_text['Title']       ?>" /></td></tr>
  <tr valign="top"><td>Description:</td><td valign="top"><textarea id="Description" rows="10" cols="100" name="Description"><?php echo $rec_from_text['Description']; ?></textarea></td></tr>
  <tr><td>URL:</td>                     <td><input type = "text"  id = "URL"          size = "100" value="<?php echo $rec_from_text['URL']         ?>" /></td></tr>
  <tr><td>Training materials:</td>      <td><input type = "text" id = "Training_materials" size = "100" value="<?php echo $rec_from_text['Training_materials']  ?>" /></td></tr>
  <tr><td>Contact:</td>                 <td><input type = "text" id = "Contact" size = "100" value="<?php echo $rec_from_text['Contact']                        ?>" /></td></tr>

  <tr><td><hr>Archive Monitor Info<hr></td></tr>
  <tr><td>uuid:</td>                   <td><input type = "text" id = "uuid_archive"         size = "100" value="<?php echo $rec_from_text['uuid_archive']       ?>" /></td></tr>
  <tr><td>Taxa:</td>                   <td><input type = "text" id = "Taxa"         size = "100" value="<?php echo $rec_from_text['Taxa']       ?>" /></td></tr>
  <tr><td>Status:</td>                   <td><input type = "text" id = "Status"         size = "100" value="<?php echo $rec_from_text['Status']       ?>" /></td></tr>
  <tr><td>Records:</td>                   <td><input type = "text" id = "Records"         size = "100" value="<?php echo $rec_from_text['Records']       ?>" /></td></tr>
  <tr><td>Trait_selector:</td>                   <td><input type = "text" id = "Trait_selector"         size = "100" value="<?php echo $rec_from_text['Trait_selector']       ?>" /></td></tr>
  <tr valign="top"><td>String:</td><td valign="top"><textarea id="String" rows="10" cols="100" name="String"><?php echo $rec_from_text['String']; ?></textarea></td></tr>

  <input type="hidden" id="uuid" value="<?php echo $uuid ?>">
  </table>
  
  <button id="driver" type="submit">Save</button>
  <button onClick="javascript:history.go(-1)" type="">Cancel</button>
  
</span>
<div id = "stage" style = "background-color:white;"></div>
