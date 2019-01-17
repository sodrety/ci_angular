<?php
require_once( '../class/class.php' );
if ($_POST) {
app_query("REPLACE INTO uji_analis VALUES ('".$_GET['id']."_".$_POST['analis']."', '".$_GET['id']."', '".$_POST['analis']."')");
}
