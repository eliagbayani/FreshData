<script type = "text/javascript" language = "javascript">
$(document).ready(function() {
  $("#driver_3").click(function(event){

    $('.help-block_3').remove(); // remove the error text
    var uuid = $("#uuid_3").val();
    var monitorAPI = $("#monitorAPI").val();
    
    // alert(uuid);
    $("#stage_3").load('templates/freshdata/search-uuid-result.php', {"uuid":uuid, "monitorAPI":monitorAPI} );
    $("#login_form_3").hide();
    $('#stage_3').append('<div class="help-block_3"><br>Searching, please wait...<br><br></div>'); // add the actual error message under our input

    });
});
</script>

<hr>
Search UUID: <input size="50" type="text" id="uuid_3"><p>
<button id="driver_3" type="submit">Search</button>
<input type="hidden" id="monitorAPI" value="<?php echo $params['monitorAPI'] ?>">
<hr>

<?php
// echo "<pre>"; print_r($params); echo "</pre>";
// echo "<br><hr>"; // IMPERATIVE ... doesn't work without any echo...
// echo "<hr>".dirname(__FILE__)."<hr>";
?>