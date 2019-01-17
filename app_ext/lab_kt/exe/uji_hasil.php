<?php
session_start();
require_once( '../class/class.php' );
if ($_POST) {		
if ($_FILES["file"]["name"]!="") {
$target_dir = "../img/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$filenya=$_POST['idt'].".".$imageFileType;
$namefile=$target_dir . $filenya;
move_uploaded_file($_FILES["file"]["tmp_name"], $namefile);
app_query("REPLACE INTO uji_img VALUES ('".$_POST['id']."', '".$filenya."', '".user_id()."', '".now()."')");
}
app_query("REPLACE INTO uji_hasil VALUES ('".$_POST['id']."', '".$_POST['id_uji']."', '".$_POST['idt']."', '".$_POST['lot_kode']."', '".$_POST['hasil']."', '".$_POST['selesai_tgl']."', '".user_id()."', '".now()."', '".$_POST['abs_1']."', '".$_POST['abs_2']."', '".$_POST['warna_1']."', '".$_POST['warna_2']."')");
}


