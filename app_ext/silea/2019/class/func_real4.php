<?php
function rq_nominatif() {
if ($_POST) {
$ket=rq_baca("pok","no='".$_POST['mak']."'","uraian");	
	db_insert("tugasdb","nominatif","'','2018','".$_POST['mak']."','".$ket."','".$_POST['tgl']."','".now()."','".user_id()."',NULL,NULL,NULL");}

$db = new database();
$db->connect("tugasdb");
$query = "SELECT * FROM nominatif WHERE tgl>'2018-03-31' order by tgl desc";
$results = $db->get_results( $query );

foreach( $results as $data )
{$j++;
}	
foreach( $results as $data )
{
$no++;
$mak=rq_baca("pok","no='".$data['mak']."'","mak");	
$dt.="<tr><td>".$no."</td><td>".$data['tgl']."</td><td>".$mak."</td><td>".$data['ket']."</td><td>".$data['jml_spt']."</td><td>".$data['jml_petugas']."</td><td align='right' style='font-weight:700;'>".rp($data['jml_nom'])."</td><td><a href='?t=NominatifSpt&nom_id=".$data['id']."'>SPT</a></td><td><a href='print/nom_spt.php?nom_id=".$data['id']."&mak=".$data['mak']."' target='_blank'>Print</a></td><td>".$data['oleh']."</td><td><a href='print/nom_spt_det.php?nom_id=".$data['id']."&mak=".$data['mak']."' target='_blank'>Ptgs</a></td><td>".$data['id']."</td></tr>";
}
echo "
<form method=post>New Akun <select name=mak id=select2>".rq_nominatif_opt("2018")."</select><br>
Tgl: <input type=date name=tgl><input type=submit value=Tambah></form>
<table width='100%' id=example><thead><tr><th>NO</th><th>TGL</th><th>AKUN</th><th>KETERANGAN</th><th>JML ST</th><th>JML PETUGAS</th><th>NOMINAL</th><th></th><th></th><th>BY</th><th></th><th>ID</th></tr>

</thead><tbody>".$dt;
echo "</tbody><table>";	
}

function rq_nominatif_opt($th) {
//$bid=$_POST['bidang'];
$db = new database();
$db->connect(rq_db());
$query = "SELECT * from pok where sat='OP' or sat='OK' order by mak";
$results = $db->get_results( $query );

foreach( $results as $data )
{
$no++;
$dt.="<option value='".$data['no']."'>".$data['mak']." : ".rp($data['hargasat'])." : ".rp($data['jumlah'])." : ".$data['uraian']."</option>";
}
return $dt;	
}

function rq_nominatif_spt() {
$nom_id=$_GET['nom_id'];
//$mak=db_baca("tugasdb","nominatif","id='".$nom_id."'","mak");
$db = new database();
$db->connect("tugasdb");
$query2 = "SELECT * FROM nominatif where id='".$nom_id."'";
$results2 = $db->get_results( $query2 );

foreach( $results2 as $data2 )
{
echo $data2['ket']."<br>".tgl_p($data2['tgl'])." by ".$data2['oleh']."<br>";
$mak=$data2['mak'];
$tgl=$data2['tgl'];
}

$query = "SELECT * FROM spt where mak='".$mak."' and nom_id<1 and waktu_selesai<='".$tgl."' and tahun='2018' order by waktu_selesai";
$results = $db->get_results( $query );
$akun=rq_baca("pok","no='".$mak."'","mak");
foreach( $results as $data )
{
$no++;

$dt.="<tr valign='top'><td>".$no."</td><td>".$akun."</td><td>".$data['no']."</td><td>".$data['waktu_mulai']."</td><td>".$data['waktu_selesai']."</td><td>".rq_nominatif_spt_p($data['id'])."</td><td>".$data['tujuan']."</td><td>".$data['kota']."</td><td><a href='exe/nom_id.php?nom_id=".$nom_id."&id_spt=".$data['id']."' target='iframe'>Add</a></td></form></tr>";
}
echo "<a href='?t=Nominatif'>Nominatif List</a>
<table class='table' width='100%' id=example><thead><tr><th>NO</th><th>AKUN</th><th>NO SPT</th><th>TGL MULAI</th><th>TGL SELESAI</th><th>PETUGAS</th><th>TUGAS</th><th>KOTA</th><th></th></tr>

</thead><tbody>".$dt;
echo "</tbody><tfoot>
<tr><td colspan=9><a href='exe/nom_id.php?nom_id=".$nom_id."&id_spt=semua&tgl=".$tgl."&mak=".$mak."' target='iframe'>Tambahkan Semua</a></td></tr>
</tfoot><table>
<table width='100%'><tr><td><iframe name=iframe src='exe/nom_id.php?nom_id=".$nom_id."' style='width:100%;height:400px;border:1px solid #aaa;'></iframe></td></tr><table>
";	
}


function rq_nominatif_spt_p($id) {
$db = new database();
$db->connect("tugasdb");
$query = "SELECT * FROM spt_petugas where id_spt='".$id."'";
$results = $db->get_results( $query );
foreach( $results as $data )
{
$no++;
$dt.=$no.") ".$data['nama']."<br>";
}
return $dt;
}
