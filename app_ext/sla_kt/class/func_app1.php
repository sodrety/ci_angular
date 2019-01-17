<?php

function user_id() {
return $_SESSION['user_id'];
}

function karyawan_opt() {
$db = new database();
$db->connect("user_login");
$query = "SELECT id,nama FROM karyawan order by nama";
$results = $db->get_results( $query );
foreach( $results as $data )
{
$ret.="<option value='".$data['id']."|||".$data['nama']."'>".$data['nama']."</option>";
}
return $ret;
}

function popt(){
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM popt order by nama";
$results = $db->get_results( $query );
$n=0;

$th="2018";
$bln=$th."-".date("m");
foreach( $results as $data )
{
	$n++;
//$jmlt=db_jml("tugasdb","spt JOIN spt_petugas on spt.id=spt_petugas.id_spt","id_user='".$data['id']."' AND kat='TKT' AND spd='SPD.KT' AND waktu_selesai LIKE '".$bln."%'","id_user");
//app_replace("realisasi", "'".$bln."-01_".$data['id']."_TK', '".$bln."-01', '".$data['id']."', 'TK', '".$jmlt."'");
//$jml=db_jml("tugasdb","spt JOIN spt_petugas on spt.id=spt_petugas.id_spt","id_user='".$data['id']."' AND kat!='TKT' AND spd!='DALAM KOTA' and tujuan NOT LIKE '%lembur%' and tujuan NOT LIKE '%piket%' and dipa LIKE '%priok%' AND waktu_selesai LIKE '".$bln."%'","id_user");
//app_replace("realisasi", "'".$bln."-01_".$data['id']."_LN', '".$bln."-01', '".$data['id']."', 'LN', '".$jml."'");
//$jml_s=realisasi_jml($data['id'],$th);
$nip=db_baca("user_login", "karyawan","id='".$data['id']."'","nip");
$dtny= "<tr valign='top'><td align=center>$n</td><td>".$data['nama']." / ".$nip."</td><td>".$data['jenjang']."</td><td>".$data['id']."</td><td>".$data['kaos']."</td><td>".$data['rompi']."</td></tr>";
if (substr($nip,14,1)=="1") {$pria.=$dtny; } elseif (substr($nip,14,1)=="2") {$wanita.=$dtny;} 
}
echo "
<table class='table' width=100% id=example>
<thead>
<tr><th>NO</th><th>NAMA</th><th>JENJANG</th><th>ID</th><th>KAOS</th><th>ROMPI</th></tr>
</thead><tbody>".$pria."</tbody></table>";
echo "<br>
<table class='table' width=100% id=example2>
<thead>
<tr><th>NO</th><th>NAMA</th><th>JENJANG</th><th>ID</th><th>KAOS</th><th>ROMPI</th></tr>
</thead><tbody>".$wanita."</tbody></table>";

}



function lokasi(){
$db = new database();
$db->connect(app_db());

$query = "SELECT * FROM lokasi order by lokasi";
$results = $db->get_results( $query );
$n=0;
echo "
<table class='table' width=100% id=example>
<thead>
<tr><th>NO</th><th>LOKASI</th><th>ID</th></tr>
</thead><tbody>";

foreach( $results as $data )
{
	$n++;
echo "<tr valign='top'><td align=center>$n</td><td>".$data['lokasi']."</td><td>".$data['id_lokasi']."</td></tr>";
}
echo "</tbody></table>";
}

function lokasi_opt(){
$db = new database();
$db->connect(app_db());

$query = "SELECT * FROM lokasi order by lokasi";
$results = $db->get_results( $query );
foreach( $results as $data )
{
$ret.="<option>".$data['lokasi']."</option>";
}
return $ret;
}

function popt_opt(){
$db = new database();
$db->connect(app_db());

$query = "SELECT * FROM popt order by nama";
$results = $db->get_results( $query );
foreach( $results as $data )
{
$ret.="<option value=".$data['id'].">".$data['nama']."</option>";
}
return $ret;
}

