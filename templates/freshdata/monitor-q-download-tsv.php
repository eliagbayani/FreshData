<script type = "text/javascript" language = "javascript">
$(document).ready(function() {
  $("#driver3").click(function(event){
    
    $('.help-block2').remove(); // remove the error text

    var uuid = $("#uuid").val();
    var url = $("#url").val();
    var destination = $("#destination").val();
    var search_url = $("#search_url").val();
    
    $("#stage3").load('templates/freshdata/monitor-q-download-tsv-confirm.php', {"uuid":uuid, "url":url, "destination":destination, "search_url":search_url} );
    $("#login_form3").hide();
    $('#stage3').append('<div class="help-block2"><br>Downloading, please wait...<img src="images/ajax-loader.gif"></div>'); // add the actual error message under our input
    //<br><br>OR you can click <b>Continue</b> and check the download later.<br><br>
    });
});
</script>

<?php
// echo "<br><a href='".$search_url."' target='".$uuid."'>Search in Fresh Data.</a><br><br>"; working but no longer needed
?>

<!---<span id = "login_form2">--->
  <input type="hidden" id="uuid"            value="<?php echo $uuid ?>">
  <input type="hidden" id="destination"     value="<?php echo $destination_jenkins ?>">
  <?php 
    if(self::is_eli()) {
        // echo "<hr>Admin stuff:<br>destination: [$destination_jenkins]<hr>url: [$url]<hr>search_url: [$search_url]<hr>"; //good debug
    }
    if($val = @$rec_from_text['tsv_url']) {
        $url = $val;
    }
    if(self::is_eli()) {
        // echo "<hr>Admin stuff:<br>url: [$url]<hr>search_url: [$search_url]<hr>"; //good debug
    }
    
  ?>
  <input type="hidden" id="url"             value="<?php echo $url ?>">
  <input type="hidden" id="search_url"      value="<?php echo $search_url ?>">
  <br>

  <?php if(self::has_enough_query_params($rec_from_text)) {
      if(@$rec_from_text['tsv_url']) {
          self::display_message(array('type' => "highlight", 'msg' => "Since you've entered the TSV URL, or the system may have entered it: ".$rec_from_text['tsv_url']));
          self::display_message(array('type' => "highlight", 'msg' => "System will use this URL to download the occurrence TSV. The filters for Taxa/traits/area (e.g. polygon) will not be used."));
          echo "<br>";
      }
      ?>
      <button id="driver3" type="submit">Download occurrence TSV from Fresh Data</button>
      &nbsp;<a href="<?php echo $admin_link ?>">Cancel</a>
      
      <?php
      if(!@$rec_from_text['tsv_url']) {
          ?>
          <br><br><i id="memo">Note: Download will fail if search has not yet been cached in Fresh Data. You can <a target="<?php echo $uuid ?>" href="<?php echo $search_url ?>">Search Fresh Data</a> first to see if occurrence is ready.</i>
          <?php
      }
  }
  else freshdata_controller::display_message(array('type' => "error", 'msg' => "No area (polygon) specified. Cannot request download."));
  ?>

<!---</span>--->
<!---<div id="stage2" style = "background-color:white;"></div>--->
