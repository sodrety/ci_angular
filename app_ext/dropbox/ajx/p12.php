<?php
include "../class/class.php";
$db = new database();
$db->connect("movedb");
$query = "SELECT * FROM ppk_kt_eks JOIN ppk_kt ON ppk_kt_eks.user=ppk_kt.user WHERE reg='1'";
$results = $db->get_results( $query );
foreach( $results as $data) {
$no++;
//echo $no." ".$data['user']." ".$data['user_iqfast']." ".$data['nama_perusahaan']."<br>";
$ak=strtoupper($data['user_iqfast']);
$ada=app_baca("via_pj","akun='".$ak."'","akun");
if ($ada=="") {
echo $ada." ".$data['user']." ".$data['user_iqfast']." ".$data['nama_perusahaan']."<br>";
//app_replace("via_pj","'".$ak."_2_E_P', '".$ak."', '2_E_P', '2017-06-01 00:00:00', '137'");
}
//$idc=app_baca("barcode","no_aju='".$data['no_aju']."'","id");
//app_update("barcode","id='".$idc."'","kode='".kode($idc)."'");
//app_update("barcode","id='".$idc."'","last_antri='".$data['tgl']."'");
//if ($idc=="") {
//app_query("INSERT INTO barcode (`no_aju`,`no_reg`,`input_time`,`update_time`,`bidang`,`lintas`,`via`,`last_status`) VALUES ('".$data['no_aju']."', '".$data['no_reg']."', '".$data['tgl']."', '".$data['tgl']."', '2', 'E', 'L', '9')");
//}

}
