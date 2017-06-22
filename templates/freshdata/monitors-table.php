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
    $view_type = $data['view_type'];
    $params = $data['params'];
    
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
            
            <?php if(in_array($view_type, array("public", "admin", "delRecs"))) echo "<th>Training materials</th>" ?>
            <?php if(in_array($view_type, array("scistarter"))) echo "<th>SciStarter Project ID</th>" ?>

            <?php if(in_array($view_type, array("public", "admin", "delRecs"))) echo "<th>Contact</th>" ?>
            <?php if(in_array($view_type, array("scistarter"))) echo "<th>SciStarter Project Name</th>" ?>

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

            <?php if(in_array($view_type, array("public", "admin", "delRecs"))) echo "<th>Training materials</th>" ?>
            <?php if(in_array($view_type, array("scistarter"))) echo "<th>SciStarter Project ID</th>" ?>

            <?php if(in_array($view_type, array("public", "admin", "delRecs"))) echo "<th>Contact</th>" ?>
            <?php if(in_array($view_type, array("scistarter"))) echo "<th>SciStarter Project Name</th>" ?>
            
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
                    <td align="right">
                        <?php 
                            if($r['recordCount']) echo number_format($r['recordCount']);
                            else echo "0";
                            // echo number_format(trim($r['recordCount']));
                        ?>
                    </td>
                    <td><?php echo $r['taxonSelector'] ?></td>
                    
                    <?php $rek = self::get_text_file_value($r['uuid']); ?>
                    <td><?php echo $rek['Title'] ?></td>
                    <td><?php echo $rek['Description'] ?></td>
                    <td><?php echo $rek['URL'] ?></td>

                    <?php if(in_array($view_type, array("public", "admin", "delRecs"))) echo "<td>".$rek['Training_materials']."</td>" ?>
                    <?php if(in_array($view_type, array("scistarter"))) echo "<td>".self::get_field_value($r['uuid'], "ProjectID", "scistarter")."</td>" ?>

                    <?php if(in_array($view_type, array("public", "admin", "delRecs"))) echo "<td>".$rek['Contact']."</td>" ?>
                    <?php if(in_array($view_type, array("scistarter"))) echo "<td>".self::get_field_value($r['uuid'], "name", "scistarter")."</td>" ?>

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
if($view_type == 'admin' || $view_type == 'delRecs')
{
    ?>
    <form id="myform<?php echo $table_id ?>" action="index.php" method="post" enctype="multipart/form-data" <?php if($group == "xxx") echo "target=\"_blank\"" ?>>
    <input type="hidden" name="uuid"  value="1" id="uuid<?php echo $table_id ?>">
    <input type="hidden" name="monitorAPI"  value="<?php echo $params['monitorAPI'] ?>" id="monitorAPI<?php echo $table_id ?>">
    <input type="hidden" name="view_type"  value="<?php echo $params['view_type'] ?>" id="view_type<?php echo $table_id ?>">
    </form>
    <?php
}
elseif($view_type == 'scistarter')
{
    ?>
    <form id="myform<?php echo $table_id ?>" action="index.php" method="post" enctype="multipart/form-data" <?php if($group == "xxx") echo "target=\"_blank\"" ?>>
    <input type="hidden" name="uuid"  value="1" id="uuid<?php echo $table_id ?>">
    <input type="hidden" name="scistarter"  value="1" id="scistarter<?php echo $table_id ?>">
    <input type="hidden" name="monitorAPI"  value="<?php echo $params['monitorAPI'] ?>" id="monitorAPI<?php echo $table_id ?>">
    </form>
    <?php
}
elseif($view_type == 'public')
{
    ?>
    <form id="myform<?php echo $table_id ?>" action="<?php echo FRESHDATA_DOMAIN ?>" method="get" enctype="multipart/form-data" <?php if($group == "xxx") echo "target=\"_blank\"" ?>>
    <input type="hidden" name="taxonSelector" id="taxonSelector">
    <input type="hidden" name="traitSelector" id="traitSelector">
    <input type="hidden" name="wktString"     id="wktString">
    <input type="hidden" name="monitorAPI"  value="<?php echo $params['monitorAPI'] ?>" id="monitorAPI<?php echo $table_id ?>">
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
        "iDisplayLength": 15, //orig 25
        "order": [[ 1, "desc" ],[ 2, "asc"] ]
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
            myFunction<?php echo $table_id ?>(data<?php echo $table_id ?>[8], //originally 6,7,8,9; now 8,9,10,11
                                              data<?php echo $table_id ?>[9], 
                                              data<?php echo $table_id ?>[10], 
                                              data<?php echo $table_id ?>[11]
                                              );
        } );
    
<!--- } ); --->



function myFunction<?php echo $table_id ?>(uuid, taxonSelector, traitSelector, wktString, scistarter) 
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
    if($view_type == 'admin' || $view_type == 'delRecs')
    {
        ?>
        document.getElementById("uuid<?php echo $table_id ?>").value = uuid;
        <?php
    }
    elseif($view_type == 'scistarter')
    {
        ?>
        document.getElementById("uuid<?php echo $table_id ?>").value = uuid;
        document.getElementById("scistarter<?php echo $table_id ?>").value = scistarter;
        <?php
    }
    elseif($view_type == 'public')
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
