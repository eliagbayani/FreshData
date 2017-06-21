<div id="accordion">
    <h3>Show original API data</h3>
    <div>
        <table>
            <tr><td>uuid:</td>           <td id="value"><?php echo $monitor['selector']['uuid'] ?></td></tr>
            <tr><td>Taxa:</td>           <td id="value"><?php echo $monitor['selector']['taxonSelector'] ?></td></tr>
            <tr><td>Status:</td>         <td id="value"><?php echo @$monitor['status'] ?></td></tr>
            <tr><td>Records:</td>        <td id="value"><?php echo number_format($monitor['recordCount']) ?></td></tr>
            <tr><td>Trait selector:</td> <td id="value"><?php echo $monitor['selector']['traitSelector'] ?></td></tr>
            <tr><td>String:</td>         <td id="value"><?php echo $monitor['selector']['wktString'] ?></td></tr>
        </table>
    </div>
</div>
