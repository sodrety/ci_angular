<?php
include "../class/mysql.php";
function oleh_by($id) {
$db = new database();
$db->connect("user_login");
$query = "SELECT nama FROM karyawan WHERE id=".$id."";
$results = $db->get_results( $query );
$n=0;
foreach( $results as $data )
{ }
return $data['nama'];

}
function akunnya($akun) {
$db = new database();
$db->connect("dropbox");
$query = "SELECT perusahaan FROM akun_pj WHERE akun='".$akun."'";
$results = $db->get_results( $query );
$n=0;
foreach( $results as $data )
{ }
return $data['perusahaan'];

}


$k=substr($_GET['l'],6,5);
if (strlen($k)<3) {exit;}
$db = new database();
$db->connect("dropbox");
$query = "SELECT no_aju,waktu,m_status.status as status,m_status.ket as ket,oleh,hasil from barcode join antrian ON barcode.id=antrian.id_barcode JOIN m_status ON antrian.status=m_status.status WHERE kode='".$k."' order by waktu";
$results = $db->get_results( $query );
$n=0;
foreach( $results as $data )
{
$akun=substr($data['no_aju'],5,7);
echo substr($data['waktu'],8,8)."|".$data['status']."-".$data['ket']."|".oleh_by($data['oleh'])."|".$data['hasil']."\n";
}
echo $k." ".$data['no_aju']."\n".akunnya($akun);
