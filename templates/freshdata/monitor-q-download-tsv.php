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
    $('#stage3').append('<div class="help-block2"><br>Downloading, please wait... OR you can click [Continue] and check the download later.<br><br></div>'); // add the actual error message under our input

    });
});
</script>

<!---<span id = "login_form2">--->
    <?php
    // $url = $this->api['effechecka_occurrences']."?taxonSelector=".$rec_from_text['Taxa']."&traitSelector=".$rec_from_text['Trait_selector']."&wktString=".$rec_from_text['String'];
    ?>

  <input type="hidden" id="uuid"            value="<?php echo $uuid ?>">
  <input type="hidden" id="destination"     value="<?php echo $destination ?>">
  <input type="hidden" id="url"             value="<?php echo $url ?>">
  <input type="hidden" id="search_url"      value="<?php echo $search_url ?>">
  
  
  <hr>
  <button id="driver3" type="submit">Download TSV from Fresh Data</button>
  &nbsp;<a href="javascript:history.go(-1)">Cancel</a>
<!---</span>--->
<!---<div id="stage2" style = "background-color:white;"></div>--->
