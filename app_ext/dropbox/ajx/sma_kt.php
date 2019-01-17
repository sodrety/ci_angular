<?php
require_once( '../class/class.php' );
$db = new database();
$db->connect("sma");
$query = "SELECT * from kt_impor where jammasuk>='2018-01-01 00:00:00' order by jammasuk limit ".$_GET['l'].",1";
$results = $db->get_results( $query );
$n=0;
$ll="I";
foreach( $results as $data )
{
$k=$data['no_aju'];
$k=str_replace(" ","",$k);
$k=str_replace("	","",$k);
$idb=app_baca("barcode","no_aju='".$k."'","id");

if ($data['dok_1']=="1") {$sp="NonSPPMP";} else {$sp="SPPMP";}
$has=" ";$ket=" ";
if ($data['status']=="2") {$st="2";$has="Tunda";$ket=$data['alasan']." ";$wkt=$data['wkt_verifikasi'];} elseif ($data['status']>="4") {$st="7";$wkt=$data['wkt_selesai'];} elseif ($data['status']=="3") {$st="2";$has="Proses";$wkt=$data['wkt_verifikasi'];} else {}
if ($idb=="") {
app_query("INSERT INTO barcode VALUES (NULL,'".$k."', NULL,NULL,NULL,NULL,'".$data['jammasuk']."', NULL, '".$data['jammasuk']."', '".$data['jammasuk']."', '".$ll."', '".$st."','".$has."','".$ket."','".$wkt."', NULL, '".$sp."', '".$data['no_reg']."')");
} else {
app_query("REPLACE INTO barcode VALUES ('".$idb."','".$k."', NULL,NULL,NULL,NULL,'".$data['jammasuk']."', NULL, '".$data['jammasuk']."', '".$data['jammasuk']."', '".$ll."', '".$st."','".$has."','".$ket."','".$wkt."', NULL, '".$sp."', '".$data['no_reg']."')");
}
if ($k!="") {
$idb=app_baca("barcode","no_aju='".$k."'","id");
app_update("barcode","id='".$idb."'","kode='".kode($idb)."'");
app_insert("antrian", "NULL,'".$idb."','".$ll."','0',NULL,NULL,'".$data['jammasuk']."','0','0','0'");
app_insert("antrian", "NULL,'".$idb."','".$ll."','1',NULL,NULL,'".$data['jammasuk']."','0','0','0'");
if ($data['status']>="4") {
app_insert("antrian", "NULL,'".$idb."','".$ll."','2', NULL,NULL, '".$data['wkt_verifikasi']."','0','0','0'");
app_insert("antrian", "NULL,'".$idb."','".$ll."','7',NULL,NULL,'".$data['wkt_selesai']."','0','0','0'");
} elseif ($data['status']=="2") {
app_insert("antrian", "NULL,'".$idb."','".$ll."','2', '".$has."','".$ket."','".$data['wkt_verifikasi']."','0','0','0'");
}
}

echo $data['no_aju']."<br>".$data['status']."<br>".$data['jammasuk']."<br>";
echo "<meta http-equiv=\"refresh\" content=\"0; URL=?l=".($_GET['l']+1)."\">";
}


