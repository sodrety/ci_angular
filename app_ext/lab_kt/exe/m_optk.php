<?php
require_once( '../class/class.php' );
if ($_POST) {
		$id=app_baca("m_optk","nama_latin='".$_POST['nama']."'","id");
if ($id=="") {	
app_query("INSERT INTO m_optk (`nama_latin`,`jenis`,`created_at`) VALUES ('".$_POST['nama']."', '".$_POST['jenis']."', '".now()."')");
} else {
app_update("m_optk", "id='".$id."'", "nama_latin='".$_POST['nama']."', jenis='".$_POST['jenis']."', updated_at='".now()."'");
}
}

