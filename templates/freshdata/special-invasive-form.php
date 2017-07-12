<script type = "text/javascript" language = "javascript">
$(document).ready(function() {
  $("#driver4").click(function(event){
    $('.help-block4').remove(); // remove the error text

    var uuid = $("#uuid").val();
    var YN = $('#YN').val();
    var destination = $('#destination').val();

    $("#stage4").load('templates/freshdata/special-invasive-form-confirm.php', {"uuid":uuid, "YN":YN, "destination":destination} );
    $("#login_form4").hide();
    $('#stage4').append('<div class="help-block4"><br>Processing, please wait...<br><br></div>'); // add the actual error message under our input
    });
});
</script>

<!---<span id = "login_form4">--->
  <input type="hidden" id="uuid_archive"    value="<?php echo $rec_from_text['uuid_archive'] ?>" />
  <input type="hidden" id="uuid"            value="<?php echo $uuid ?>">
  <input type="hidden" id="destination"     value="<?php echo $destination ?>">
  
  <hr>
  
  Apply filter 'Invasive Species':
  <select name="YN" id="YN" style="width:60px;">
      <option>
      <option value="Yes">Yes</option>
      <option value="No">No</option>
  </select>
  
  <button id="driver4" type="submit">Apply invasive list filter</button>
  &nbsp;<a href="<?php echo $admin_link ?>">Cancel</a>
<!---</span>--->
<!---<div id="stage4" style = "background-color:white;"></div>--->