function penempatan(){
$db = new database();
$db->connect(app_db());
if ($_POST['tahun']=="") {$th=date("Y");} else {$th=$_POST['tahun'];}
if ($_POST['bulan']=="") {$bl=date("m");} else {$bl=$_POST['bulan'];}
$n=0;
echo "
<form method=post>
Pencarian: Tahun <select name=tahun style='padding:3px;'><option>".$th."</option><option></option><option>2018</option><option>2019</option>
    </select> Bulan <select name=bulan style='padding:3px;'><option>".$bl."</option><option></option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option>
    </select>

Lokasi
    <select id='select1' name=lokasi ><option>".$_POST['lokasi']."</option><option></option>".lokasi_opt()."
    </select>
<input type=submit name=cari value=Cari style='padding:3px;'></form>

";

if ($_POST['lokasi']!="") {
$id_lokasi=app_baca("lokasi","lokasi='".$_POST['lokasi']."'","id_lokasi");
$wh=" AND id_lokasi='".$id_lokasi."'";
}

$query = "SELECT * FROM penempatan JOIN popt ON penempatan.id_popt=popt.id WHERE tahun LIKE '".$th."%' AND bulan LIKE '".$bl."%' ".$wh." order by penempatan.id_penempatan";
$results = $db->get_results( $query );

echo "
<table class='table' width=100% id=example>
<thead>
<tr><th>NO</th><th>TAHUN</th><th>BULAN</th><th>NAMA</th><th>LOKASI</th><th>TUGAS</th><th>KAOS</th><th>ROMPI</th></tr>
</thead><tbody>";

foreach( $results as $data )
{
	$n++;
echo "<tr valign='top'><td align=center>$n</td><td>".$data['tahun']."</td><td>".$data['bulan']."</td><td>".$data['nama']."</td><td>".app_baca("lokasi","id_lokasi='".$data['id_lokasi']."'","lokasi")."</td><td>".$data['tugas']."</td><td>".$data['kaos']."</td><td>".$data['rompi']."</td></tr>";
}
echo "</tbody></table>";
}


function realisasi_bln($th,$id) {
while ($b<12) {
$b++;
$idn=$th."-".substr("0".$b,-2)."-01_".$id;

$bb.="<td align=center>".app_baca("realisasi","id_realisasi='".$idn."_TK'","jumlah")."</td>
<td align=center bgcolor='#dddddd'>".app_baca("realisasi","id_realisasi='".$idn."_LN'","jumlah")."</td>";

}
return $bb;

}


function realisasi(){
$db = new database();
$db->connect(app_db());
if ($_POST['tahun']=="") {$th=date("Y");} else {$th=$_POST['tahun'];}
$n=0;
echo "
<form method=post>
Pencarian: Tahun <select name=tahun style='padding:3px;'><option>".$th."</option><option></option><option>2018</option><option>2019</option>
    </select>
<input type=submit name=cari value=Cari style='padding:3px;'></form>

";
$query = "SELECT * FROM popt where id='".user_id()."' order by nama";
$results = $db->get_results( $query );
$n=0;
echo "
<table class='table' width=100% id=example>
<thead>
<tr><th rowspan=2>NO</th><th rowspan=2>NAMA</th><th rowspan=2>ID</th><th colspan=2>01</th><th colspan=2>02</th><th colspan=2>03</th><th colspan=2>04</th><th colspan=2>05</th><th colspan=2>06</th><th colspan=2>07</th><th colspan=2>08</th><th colspan=2>09</th><th colspan=2>10</th><th colspan=2>11</th><th colspan=2>12</th><th rowspan=2>ALL</th></tr>
<tr><th>TK</th><th>LN</th><th>TK</th><th>LN</th><th>TK</th><th>LN</th><th>TK</th><th>LN</th><th>TK</th><th>LN</th><th>TK</th><th>LN</th><th>TK</th><th>LN</th><th>TK</th><th>LN</th><th>TK</th><th>LN</th><th>TK</th><th>LN</th><th>TK</th><th>LN</th><th>TK</th><th>LN</th></tr>
</thead><tbody>";

foreach( $results as $data )
{
	$n++;
echo "<tr valign='top'><td align=center>$n</td><td>".$data['nama']."</td><td>".$data['id']."</td>".realisasi_bln($th,$data['id'])."<td><div id=".$data['id'].">".realisasi_jml($data['id'],$th)."</div></td></tr>";
}
echo "</tbody></table>";
}


