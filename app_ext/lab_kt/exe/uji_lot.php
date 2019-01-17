<?php
require_once( '../class/class.php' );
if ($_POST) {
		$no=(app_baca("uji_lot","id_uji='".$_POST['id']."' order by no desc","no"))+1;
		$kode=substr("00".$no,-2);
app_query("INSERT INTO uji_lot VALUES (NULL, '".$no."', '".$kode."', '".$_POST['id']."', '".$_POST['nama']."', '".$_POST['ket']."')");
}

