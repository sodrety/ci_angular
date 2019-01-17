<?php
require_once( '../class/class.php' );
if ($_POST) {		
app_update("uji_target","idt='".$_POST['idt']."'","preparasi='".$_POST['preparasi']."', penguji='".$_POST['penguji']."', penyelia='".$_POST['penyelia']."'");
}