function realisasi2(){
if ($_GET['m']=="") {$m=date("Y-m-01");$s=today();} else {$m=$_GET['m'];$s=$_GET['s'];}
 $db = new database();
$db->connect("tugasdb");
echo "
<form method=get>
Tgl Tugas <input type=date value='".$m."' name='m'> sd <input type=date value='".$s."' name='s'>
<input type=hidden name=t value='Realisasi' >
<input type=submit name=cari value=Cari style='padding:3px;'></form>
";

$query = "SELECT * FROM spt_petugas JOIN spt ON spt_petugas.id_spt=spt.id where id_user='".user_id()."' and kat='TKT' and waktu_selesai>='".$m."' and waktu_selesai<='".$s."' order by waktu_selesai asc";
$results = $db->get_results( $query );
$n=0;
echo "
<table class='table' width=100% id=example>
<thead>
<tr><th>NO</th><th>TGL</th><th>STATUS BERKAS</th><th>NAMA</th><th>REKAN</th><th>KOTA</th><th>TUGAS</th></tr>
</thead><tbody>";

foreach( $results as $data )
{
	$n++;
	$tgs=$data['tujuan'];
	$tgs=str_replace("Melakukan pemeriksaan fisik/kesehatan media pembawa","",$tgs);
	$tgs=str_replace("Milik/Perusahaan","",$tgs);
	$tgs=str_replace("2018.2.0300.0.S01.","",$tgs);
if ($data['nom_id']>0) {$st="Lengkap";} else {$st="Belum Lengkap!";}
echo "<tr valign='top'><td align=center>$n</td><td>".$data['waktu_selesai']."</td><td>".$st."</td><td>".$data['nama']."</td><td>".spt_rekan($data['id_spt'],$data['id_user'])."</td><td>".$data['kota']."</td><td>".$tgs."</td></tr>";
}
echo "</tbody></table>";
}

function spt_rekan($id_spt,$id_p) {
$db = new database();
$db->connect("tugasdb");
$query = "SELECT nama FROM spt_petugas WHERE id_spt='".$id_spt."' and id_user!='".$id_p."' order by nama";
$results = $db->get_results( $query );
foreach( $results as $row) {
$j.=$row['nama']."<br>";
}
return $j;

}




function realisasi_jml($id_popt,$th) {
$db = new database();
$db->connect(app_db());
$query = "SELECT jumlah FROM realisasi WHERE id_popt='".$id_popt."' and bulan LIKE '".$th."-%'";
$results = $db->get_results( $query );
foreach( $results as $row) {
$j+=$row['jumlah'];
}
app_replace("realisasi_jml","'".$id_popt."','".$j."'");
return $j;

}



function jadwal_popt($ar,$th,$bl,$id,$k) {
$date= $_POST['tahun']."-".$_POST['bulan']."-01";
$last_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", last day of this month");
//echo $last_date = date("Y-m-d",$last_date_find);
$j=date("d",$last_date_find);
while ($a<$j) {
$a++;
$t=substr("0".$a,-2);
$head.="<th>".$t."</th>";
$tgly=$th."-".$bl."-".$t;
$id_jd=$tgly."_".$id;
$jd=app_baca("jadwal","id_jadwal='".$id_jd."'","id_popt"); 

if ($k=="k") {
if ($jd>0 and $tgly>today()) {$ch="<input type=checkbox checked style='margin:0;' onclick=\"requestContent('ajx/jdwl.php?id=".$id_jd."','jdwl')\">"; } elseif ($jd>0) {$ch="X"; } elseif ($tgly>today()) {$ch="<input type=checkbox style='margin:0;' onclick=\"requestContent('ajx/jdwl.php?id=".$id_jd."','jdwl')\">"; } else {$ch=""; }

} else {
if ($jd>0 and $tgly>today()) {$ch="<input type=checkbox checked style='margin:0;' onclick=\"requestContent('ajx/jdwl.php?id=".$id_jd."','jdwl')\">"; } elseif ($jd>0 ) {$ch="X"; } else {$ch=""; }

} 
if (nama_hari($tgly)=="Sun") {$bg="bgcolor='999999'"; } elseif (nama_hari($tgly)=="Sat") {$bg="bgcolor='aaaaaa'"; } else  {$bg="";}
$body.="<td align=center ".$bg.">$ch</td>";
}

