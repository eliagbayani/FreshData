<link rel="stylesheet" href="../../../LiteratureEditor/Custom/jquery-datatables/jquery.dataTables.min.css">
<script                 src="../../../LiteratureEditor/Custom/jquery-datatables/jquery.dataTables.min.js"></script>
<!-- for smoothness -->
<script                 src="../../../LiteratureEditor/Custom/jquery-datatables/dataTables.jqueryui.min.js"></script>
<link rel="stylesheet" href="../../../LiteratureEditor/Custom/jquery-datatables/dataTables.jqueryui.min.css">

<?php
if($table_id = @$data['table_id']) {}
else $table_id = "example";
?>

<style>
body{font: 70% Arial, "Trebuchet MS", sans-serif; /* 62.5% */ /* margin: 50px; */}
tfoot input {
        width: 100%;
        padding: 1px;
        box-sizing: border-box;
    }
#<?php echo $table_id ?> {
    font-family: Arial, Helvetica, sans-serif;
    font-size: small;
    width: 100%;
    border-collapse: collapse;
}
</style>
<?php
    $rows = $data['records'];
    $group = $data['group'];
    if($group == "monitors") $vars = array('search_type' => "wiki2php",         'js_string' => "Monitors List");
    else                     $vars = array('search_type' => "wiki2php_project", 'js_string' => "xxx");
?>
<table id="<?php echo $table_id ?>" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <?php if($group == "monitors") echo "<th>Status</th>"; ?>
            <th>#Records</th>
            <th>Taxa</th>
            <th style="display:none">uuid</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <?php if($group == "monitors") echo "<th>Status</th>"; ?>
            <th>#Records</th>
            <th>Taxa</th>
            <th style="display:none">uuid</th>
        </tr>
    </tfoot>
    <tbody>
        <?php foreach($rows as $r)
        {
            ?>
                <tr>
                    <?php if($group == "monitors") echo '<td>'.$r['status'].'</td>'; ?>
                    <td><?php echo $r['recordCount'] ?></td>
                    <td><?php echo $r['taxonSelector'] ?></td>
                    <td style="display:none"><?php echo $r['uuid'] ?></td>
                </tr>
            <?php
        }
        ?>
    </tbody>
</table>
<form id="myform<?php echo $table_id ?>" action="index.php" method="post" enctype="multipart/form-data" <?php if($group == "xxx") echo "target=\"_blank\"" ?>><!---  --->
<!---
<input type="hidden" name="search_type" value="<?php echo $vars['search_type'] ?>">
<input type="hidden" name="overwrite"   value="1">
--->
<input type="hidden" name="uuid"  value="1" id="uuid<?php echo $table_id ?>">
</form>

<script>
<!--- $(document).ready(function() { --->
    // Setup - add a text input to each footer cell
    $('#<?php echo $table_id ?> tfoot th').each( function () {
        var title = $(this).text();
        
        //customized by Eli
        if(title == "Taxa") $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        else                $(this).html( '<input type="text" placeholder="" />' );
        
    } );
 
    // DataTable
    var table<?php echo $table_id ?> = $('#<?php echo $table_id ?>').DataTable({
        "iDisplayLength": 25,
        "order": [[ 0, "desc" ]]
    });
 
    // Apply the search
    table<?php echo $table_id ?>.columns().every( function () {
        var that = this;
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
    
    // to highlight row on click
    $('#<?php echo $table_id ?> tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table<?php echo $table_id ?>.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
 
    $('#button').click( function () {
        table<?php echo $table_id ?>.row('.selected').remove().draw( false );
    } );
    
    // on click event
    $('#<?php echo $table_id ?> tbody').on('click', 'tr', function () {
            var data<?php echo $table_id ?> = table<?php echo $table_id ?>.row( this ).data();
            // alert( 'You clicked on '+data<?php echo $table_id ?>[3]+'\'s row' );
            myFunction<?php echo $table_id ?>(data<?php echo $table_id ?>[3], data<?php echo $table_id ?>[1], data<?php echo $table_id ?>[2]);
        } );
    
<!--- } ); --->

function myFunction<?php echo $table_id ?>(uuid, title, subject) 
{
    /* working but dialog box to continue may not be needed anymore...
    var x;
    if (confirm("<?php echo $vars['js_string']?>:\n\n"+title+" - ("+subject+")") == true) 
    {
        document.getElementById("uuid<?php echo $table_id ?>").value = uuid;
        document.getElementById("myform<?php echo $table_id ?>").submit();
    } else 
    {
        //alert('cancel');
        //x = "You pressed Cancel!";
    }
    //document.getElementById("myform<?php echo $table_id ?>").innerHTML = x;
    */

    // spinner_on();
    document.getElementById("uuid<?php echo $table_id ?>").value = uuid;
    document.getElementById("myform<?php echo $table_id ?>").submit();
}
</script>
