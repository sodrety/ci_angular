<?php

function running($tgl_periksa,$ng,$ptg,$per,$npp,$np,$jm) {
	$ket=explode(" :: ",$per);
	$pet=explode(" :: ",$ptg);		
$jen=app_baca("popt","id='".$pet[1]."'","jenjang");
$idp=substr($tgl_periksa,0,4)."_".substr($tgl_periksa,5,2)."_".$pet[1];
$thbl=substr($tgl_periksa,0,4)."_".substr($tgl_periksa,5,2)."_";
$idl=app_baca("penempatan","id_penempatan='".$idp."'","id_lokasi");
//if ($_GET['random']!="") {
//app_replace("distribusi","'".$tgl_periksa."_".$pet[1]."','".$tgl_periksa."','".$pet[1]."','".$ket[0]."','".$jen."','draft','".$ket[1]." : ".$ket[2]."'");	
//}
app_replace("distribusi","'".$tgl_periksa."_".$pet[1]."','".$tgl_periksa."','".$pet[1]."','".$ket[0]."','".$jen."','draft','".$ket[1]." : ".$ket[2]."','1'");
app_update("realisasi_jml","id_popt='".$pet[1]."'", "pick='1'");	
//if ($ng%2) { $bg="";} else {$bg="#eeeeee";}
//$jmlp=app_baca("alokasi","no_permohonan='".$ket[0]."'","jml_petugas");
//$alok=app_jml("distribusi","no_permohonan='".$ket[0]."' and tgl_periksa='".$tgl_periksa."'","id_popt");
//$jml=($jmlp-$alok);
//if ($jml>0 and $jm>1) {
//$idpopt=app_baca("jadwal JOIN popt ON jadwal.id_popt=popt.id JOIN realisasi_jml ON realisasi_jml.id_popt=popt.id JOIN penempatan ON penempatan.id_popt=popt.id","jenjang!='".$jen."' and tgl='".$tgl_periksa."' and id_lokasi='".$idl."' and jnj>'".$np."' and pick='0' and id_penempatan LIKE '".$thbl."%' order by jnj","id");

//app_replace("distribusi","'".$tgl_periksa."_".$idpopt."','".$tgl_periksa."','".$idpopt."','".$ket[0]."','".app_baca("popt","id='".$idpopt."'","jenjang")."','draft','".$ket[1]." : ".$ket[2]."','0'");
//app_update("realisasi_jml","id_popt='".$idpopt."'", "pick='1'");
//}
//if ($idpopt=="") {
//$idpopt=app_baca("jadwal JOIN popt ON jadwal.id_popt=popt.id JOIN realisasi_jml ON realisasi_jml.id_popt=popt.id JOIN penempatan ON penempatan.id_popt=popt.id","jenjang!='".$jen."' and tgl='".$tgl_periksa."'and jnj>'".$np."' and pick='0' order by jnj","id");

//app_replace("distribusi","'".$tgl_periksa."_".$idpopt."','".$tgl_periksa."','".$idpopt2."','".$ket[0]."','".app_baca("popt","id='".$idpopt."'","jenjang")."','draft','".$ket[1]." : ".$ket[2]."','0'");
//app_update("realisasi_jml","id_popt='".$idpopt."'", "pick='1'");	
	
//$idl2=app_baca("penempatan","id_penempatan='".substr($tgl_periksa,0,4)."_".substr($tgl_periksa,5,2)."_".$idpopt."'","id_lokasi");
//} else {$idl2=$idl;}
return "<tr valign='top' bgcolor='".$bg."'><td align=center>".($npp+1)."</td><td>".$tgl_periksa."</td><td align=center><b>".$ng."</b></td><td>".$pet[0]." ".$pet[1]." ".$pet[2]."</td><td>".$ket[0]."</td><td>".$ket[1]." ".$ket[2]."</td><td>".app_baca("popt","id='".$idpopt."'","nama")." ".$idpopt." ".app_baca("lokasi","id_lokasi='".$idl2."'","lokasi")."</td></tr>";	
}

function to_zero($tgl_periksa) {
app_update("realisasi_jml", "id_popt>'0'","jnj=NULL,pick='0'");
app_delete("distribusi", "tgl_periksa='".$tgl_periksa."'");
}


function data_ekspor($tgl_periksa) {

$n=0;
$db = new database();
$db->connect("movedb");
$query = "SELECT * FROM kt_ekspor WHERE tgl_periksa LIKE '".$tgl_periksa."%' order by tgl_periksa";
$results = $db->get_results( $query );

echo "
<h3>DATA ANTRIAN EKSPOR</h3>
<table class='table' width=100% id=example9>
<thead>
<tr><th>NO</th><th>TANGGAL PERIKSA</th><th>TANGGAL AJU</th><th>AKUN</th><th>PERUSAHAAN</th><th>NO REG</th><th>JUMLAH PETUGAS</th><th>KOTA</th></tr>
</thead>
<tbody>";

foreach( $results as $data )
{

$jml=pnbp_perjalanan($data['no_permohonan']);
$keb+=$jml;
	if ($jml>0) {
			
			$ppk_ol=substr($data['no_aju'],5,7);
			$lokasi=db_baca("ops","tarif","kode_tarif='".db_baca("ops","pnbp_lain","no_permohonan='".$data['no_permohonan']."' and kode_tarif LIKE 'C1A%'","kode_tarif")."'","uraian");
$n++;	
echo "<tr valign='top'><td align=center>$n</td><td>".$data['tgl_periksa']."</td><td>".$data['tgl_submit']."</td><td>".$ppk_ol."</td><td>".$data['perusahaan']."</td><td>".substr($data['no_permohonan'],-8)."</td><td>".$jml."</td><td>".$lokasi."</td></tr>";
}
}
echo "</tbody></table>";		
}

function alokasi_sort($tgl_periksa) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM alokasi WHERE tgl_periksa LIKE '".$tgl_periksa."%'";
$results = $db->get_results( $query );
foreach( $results as $data )
{
app_update("alokasi","no_permohonan='".$data['no_permohonan']."'","urut='".rand(0,50)."'");	
}
}
