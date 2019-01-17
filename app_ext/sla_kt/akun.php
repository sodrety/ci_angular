<?php
require_once( 'class/class.php' );
function jenjang_sort_u($tgl_periksa) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM alokasi_group WHERE tgl_periksa LIKE '".$tgl_periksa."%' order by id desc";
$results = $db->get_results( $query );
foreach( $results as $data )
{
$jm=app_jml("alokasi","group_id='".$data['id']."'","no_permohonan");
if ($jm>0) {
$query2 = "SELECT * FROM alokasi WHERE group_id='".$data['id']."' order by no_permohonan";
$results2 = $db->get_results( $query2 );
foreach( $results2 as $data2 )
{
if ($jm==1) {$npp+=$data2['jml_petugas'];} elseif ($jm>1) {$npp+=1;}
}
}
}

$query = "SELECT * FROM jadwal JOIN popt ON jadwal.id_popt=popt.id JOIN realisasi_jml ON realisasi_jml.id_popt=popt.id WHERE tgl='".$tgl_periksa."'order by jml_rand,jml limit 0,".$npp."";
$results = $db->get_results( $query );
$tr=-1;
$ah=0;
foreach( $results as $data )
{
$n++;
if ($data['jenjang']=="AHLI") {$dtah.=($ah+=2)."|||";}
if ($data['jenjang']=="TERAMPIL") {$dttr.=($tr+=2)."|||";}
}

$dttr = str_replace("|||FNL", "", $dttr."FNL");
$dttr = str_replace("||||||", "|||", $dttr);
$dtah = str_replace("|||FNL", "", $dtah."FNL");
$dtah = str_replace("||||||", "|||", $dtah);

$dttr = explode("|||", $dttr);
$dtah = explode("|||", $dtah);
shuffle ($dttr);
shuffle ($dtah);
$nah=0;
$ntr=0;
foreach( $results as $data )
{
if ($data['jenjang']=="AHLI") {
	app_update("realisasi_jml","id_popt='".$data['id_popt']."'","jnj='".$dtah[$nah]."'");
//	$xx.=$dtah[$nah]." a ";
$nah++;
	}
if ($data['jenjang']=="TERAMPIL") {
	app_update("realisasi_jml","id_popt='".$data['id_popt']."'","jnj='".$dttr[$ntr]."'");
	//$xx.=" ".$dttr[$ntr]." ";
	$ntr+=1;}	
$n++;

}
return $xx;
}
to_zero("2018-10-09");
echo jenjang_sort_u("2018-10-09")."<br>";
