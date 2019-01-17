<?php
require_once( 'class.db.php' );

function dupak_tambah($tb,$dt) {
$db = new DB();
$db->connect("dupak");
$add_query = $db->replace($tb,$dt);
}

function ep_baca($tb,$wh,$fd) {
$db = new DB();
$db->connect("eplaqdb");
$query = "SELECT $fd FROM $tb WHERE $wh LIMIT 0,1";
$results = $db->get_results( $query );
foreach( $results as $row) {
return $row[$fd];
}

}


$db = new DB();
$db->connect("eplaqdb");
//$add_query = $db->inserta( "example_phpmvc", "NULL,'1','a'" );
$l=$_GET['p']*10;
$query = "SELECT no_permohonan,tgl_sertifikat,nama_tmp_periksa FROM permohonan WHERE tgl_sertifikat LIKE '2017-%' and no_permohonan LIKE '%I%' order by tgl_sertifikat limit $l,10";
$results = $db->get_results( $query );
foreach( $results as $row )
{
$tgl_st=ep_baca("surat_tugas","no_permohonan='".$row['no_permohonan']."' AND ( no_surat_tugas like '%/02' OR no_surat_tugas like '%/2' )","tgl_surat_tugas");
$tgl_dp5=ep_baca("ndp5","no_permohonan='".$row['no_permohonan']."'","tgl_dp5");
$hs=ep_baca("detil_komoditas","no_permohonan='".$row['no_permohonan']."'","kode_hs");
$hs=str_replace(".","",$hs);
$hs=substr ($hs, 0, 8);
$rsk=ep_baca("hs","kode_hs='".$hs."'","risk_level");
if ($tgl_st=="") {$tgl_stn=$tgl_dp5;} else  {$tgl_stn=$tgl_st;}
dupak_tambah("fisik","'".$row['no_permohonan']."','$tgl_stn','$tgl_dp5','".$row['tgl_sertifikat']."','$hs','$rsk','".$row['nama_tmp_periksa']."'");
    echo $row['no_permohonan'] .'<br />';
$no++;
}

if ($no<=0) {exit;}
echo "<meta http-equiv=\"refresh\" content=\"1; URL=exp.php?p=".($_GET['p']+1)."\">";

//dupak_tambah($tb,$dt);
