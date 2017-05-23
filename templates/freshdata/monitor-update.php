
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
    
    if(URL)
    {
        if(!validateURL(URL))
        {
            $('#stage').append('<div id="memo" class="help-block">Invalid URL</div>');
            return;
        }
    }

    $("#stage").load('templates/freshdata/monitor-save.php', {"uuid":uuid, "Title":Title, "Description":Description, "URL":URL, "Training_materials":Training_materials, "Contact":Contact} );
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
  <input type="hidden" id="uuid" value="<?php echo $uuid ?>">
  </table>
  
  <button id="driver" type="submit">Save</button>
  <button onClick="javascript:history.go(-1)" type="">Cancel</button>
  
</span>
<div id = "stage" style = "background-color:white;"></div>
