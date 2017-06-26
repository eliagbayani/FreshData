<script type = "text/javascript" language = "javascript">
$(document).ready(function() {
  $("#driver_add").click(function(event){
    
    $('.help-block').remove(); // remove the error text
    

    var uuid_a = $("#uuid_a").val();
    var Title_a = $("#Title_a").val();
    var Description_a = $("#Description_a").val();
    var URL_a = $("#URL_a").val();
    var Training_materials_a = $("#Training_materials_a").val();
    var Contact_a = $("#Contact_a").val();
    
    var uuid_archive_a = $("#uuid_archive_a").val();
    var Taxa_a = $("#Taxa_a").val();
    var Status_a = $("#Status_a").val();
    var Records_a = $("#Records_a").val();
    var Trait_selector_a = $("#Trait_selector_a").val();
    var String_a = $("#String_a").val();
    
    if(!Taxa_a && !String_a)
    {
        $('#stage_add').append('<div id="memo" class="help-block">Taxa and String cannot be both blank. One or both must have an entry.</div>');
        return;
    }
    
    if(URL_a)
    {
        if(!validateURL(URL_a))
        {
            $('#stage_add').append('<div id="memo" class="help-block">Invalid URL</div>');
            return;
        }
    }
    
    $("#stage_add").load('templates/freshdata/monitor-save-add.php', {"uuid":uuid_a, "Title":Title_a, "Description":Description_a, "URL":URL_a, "Training_materials":Training_materials_a, "Contact":Contact_a, 
                                                              "uuid_archive":uuid_archive_a, "Taxa":Taxa_a, "Status":Status_a, "Records":Records_a, "Trait_selector":Trait_selector_a, "String":String_a} );
    $("#login_form_add").hide();
    $('#stage_add').append('<div class="help-block"><br>Saving, please wait...<br><br></div>'); // add the actual error message under our input

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
    $guid = self::create_guid();
?>
<span id = "login_form_add">
  <table>
  <tr><td colspan="2"><hr><b>Monitor Info:</b><hr></td></tr>
  <tr><td>uuid:</td>                <td><?php echo $guid ?>
                                      <input type = "hidden" id = "uuid_archive_a"  value="<?php echo $guid ?>" /></td></tr>
  <tr><td>Taxa:</td>                <td><input type = "text" id = "Taxa_a"            size = "100"  /></td></tr>
  <tr><td>Status:</td>              <td><input type = "text" id = "Status_a"          size = "100"  /></td></tr>
  <tr><td>Records:</td>             <td><input type = "text" id = "Records_a"         size = "100"  /></td></tr>
  <tr><td>Trait_selector:</td>      <td><input type = "text" id = "Trait_selector_a"  size = "100"  /></td></tr>
  <tr valign="top"><td>String:</td> <td valign="top"><textarea id="String_a" rows="10" cols="100" name="String_a"></textarea></td></tr>

  <tr><td colspan="2"><hr><b>Additional Fields:</b><hr></td></tr>
  <tr><td>Title:</td>                   <td><input type = "text" id = "Title_a"               size = "100"  /></td></tr>
  <tr valign="top"><td>Description:</td><td valign="top"><textarea id="Description_a" rows="10" cols="100" name="Description_a"></textarea></td></tr>
  <tr><td>URL:</td>                     <td><input type = "text"  id = "URL_a"                size = "100"  /></td></tr>
  <tr><td>Training materials:</td>      <td><input type = "text" id = "Training_materials_a"  size = "100"  /></td></tr>
  <tr><td>Contact:</td>                 <td><input type = "text" id = "Contact_a"             size = "100"  /></td></tr>

  <input type="hidden" id="uuid_a" value="<?php echo $guid ?>">

  <tr><td colspan="2"><hr></td></tr>
  <tr><td colspan="2">
      <button id="driver_add" type="submit">Save</button>
      <!---<button onClick="javascript:history.go(-1)" type="">Cancel</button>--->
      <a href="javascript:history.go(-1)">Cancel</a>
  </td></tr>
  </table>
  
</span>
<div id = "stage_add" style = "background-color:white;"></div>
