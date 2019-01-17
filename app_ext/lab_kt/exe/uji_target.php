<?php
require_once( '../class/class.php' );
if ($_POST) {
		$no=(app_baca("uji_target","id_uji='".$_POST['id']."' order by no desc","no"))+1;
		$kode=app_baca("uji","id='".$_POST['id']."'","kode")."2".substr("00".$no,-2);
		
app_query("REPLACE INTO uji_target VALUES ('".$_POST['id']."_".$_POST['uji_target']."', '".$no."', '".$kode."', '".$_POST['id']."', '".$_POST['uji_target']."',NULL,NULL,NULL,NULL,NULL)");
}

