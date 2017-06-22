<script type = "text/javascript" language = "javascript">
$(document).ready(function() {
  $("#driver2").click(function(event){
    
    $('.help-block2').remove(); // remove the error text

    var uuid = $("#uuid").val();
    var Title = "";
    var Description = "";
    var URL = "";
    var Training_materials = "";
    var Contact = "";
    
    var uuid_archive = $("#uuid_archive").val();
    var Taxa = "";
    var Status = "";
    var Records = "";
    var Trait_selector = "";
    var String = "";
    
    $("#stage2").load('templates/freshdata/monitor-delete-confirm.php', {"uuid":uuid, "Title":Title, "Description":Description, "URL":URL, "Training_materials":Training_materials, "Contact":Contact, 
                                                              "uuid_archive":uuid_archive, "Taxa":Taxa, "Status":Status, "Records":Records, "Trait_selector":Trait_selector, "String":String} );
    $("#login_form2").hide();
    $('#stage2').append('<div class="help-block2"><br>Deleting, please wait...<br><br></div>'); // add the actual error message under our input

    });
});
</script>

<!---<span id = "login_form2">--->
  <input type="hidden" id="uuid_archive"            value="<?php echo $rec_from_text['uuid_archive'] ?>" />
  <!--- not needed anymore...
  <input type="hidden" id="Taxa"                    value="" />
  <input type="hidden" id="Status"                  value="" />
  <input type="hidden" id="Records"                 value="" />
  <input type="hidden" id="Trait_selector"          value="" />
  <input type="hidden" id="String"                  value="" />
  
  <input type="hidden" id="Title"                   value="" />
  <input type="hidden" id="Description"             value="" />
  <input type="hidden" id="URL"                     value="" />
  <input type="hidden" id="Training_materials"      value="" />
  <input type="hidden" id="Contact"                 value="" />
  --->
  <input type="hidden" id="uuid"                    value="<?php echo $uuid ?>">
  <hr>
  <button id="driver2" type="submit">Delete this monitor</button>
  &nbsp;<a href="javascript:history.go(-1)">Cancel</a>
<!---</span>--->
<!---<div id="stage2" style = "background-color:white;"></div>--->
