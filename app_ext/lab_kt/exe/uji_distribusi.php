<?php
require_once( '../class/class.php' );
if ($_POST) {		
app_update("uji_target","idt='".$_POST['idt']."'","id_metode='".$_POST['id_metode']."',preparasi='".$_POST['preparasi']."',penguji='".$_POST['penguji']."',ket='".$_POST['ket']."'");
}

