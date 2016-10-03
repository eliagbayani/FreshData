
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
    
    
    $("#stage").load('templates/freshdata/monitor-save.php', {"uuid":uuid, "Title":Title, "Description":Description, "URL":URL} );
    $("#login_form").hide();
    $('#stage').append('<div class="help-block"><br>Please wait, loading...<br><br></div>'); // add the actual error message under our input
    
    });
});
</script>

<span id = "login_form">
  <p>Update metadata for monitor:</p>
  <table>
  <tr><td>Title:</td>                   <td><input type = "text" id = "Title"         size = "100" value="<?php echo $rec_from_text['Title']       ?>" /></td></tr>
  <tr valign="top"><td>Description:</td><td valign="top"><textarea id="Description" rows="10" cols="100" name="Description"><?php echo $rec_from_text['Description']; ?></textarea></td></tr>
  <tr><td>URL:</td>                     <td><input type = "text"  id = "URL"          size = "100" value="<?php echo $rec_from_text['URL']         ?>" /></td></tr>
  <input type="hidden" id="uuid" value="<?php echo $uuid ?>">
  </table>
  
  <button id="driver" type="submit" class="btn btn-success">Save</button>
</span>
<div id = "stage" style = "background-color:white;"></div>
