<?php
if(!isset($date_from))
{
    $date_from = date("Y-m-d");
    $date_to = date("Y-m-d");
}
?>

<script type = "text/javascript" language = "javascript">
$(document).ready(function() {
  $("#driver4").click(function(event){
    $('.help-block4').remove(); // remove the error text

    var uuid = $("#uuid").val();
    var YN = $('#YN').val();
    var destination = $('#destination').val();
    var date_from = $('#date_from').val();
    var date_to = $('#date_to').val();
    var search_url = $('#search_url').val();

    $("#stage4").load('templates/freshdata/special-invasive-form-confirm.php', {"uuid":uuid, "YN":YN, "destination":destination, "date_from":date_from, "date_to":date_to, "search_url":search_url} );
    $("#login_form4").hide();
    $('#stage4').append('<div class="help-block4"><br>Processing, please wait...<img src="images/ajax-loader.gif"></div>'); // add the actual error message under our input
    });
});
</script>

<!---<span id = "login_form4">--->
  <input type="hidden" id="uuid_archive"    value="<?php echo $rec_from_text['uuid_archive'] ?>" />
  <input type="hidden" id="uuid"            value="<?php echo $uuid ?>">
  <input type="hidden" id="destination"     value="<?php echo $destination ?>">
  <input type="hidden" id="search_url"      value="<?php echo $search_url ?>">
  
  <hr>
  <?php
  if(file_exists($destination_dl_tsv) && filesize($destination_dl_tsv)) 
  {
      ?>
      <!---<br>--->
      <table>
        <tr><td>Date last generated</td><td><input type="text" id="date_from" value="<?php echo $date_from ?>"></td></tr>
        <tr><td>Date today</td><td>         <input type="text" id="date_to"   value="<?php echo $date_to ?>"></td></tr>
      </table>
      <button id="driver4" type="submit"><?php echo $inv_button_label ?></button>
      &nbsp;<a href="<?php echo $admin_link ?>">Cancel</a>
      <?php
  }
  else
  {
      if(file_exists($destination) && filesize($destination)) $str = "re-generate";
      else                                                    $str = "generate";
      // echo "<hr>$destination<hr>";
      freshdata_controller::display_message(array('type' => "error", 'msg' => "Cannot $str invasive species filter. <b>Download Occurrence TSV</b> first."));
  }
  // echo "<i id='memo'>Cannot re-generate invasive species filter. Download Occurrence TSV first.</i>";
  ?>
  
  
<!---</span>--->
<!---<div id="stage4" style = "background-color:white;"></div>--->
