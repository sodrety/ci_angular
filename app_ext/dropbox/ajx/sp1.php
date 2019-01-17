<?php
include "../class/class.php";
$db = new database7();
$db->connect("barantan");
$ll="E";
$query = "SELECT no_aju,ppk.created_at,ppk.updated_at,nomor,tanggal FROM ppk JOIN sp1 on ppk.id=sp1.ppk_id WHERE nomor LIKE '%".$ll."%' order by updated_at limit ".$_GET['l'].",100";
$results = $db->get_results( $query );
$n=$_GET['l'];
echo "<table>";
foreach( $results as $data) {
$na=explode("-",$data['no_aju']);
$ak=substr($na[1],0,7);
$k=$data['no_aju'];
$idb=app_baca("barcode","no_aju='".$k."'","id");
if ($idb=="") {
app_query("INSERT INTO barcode (`no_aju`,`input_time`,`update_time`,`lintas`,`no_reg`,`last_antri`,`last_status`,`last_waktu`,`bidang`) VALUES ('".$k."', '".$data['created_at']."', '".$data['updated_at']."', '".$ll."', '".$data['nomor']."', '".$data['tanggal']."', '9', '".$data['tanggal']."', '2')");
$idb=app_baca("barcode","no_aju='".$k."'","id");
app_update("barcode","id='".$idb."'","kode='".kode($idb)."'");

} 
$n++;
echo $n." ".$idb." ".kode($idb)." ".$k."<br>";
echo "<meta http-equiv=\"refresh\" content=\"0; URL=?l=".$n."\">";
}

