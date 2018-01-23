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
    
    var uuid_archive = "";
    var Taxa = "";
    var Status = "";
    var Records = "";
    var Trait_selector = "";
    var tsv_url = "";
    var String = "";
    
    $("#stage2").load('templates/freshdata/monitor-undelete-confirm.php', {"uuid":uuid, "Title":Title, "Description":Description, "URL":URL, "Training_materials":Training_materials, "Contact":Contact, 
                                                              "uuid_archive":uuid_archive, "Taxa":Taxa, "Status":Status, "Records":Records, "Trait_selector":Trait_selector, 
                                                              "String":String, "tsv_url":tsv_url} );
    $("#login_form2").hide();
    $('#stage2').append('<div class="help-block2"><br>Un-deleting, please wait...<br><br></div>'); // add the actual error message under our input

    });
});
</script>

<!---<span id = "login_form2">--->
  <input type="hidden" id="uuid_archive"            value="<?php echo $rec_from_text['uuid_archive'] ?>" />
  <input type="hidden" id="uuid"                    value="<?php echo $uuid ?>">
  <hr>
  <button id="driver2" type="submit">Un-delete this monitor</button>
  &nbsp;<a href="javascript:history.back(1)">Cancel</a>
<!---</span>--->
<!---<div id="stage2" style = "background-color:white;"></div>--->
