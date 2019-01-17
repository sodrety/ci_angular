<?php
include "../class/class.php";
//echo date("H:i:s")." ".; 
$k=$_POST['kode'];
if (strlen($k)<3) {exit;}
$db = new database();
$co = new content();
$db->connect(app_db());
$query = "SELECT no_aju,waktu,status,oleh,hasil from barcode join antrian ON barcode.id=antrian.id_barcode WHERE kode='".$k."' order by waktu";
$results = $db->get_results( $query );
$n=0;
foreach( $results as $data )
{
$akun=substr($data['no_aju'],5,7);
echo substr($data['waktu'],8,8)."|".$data['status']."|<a title='".$co->oleh($data['oleh'])."'>".$data['oleh']."</a>|".$data['hasil']."<br>";
}
echo $data['no_aju']."<br>".app_baca("akun_pj","akun='".$akun."'","perusahaan")."<br>";
echo "".app_baca("akun_pj","akun='".$akun."'","email")."<br>";