if ($th=="" or $bl=="") { return "";} elseif ($ar=="head") {return $head;}  elseif ($ar=="body") {return $body;}
}

function jadwal(){
$db = new database();
$db->connect(app_db());
if ($_POST['tahun']=="") {$th=date("Y");} else {$th=$_POST['tahun'];}
if ($_POST['bulan']=="") {$bl=date("m");} else {$bl=$_POST['bulan'];}
$n=0;
echo "
<form method=post>
Pencarian: Tahun <select name=tahun style='padding:3px;'><option>".$th."</option><option></option><option>2018</option><option>2019</option>
    </select> Bulan <select name=bulan style='padding:3px;'><option>".$bl."</option><option></option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option>
    </select>
<!--
Lokasi
    <select id='select1' name=lokasi ><option>".$_POST['lokasi']."</option><option></option>".lokasi_opt()."
    </select> -->
<input type=submit name=cari value=Cari style='padding:3px;'></form>

";

if ($_POST['lokasi']!="") {
$id_lokasi=app_baca("lokasi","lokasi='".$_POST['lokasi']."'","id_lokasi");
$wh=" AND id_lokasi='".$id_lokasi."'";
}

$query = "SELECT * FROM penempatan JOIN popt ON penempatan.id_popt=popt.id WHERE tahun LIKE '".$th."%' AND bulan LIKE '".$bl."%' ".$wh." and popt.id='".user_id()."' order by penempatan.id_penempatan";
$results = $db->get_results( $query );



foreach( $results as $data )
{
	$n++;
	
	$rompinya="<form method=post target='iframe' action='exe/kaos.php?id=".$data['id_popt']."'><td><input type=text name='kaos' value='".$data['kaos']."' size='3' onkeyup=\"javascript:this.form.submit();\"></td><td><input type=text name=rompi value='".$data['rompi']."' size='3' onkeyup=\"javascript:this.form.submit();\"></td></form>";
	
$dty.= "<tr valign='top'><td align=center>$n</td><td>".$data['tahun']."</td><td>".$data['bulan']."</td><td>".$data['nama']."</td><td>".app_baca("lokasi","id_lokasi='".$data['id_lokasi']."'","lokasi")."</td><td>".$data['kaos']."</td><td>".$data['rompi']."</td>".jadwal_popt("body",$th,$bl,$data['id'],"")."</tr>";
$id_lokasi=$data['id_lokasi'];
$tugas=$data['tugas'];
}

if ($tugas=="Koordinator") {
jadwal_koor($id_lokasi,$bl,$th); } else {
echo "

<table class='table' width=100% id=example>
<thead>
<tr><th>NO</th><th>TAHUN</th><th>BULAN</th><th>NAMA</th><th>LOKASI</th><th>KAOS</th><th>ROMPI</th>".jadwal_popt("head",$th,$bl,"","")."</tr>
</thead><tbody>";	
echo $dty."</tbody></table>";	
}
echo "<div id=jdwl></div>";
} 



function jadwal_koor($id_lokasi,$bl,$th){
$db = new database();
$db->connect(app_db());
$n=0;
$wh=" AND id_lokasi='".$id_lokasi."'";
$query = "SELECT * FROM penempatan JOIN popt ON penempatan.id_popt=popt.id WHERE tahun LIKE '".$th."%' AND bulan LIKE '".$bl."%' ".$wh." order by penempatan.id_penempatan";
$results = $db->get_results( $query );

echo "

<table class='table' width=100% id=example2>
<thead>
<tr><th>NO</th><th>TAHUN</th><th>BULAN</th><th>NAMA</th><th>LOKASI</th><th>KAOS</th><th>ROMPI</th>".jadwal_popt("head",$th,$bl,"","")."</tr>
</thead><tbody>";

foreach( $results as $data )
{
	$n++;
echo "<tr valign='top'><td align=center>$n</td><td>".$data['tahun']."</td><td>".$data['bulan']."</td><td>".$data['nama']."</td><td>".app_baca("lokasi","id_lokasi='".$data['id_lokasi']."'","lokasi")."</td><td>".$data['kaos']."</td><td>".$data['rompi']."</td>".jadwal_popt("body",$th,$bl,$data['id'],"k")."</tr>";
}
echo "</tbody></table>";
}


