<?php
header ( "Content-type: application/vnd.ms-excel" );
header ( "Content-Disposition: attachment; filename=surat_tugas.xls" );
include "../class/class.php";

function st_petugas($id) {
$db = new database();
$db->connect("b_office");	
$query="SELECT * FROM spt_petugas  WHERE id_spt='".$id."' order by no";	
$results = $db->get_results( $query );	
foreach( $results as $data )
{
	$no++;
$dt.=$no.") ".$data['nama']."; ";
}
return $dt;
}


$db = new database();
$db->connect("b_office");
$no=1;
$query="SELECT * FROM spt WHERE tgl>='".$_GET['m']."' and tgl<='".$_GET['s']."'";
$results = $db->get_results( $query );
echo "<table><tr><th>NO</th><th>TGL SPT</th><th>TGL TUGAS</th><th>NO SURAT</th><th>TUGAS</th><th>KOTA</th><th>PENERIMA&nbsp;TUGAS</th><th>MAK</th></tr>";
foreach( $results as $data )
{
	$n++;
if ($data['tahun']>="2018") {$mak=db_baca("b_realisasi_".$data['tahun'],"pok","no='".$data['mak']."'","mak");}	
echo "<tr valign='top'><td align=center>$n</td><td>".$data['tgl']."</td><td>".$data['waktu_mulai']." - ".$data['waktu_selesai']."</td><td>".$data['no_spt']."</td><td>".$data['tujuan']."</td><td>".$data['kota']."</td><td>".st_petugas($data['id'])."</td><td>".$mak."</td></tr>";
$no++;
}
echo "</table>";
