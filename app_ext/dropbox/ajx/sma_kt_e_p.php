<?php
require_once( '../class/class.php' );
$db = new database();
$db->connect("movedb");
$query = "SELECT * from kt_ekspor where no_aju LIKE '0300-03%' and via='PAPERLESS' order by tgl_submit desc limit ".$_GET['n'].",50";
$results = $db->get_results( $query );
$n=$_GET['n'];
$ll="I";
foreach( $results as $data )
{
app_update("barcode","no_aju='".$data['no_aju']."'","sppmp='Ekspor'");
//app_update("barcode","no_aju='".$data['no_aju']."'","via='P'");
//app_update("barcode","no_aju='".$data['no_aju']."'","last_antri='".$data['tgl_submit']."',input_time='".$data['tgl_submit']."', update_time='".$data['tgl_submit']."', last_waktu='".$data['tgl_validasi']."'");
//$idb=app_baca("barcode","no_aju='".$data['no_aju']."'","id");
//app_insert("antrian", "NULL,'".$idb."','E','1',NULL,NULL,'".$data['tgl_submit']."','0','0','0'");
//app_insert("antrian", "NULL,'".$idb."','E','3','Proses',NULL,'".$data['tgl_validasi']."','0','0','0'");
//echo $idb." ".$data['no_aju']." ".$data['via']." ".$data['status']." ".$data['tgl_submit']." ".$data['tgl_validasi']."<br>NULL,'".$idb."','E','3','Proses',NULL,'".$data['tgl_validasi']."',NULL,'0','0'<br>";
$n++;
echo "<meta http-equiv=\"refresh\" content=\"1; URL=?n=".$n."\">";
}