function alokasi(){
	/*
     $db = new database();
$db->connect("movedb");
if ($_POST['tgl_periksa']=="") {$tgl_periksa=next_date(today());} else {$tgl_periksa=$_POST['tgl_periksa'];}
$n=0;
echo "
<form method=post>
Tgl Periksa <input type=date value='".$tgl_periksa."' name='tgl_periksa'>
<input type=submit name=cari value=Cari style='padding:3px;'></form>
";

$query = "SELECT * FROM kt_ekspor WHERE tgl_periksa LIKE '".$tgl_periksa."%' order by tgl_periksa";
$results = $db->get_results( $query );

echo "

<table class='table' width=100% id=example>
<thead>
<tr><th>NO</th><th>TANGGAL PERIKSA</th><th>TANGGAL AJU</th><th>NOMOR AJU</th><th>PERUSAHAAN</th><th>NO REG</th><th>JUMLAH PETUGAS</th><th>KOTA</th></tr>
</thead><tbody>";

foreach( $results as $data )
{

	$jml=pnbp_perjalanan($data['no_permohonan']);
	if ($jml>0) {
			$n++;
echo "<tr valign='top'><td align=center>$n</td><td>".$data['tgl_periksa']."</td><td>".$data['tgl_submit']."</td><td>".$data['no_aju']."</td><td>".$data['perusahaan']."</td><td>".$data['no_permohonan']."</td><td>".$jml."</td><td>".db_baca("ops","tarif","kode_tarif='".db_baca("ops","pnbp_lain","no_permohonan='".$data['no_permohonan']."' and kode_tarif LIKE 'C1A%'","kode_tarif")."'","uraian")."</td></tr>";
}
}
echo "</tbody></table><div id=jdwl></div>";
*/
}


function pnbp_perjalanan($no_permohonan){
$db = new database();
$db->connect("ops");
$query = "SELECT * FROM pnbp_lain WHERE kode_tarif LIKE 'C1A%' and no_permohonan='".$no_permohonan."'";
$results = $db->get_results( $query );
foreach( $results as $data )
{
	$n++;
	$jml+=$data['jumlah'];
}
return $jml;//return "<td>".$jml."</td><td>".$jml."</td>";
}



function distribusi(){
if ($_GET['tgl_periksa']=="") {$tgl_periksa=next_date(today());} else {$tgl_periksa=$_GET['tgl_periksa'];}
 $db = new database();
$db->connect(app_db());
echo "
<form method=get>
Tgl Periksa <input type=date value='".$tgl_periksa."' name='tgl_periksa'>
<input type=hidden name=t value='Distribusi' >
<input type=submit name=cari value=Cari style='padding:3px;'></form>
";
if ($tgl_periksa>="208-07-01") {$wh="and nomor='1'";} else {$wh="";}
$query = "SELECT * FROM distribusi JOIN popt ON distribusi.id_popt=popt.id JOIN alokasi ON distribusi.no_permohonan=alokasi.no_permohonan WHERE distribusi.tgl_periksa='".$tgl_periksa."' ".$wh." order by group_id,distribusi.no_permohonan,ket desc";
$results = $db->get_results( $query );

$nn=0;
echo "

<table class='table' width=100% id=example3>
<thead>
<tr><th>NO</th><th>TGL</th><th>GROUP</th><th>NAMA</th><th>DOKUMEN</th><th>KETERANGAN</th></tr>
</thead><tbody>";
foreach( $results as $data )
{ 	
	$n+=1;
//echo "<tr valign='top'><td align=center>$n</td><td>".$data['tgl_periksa']."</td><td>".$data['group_id']."</td><td>".$data['nama']."</td><td>".$data['no_permohonan']."</td><td>".$data['ket']."</td></tr>";
}
echo "</tbody></table>";

}


