<?php
require_once( '../class/class.php' );
if ($_POST) {
app_update("popt","id='".$_GET['id']."'", "kaos='".strtoupper($_POST['kaos'])."',rompi='".strtoupper($_POST['rompi'])."'");
}
