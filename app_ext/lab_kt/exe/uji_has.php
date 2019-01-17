<?php
require_once( '../class/class.php' );
if ($_POST) {		
app_update("uji","id='".$_POST['id']."'","hasil_tgl='".$_POST['hasil_tgl']."',hasil_oleh='".$_POST['hasil_oleh']."',iso='".$_POST['iso']."',mt='".$_POST['mt']."'");
}
