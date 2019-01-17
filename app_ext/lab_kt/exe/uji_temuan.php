<?php
session_start();
require_once( '../class/class.php' );
if ($_POST) {		
app_query("REPLACE INTO uji_temuan VALUES ('".$_POST['idh']."_".$_POST['temuan']."','".$_POST['idh']."','".$_POST['temuan']."', '".user_id()."', '".now()."','".$_POST['s1']."','".$_POST['s2']."','".$_POST['s3']."','".$_POST['s4']."')");

}

