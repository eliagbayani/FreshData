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
    $public_view = $data['public_view'];
    
    if($group == "monitors") $vars = array('search_type' => "wiki2php",         'js_string' => "Monitors List");
    else                     $vars = array('search_type' => "wiki2php_project", 'js_string' => "xxx");
?>
<table id="<?php echo $table_id ?>" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <?php if($group == "monitors") echo "<th>Status</th>"; ?>
            <th>#Records</th>
            <th>Taxa</th>
            <th>Title</th>
            <th>Description</th>
            <th>URL</th>
            <th style="display:none">uuid</th>
            <th style="display:none">taxonSelector</th>
            <th style="display:none">traitSelector</th>
            <th style="display:none">wktString</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <?php if($group == "monitors") echo "<th>Status</th>"; ?>
            <th>#Records</th>
            <th>Taxa</th>
            <th>Title</th>
            <th>Description</th>
            <th>URL</th>
            <th style="display:none">uuid</th>

            <th style="display:none">taxonSelector</th>
            <th style="display:none">traitSelector</th>
            <th style="display:none">wktString</th>


            
        </tr>
    </tfoot>
    <tbody>
        <?php foreach($rows as $r)
        {
            ?>
                <tr>
                    <?php if($group == "monitors") echo '<td>'.$r['status'].'</td>'; ?>
                    <td align="right"><?php echo number_format($r['recordCount']) ?></td>
                    <td><?php echo $r['taxonSelector'] ?></td>
                    
                    <?php $rek = self::get_text_file_value($r['uuid']); ?>
                    <td><?php echo $rek['Title'] ?></td>
                    <td><?php echo $rek['Description'] ?></td>
                    <td><?php echo $rek['URL'] ?></td>

                    <td style="display:none"><?php echo $r['uuid'] ?></td>

                    <td style="display:none"><?php echo $r['taxonSelector'] ?></td>
                    <td style="display:none"><?php echo $r['traitSelector'] ?></td>
                    <td style="display:none"><?php echo $r['wktString'] ?></td>
                </tr>
            <?php
        }
        ?>
    </tbody>
</table>

<?php
if(!$public_view)
{
    ?>
    <form id="myform<?php echo $table_id ?>" action="index.php" method="post" enctype="multipart/form-data" <?php if($group == "xxx") echo "target=\"_blank\"" ?>>
    <input type="hidden" name="uuid"  value="1" id="uuid<?php echo $table_id ?>">
    </form>
    <?php
}
else
{
    ?>
    <form id="myform<?php echo $table_id ?>" action="<?php echo FRESHDATA_DOMAIN ?>" method="get" enctype="multipart/form-data" <?php if($group == "xxx") echo "target=\"_blank\"" ?>>
    <input type="hidden" name="taxonSelector" id="taxonSelector">
    <input type="hidden" name="traitSelector" id="traitSelector">
    <input type="hidden" name="wktString"     id="wktString">
    </form>
    <?php
}
?>

<script>
<!--- $(document).ready(function() { --->
    // Setup - add a text input to each footer cell
    $('#<?php echo $table_id ?> tfoot th').each( function () {
        var title = $(this).text();
        
        //customized by Eli
        if(title == "Taxa") $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        else                $(this).html( '<input type="text" placeholder="Search" />' );
        
    } );
 
    // DataTable
    var table<?php echo $table_id ?> = $('#<?php echo $table_id ?>').DataTable({
        "iDisplayLength": 25,
        "order": [[ 1, "desc" ]]
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
            myFunction<?php echo $table_id ?>(data<?php echo $table_id ?>[6], 
                                              data<?php echo $table_id ?>[7], 
                                              data<?php echo $table_id ?>[8], 
                                              data<?php echo $table_id ?>[9]
                                              );
        } );
    
<!--- } ); --->



function myFunction<?php echo $table_id ?>(uuid, taxonSelector, traitSelector, wktString) 
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
    
    <?php
    if(!$public_view)
    {
        ?>
        document.getElementById("uuid<?php echo $table_id ?>").value = uuid;
        <?php
    }
    else
    {
        ?>
        document.getElementById("taxonSelector").value = taxonSelector;
        
        traitSelector = traitSelector.replace('&gt;', '>');
        traitSelector = traitSelector.replace('&lt;', '<');
        
        document.getElementById("traitSelector").value = traitSelector;
        document.getElementById("wktString").value = wktString;
        <?php
    }
    ?>
    
    
    document.getElementById("myform<?php echo $table_id ?>").submit();
}
</script>
