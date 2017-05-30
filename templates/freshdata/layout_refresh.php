<?php
$ctrler->display_message(array('type' => "highlight", 'msg' => "You only need to refresh if new monitors are added/deleted."));
$ctrler->display_message(array('type' => "highlight", 'msg' => "Cache refreshes automatically every 12 hours."));
echo "<br><a href='index.php?refresh_cache='>Refresh now</a>.";
?>
