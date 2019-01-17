<?php
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'func_app1_admin2.php';

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

if ($_POST['update']=="Simpan") {
$nm=explode("|||",$_POST['nama']);
app_replace("popt","'".$nm[0]."','".$nm[1]."','".$_POST['jenjang']."',NULL,NULL");
}
if ($_POST['hapus']=="X") {
app_delete("popt","id='".$_POST['id']."'");
}

$query = "SELECT * FROM popt order by nama";
$results = $db->get_results( $query );
$n=0;
echo "
<form method=post>
Tambah/Update 
    <select id='select1' name=nama >".karyawan_opt()."
    </select> Jenjang <select name=jenjang style='padding:3px;'><option>AHLI</option><option>TERAMPIL</option>
    </select>
<input type=submit name=update value=Simpan style='padding:3px;'></form>
<table class='table' width=100% id=example>
<thead>
<tr><th>NO</th><th>NAMA</th><th>KAOS</th><th>ROMPI</th><th>NIP</th><th>JENJANG</th><th>ID</th><th>HAPUS</th></tr>
</thead><tbody>";
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
echo "<tr valign='top'><td align=center>$n</td><td>".$data['nama']."</td><form method=post target='iframe' action='exe/kaos.php?id=".$data['id']."'><td>".$data['kaos']." -> <input type=text name='kaos' value='".$data['kaos']."' size='3' onkeyup=\"javascript:this.form.submit();\"></td><td>".$data['rompi']." -> <input type=text name=rompi value='".$data['rompi']."' size='3' onkeyup=\"javascript:this.form.submit();\"></td></form><td>".$nip."</td><td>".$data['jenjang']."</td><td>".$data['id']."</td><form method=post><input type=hidden name=id value='".$data['id']."'><td align=center>
<input type=submit name=hapus value=X style='padding:0px;'></td></form></tr>";

// var_dump($jml);
}

echo "</tbody></table>";
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
if ($_POST['tahun']!="" and $_POST['bulan']!="") {
if ($_POST['tambah']=="Tambah") { app_replace("penempatan","'".$th."_".$bl."_".$_POST['popt']."','".$th."','".$bl."','".$_POST['popt']."', '".$id_lokasi."','".$_POST['tugas']."'"); }
echo "
<form method=post>
Tambahkan Petugas di <b>".$_POST['lokasi']."</b>: <input type=hidden name=tahun value=".$th."><input type=hidden name=bulan value=".$bl."><input type=hidden name=lokasi value='".$_POST['lokasi']."'>
    <select id='select2' name=popt><option></option>".popt_opt()."
    </select> <select name=tugas style='padding:3px;'><option></option><option>Koordinator</option>
    </select>
<input type=submit name=tambah value=Tambah style='padding:3px;'></form>";
}

}

$query = "SELECT * FROM penempatan JOIN popt ON penempatan.id_popt=popt.id WHERE tahun LIKE '".$th."%' AND bulan LIKE '".$bl."%' ".$wh." order by nama";
$results = $db->get_results( $query );

echo "
<table class='table' width=100% id=example>
<thead>
<tr><th>NO</th><th>TAHUN</th><th>BULAN</th><th>NAMA</th><th>LOKASI</th><th>TUGAS</th></tr>
</thead><tbody>";
$kbl=$_POST['ke_bulan'];
$kth=$_POST['ke_tahun'];
foreach( $results as $data )
{
	$n++;

$nip=db_baca("user_login", "karyawan","id='".$data['id']."'","nip");
echo "<tr valign='top'><td align=center>$n</td><td>".$data['tahun']."</td><td>".$data['bulan']."</td><td>".$data['nama']."<br>NIP. ".$nip."</td><td>".app_baca("lokasi","id_lokasi='".$data['id_lokasi']."'","lokasi")."</td><td>".$data['tugas']."</td></tr>";
if ($kbl!="" and $kth!="") {
app_replace("penempatan","'".$kth."_".$kbl."_".$data['id_popt']."','".$kth."','".$kbl."','".$data['id_popt']."', '".$data['id_lokasi']."','".$data['tugas']."'");
	
}

}
echo "</tbody></table>";
echo "<form method=post>
<input type=hidden name=tahun value='".$th."'><input type=hidden name=bulan value='".$bl."'>
Copy Penempatan ".$th."-".$bl." Ke  <select name=ke_tahun style='padding:3px;'><option>".$th."</option><option></option><option>2018</option><option>2019</option>
    </select> Bulan <select name=ke_bulan style='padding:3px;'><option>".$bl."</option><option></option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option>
    </select>
<input type=submit name=cari value=Go style='padding:3px;'></form>";
}




function realisasi_bln($th,$id) {
while ($b<12) {
$b++;
$idn=$th."-".substr("0".$b,-2)."-01_".$id;

$bb.="<td align=center><input type=text style='width:30px;' value='".app_baca("realisasi","id_realisasi='".$idn."_TK'","jumlah")."' id='tk_".$id."_".$b."' onkeyup=\"requestContent2('ajx/real.php?th=$th&id=".$idn."_TK_','".$id."','tk_".$id."_".$b."')\"></td><td align=center bgcolor='#dddddd'><input type=text style='width:30px;'  value='".app_baca("realisasi","id_realisasi='".$idn."_LN'","jumlah")."'  id='ln_".$id."_".$b."' onkeyup=\"requestContent2('ajx/real.php?th=$th&id=".$idn."_LN_','".$id."','ln_".$id."_".$b."')\"></td>";

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
$query = "SELECT * FROM popt order by nama";
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

function realisasi2(){
if ($_GET['m']=="") {$m=date("Y-m-01");$s=today();} else {$m=$_GET['m'];$s=$_GET['s'];}
$k=$_GET['k'];
 $db = new database();
$db->connect("tugasdb");
echo "
<form method=get>
Tgl Tugas <input type=date value='".$m."' name='m'> sd <input type=date value='".$s."' name='s'> <select name=k><option value='".$k."'>".$k."</option><option value=''>Luar Kota</option><option value='Dalam Kota'>Dalam Kota</option></select> 
<input type=hidden name=t value='Realisasi' >
<input type=submit name=cari value=Cari style='padding:3px;'></form>
";
if ($k=="Dalam Kota") {$wh="and (kota LIKE '%Jakarta%' or (kota LIKE '%Bogor%' and dari LIKE '%Bogor%'))";} else {$wh="and kota NOT LIKE '%Jakarta%'";}
$query = "SELECT * FROM spt_petugas JOIN spt ON spt_petugas.id_spt=spt.id where kat='TKT' and waktu_selesai>='".$m."' and waktu_selesai<='".$s."' ".$wh." and nom_id<=0 order by nama asc,waktu_selesai asc";
$results = $db->get_results( $query );
$n=0;
echo "<table class='table' width=100% id=example><thead><tr><th>NO</th><th>TGL</th><th>STATUS BERKAS</th><th>NAMA</th><th>REKAN</th><th>KOTA</th><th>NO SPT</th><th>PERUSAHAAN</th></tr></thead><tbody>";

foreach( $results as $data )
{

	$tgs=$data['tujuan'];
	$tgs=str_replace("Melakukan pemeriksaan fisik/kesehatan media pembawa","",$tgs);
	$tgs=str_replace("Milik/Perusahaan","",$tgs);
	$tgs=str_replace("2018.2.0300.0.S01.","",$tgs);
if ($data['nom_id']>0) {$st="LENGKAP";} else {$st="<b>BELUM!!!</b>";}
if (strstr(strtolower($data['kota']),"bogor") and strstr(strtolower($data['dari']),"bogor")) {} else {
		$n++;
echo "<tr valign='top'><td align=center>$n</td><td>".$data['waktu_selesai']."</td><td>".$st."</td><td>".$data['nama']."</td><td>".spt_rekan($data['id_spt'],$data['id_user'])."</td><td>".$data['kota']."</td><td>".substr($data['no'],18,20)."</td><td>".$tgs."</td></tr>";
}
//echo "".$data['nama']."+".spt_rekan($data['id_spt'],$data['id_user'])." ".$data['kota']." ".$data['waktu_selesai']." ".$st." <br>";
}
echo "</tbody></table>";
}

function spt_rekan($id_spt,$id_p) {
$db = new database();
$db->connect("tugasdb");
$query = "SELECT nama FROM spt_petugas WHERE id_spt='".$id_spt."' and id_user!='".$id_p."' order by nama";
$results = $db->get_results( $query );
foreach( $results as $row) {
$j.=$row['nama']."";
}
return $j;

}

function jadwal_popt($ar,$th,$bl,$id) {
$date= $_POST['tahun']."-".$_POST['bulan']."-01";
$last_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", last day of this month");
//echo $last_date = date("Y-m-d",$last_date_find);
$j=date("d",$last_date_find);
while ($a<$j) {
$a++;
$t=substr("0".$a,-2);
$head.="<th>".$t."</th>";
$id_jd=$th."-".$bl."-".$t."_".$id;
$tgly=$th."-".$bl."-".$t;
$jd=app_baca("jadwal","id_jadwal='".$id_jd."'","id_popt");
if (nama_hari($tgly)=="Sun") {$bg="bgcolor='999999'"; } elseif (nama_hari($tgly)=="Sat") {$bg="bgcolor='aaaaaa'"; } else  {$bg="";}
if ($jd>0) {$ch="checked"; } else {$ch=""; }
$body.="<td align=center ".$bg."><input type=checkbox $ch style='margin:0;' onclick=\"requestContent('ajx/jdwl.php?id=".$id_jd."','jdwl')\"></td>";
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
<tr><th>NO</th><th>TAHUN</th><th>BULAN</th><th>NAMA</th><th>LOKASI</th><th>KAOS</th><th>ROMPI</th>".jadwal_popt("head",$th,$bl,"")."</tr>
</thead><tbody>";

foreach( $results as $data )
{
	$n++;
echo "<tr valign='top'><td align=center>$n</td><td>".$data['tahun']."</td><td>".$data['bulan']."</td><td>".$data['nama']."</td><td>".app_baca("lokasi","id_lokasi='".$data['id_lokasi']."'","lokasi")."</td><form method=post target='iframe' action='exe/kaos.php?id=".$data['id_popt']."'><td><input type=text name='kaos' value='".$data['kaos']."' size='3' onkeyup=\"javascript:this.form.submit();\"></td><td><input type=text name=rompi value='".$data['rompi']."' size='3' onkeyup=\"javascript:this.form.submit();\"></td></form>".jadwal_popt("body",$th,$bl,$data['id'])."</tr>";
}
echo "</tbody></table><div id=jdwl></div>";
}


function alokasi(){
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

function kota_opt(){
$db = new database();
$db->connect("ops");
$query = "SELECT * FROM tarif WHERE kode_tarif LIKE 'C1A%' order by uraian";
$results = $db->get_results( $query );
foreach( $results as $data )
{
	$n++;
	$jml.="<option>".$data['uraian']."</option>";
}
return $jml;
}


function distribusi2(){
     $db = new database();
$db->connect("movedb");
if ($_GET['tgl_periksa']=="") {$tgl_periksa=next_date(today());} else {$tgl_periksa=$_GET['tgl_periksa'];}


if ($_POST['tambah']=="+") {
$no_reg="2018.2.0300.0.S01.".$_POST['kode'].".".substr("000000".$_POST['no_permohonan'],-6);
if ($_POST['kode']=="E") {$pers=db_baca("movedb","kt_ekspor","no_permohonan='".$no_reg."'","perusahaan");}
if ($_POST['kode']=="I") {$pers=db_baca("movedb","kt_impor","no_reg='".$no_reg."'","nama_pemilik");}
// var_dump($pers);exit();
app_replace("alokasi","'".$tgl_periksa."','".$no_reg."','".$pers."','".$_POST['kota']."','".$_POST['jumlah']."'");	
}

if ($_POST['del_doc']==" X ") {
if ($_POST['src']=="ori") {	app_replace("alokasi_del","'".$_POST['no_permohonan']."'");	 }
if ($_POST['src']=="add") {	app_delete("alokasi","no_permohonan='".$_POST['no_permohonan']."'"); }
app_delete("distribusi","no_permohonan='".$_POST['no_permohonan']."'");

}

if ($_POST['del_popt']==" X ") {
app_delete("jadwal","id_jadwal='".$tgl_periksa."_".$_POST['id_popt']."'");
}

if ($_POST['alokasi']=="Simpan") {
$jen=app_baca("popt","id='".$_POST['untuk']."'","jenjang");
app_replace("distribusi","'".$tgl_periksa."_".$_POST['untuk']."','".$tgl_periksa."','".$_POST['untuk']."','".$_POST['no']."','".$jen."','','".$_GET['kota']." : ".$_GET['pt']."'");	
}

$n=0;
echo "<a href=\"javascript:void(0);\" data-href=\"form.php\" class=\"openPopup\">Ed</a>
<form method=get>
Tgl Periksa <input type=date value='".$tgl_periksa."' name='tgl_periksa'>
<input type=hidden name=t value='Distribusi' >
<input type=submit name=cari value=Cari style='padding:3px;'></form>
";

$query = "SELECT * FROM kt_ekspor WHERE tgl_periksa LIKE '".$tgl_periksa."%' order by tgl_periksa";
$results = $db->get_results( $query );

echo "
<h3>DOKUMEN PERIKSA</h3>
<table class='table' width=100% id=example>
<thead>
<tr><th>NO</th><th>TANGGAL PERIKSA</th><th>TANGGAL AJU</th><th>AKUN</th><th>PERUSAHAAN</th><th>NO REG</th><th>JUMLAH PETUGAS</th><th>KOTA</th><th></th><th></th><th>A</th><th>T</th></tr>
</thead>
<tr><form method=post><td></td><td></td><td></td><td></td><td style='font-weight:700;text-align:right;'>Tambah</td><td><select name=kode><option value='E'>Ekspor</option><option value='I'>BC-23</option></select><input type=number name='no_permohonan' value='' style='width:60px;'></td><td><input type=number name=jumlah value='2' style='width:50px;'></td><td><select name=kota><option></option>".kota_opt()."</select></td><td><input type=submit name=tambah value=+><input type=hidden name=kode_doc value='I'></td><td></td><td></td><td></td></form></tr>
<tbody>";

foreach( $results as $data )
{

$jml=pnbp_perjalanan($data['no_permohonan']);
$keb+=$jml;
	if ($jml>0) {
			
			$ppk_ol=substr($data['no_aju'],5,7);
			$lokasi=db_baca("ops","tarif","kode_tarif='".db_baca("ops","pnbp_lain","no_permohonan='".$data['no_permohonan']."' and kode_tarif LIKE 'C1A%'","kode_tarif")."'","uraian");
$hapus=app_baca("alokasi_del","no_permohonan='".$data['no_permohonan']."'","no_permohonan");

	if ($hapus=="")	{	
$n++;	

	$ala=app_jml("distribusi","no_permohonan='".$data['no_permohonan']."' and tgl_periksa='".$tgl_periksa."' and jenjang='AHLI'","tgl_periksa");
$alt=app_jml("distribusi","no_permohonan='".$data['no_permohonan']."' and tgl_periksa='".$tgl_periksa."' and jenjang='TERAMPIL'","tgl_periksa");
if ($jml==1) {$pa=0;$pt=1;}
if ($jml==2) {$pa=1;$pt=1;}
if ($jml==3) {$pa=1;$pt=2;}
if ($jml==4) {$pa=2;$pt=2;}
$ppa=($pa-$ala);$ppt=($pt-$alt);
$dtanya=$data['no_permohonan']." :: ".$lokasi." :: ".$data['perusahaan']."|||";
if ($_GET['random']=="run1") {
if (strstr($lokasi,"Bogor")) {} else {
if ($ppa==1) {$a+=1;$da.=$dtanya;}
if ($ppt==1) {$t+=1;$dt.=$dtanya;}
if ($ppa==2) {$a+=2;$da.=$dtanya;$da.=$dtanya;}
if ($ppt==2) {$t+=2;$dt.=$dtanya;$dt.=$dtanya;}	
	
}
} elseif ($_GET['random']=="run2") {
if (strstr(strtolower($data['perusahaan']),"unilever") or strstr(strtolower($data['perusahaan']),"bumitangerang")) {
if ($ppa==1) {$a+=1;$da.=$dtanya;}
if ($ppt==1) {$t+=1;$dt.=$dtanya;}
if ($ppa==2) {$a+=2;$da.=$dtanya;$da.=$dtanya;}
if ($ppt==2) {$t+=2;$dt.=$dtanya;$dt.=$dtanya;}	
	
}
} elseif ($_GET['random']=="run3") {
if (strstr($lokasi,"Bekasi") or strstr($lokasi,"Karawang") or strstr($lokasi,"Purwakarta")) {
if ($ppa==1) {$a+=1;$da.=$dtanya;}
if ($ppt==1) {$t+=1;$dt.=$dtanya;}
if ($ppa==2) {$a+=2;$da.=$dtanya;$da.=$dtanya;}
if ($ppt==2) {$t+=2;$dt.=$dtanya;$dt.=$dtanya;}	
	
}
} else {
if ($ppa==1) {$a+=1;$da.=$dtanya;}
if ($ppt==1) {$t+=1;$dt.=$dtanya;}
if ($ppa==2) {$a+=2;$da.=$dtanya;$da.=$dtanya;}
if ($ppt==2) {$t+=2;$dt.=$dtanya;$dt.=$dtanya;}	
	
}

echo "<tr valign='top'><td align=center>$n</td><td>".$data['tgl_periksa']."</td><td>".$data['tgl_submit']."</td><td>".$ppk_ol."</td><td>".$data['perusahaan']."</td><td>".substr($data['no_permohonan'],-8)."</td><td>".$jml."</td><td>".$lokasi."</td><form method=post><td><input type=hidden name=no_permohonan value='".$data['no_permohonan']."'><input type=hidden name=src value=ori><input type=submit name=del_doc value=' X ' class=x></td><td><a href='?t=Distribusi&tgl_periksa=".$tgl_periksa."&no=".$data['no_permohonan']."&kota=".$lokasi."&pt=".$data['perusahaan']."'>d</a></td><td>$ala</td><td>$alt</td></form></tr>";

}
}
}



     $db = new database();
$db->connect(app_db());
$query = "SELECT * FROM alokasi WHERE tgl_periksa LIKE '".$tgl_periksa."%' order by tgl_periksa";
$results = $db->get_results( $query );
foreach( $results as $data )
{
	$n++;prioqnet/
	$lokasi=$data['kota'];

$jml=$data['jml_petugas'];
$keb+=$jml;
$ala=app_jml("distribusi","no_permohonan='".$data['no_permohonan']."' and tgl_periksa='".$tgl_periksa."' and jenjang='AHLI'","tgl_periksa");
$alt=app_jml("distribusi","no_permohonan='".$data['no_permohonan']."' and tgl_periksa='".$tgl_periksa."' and jenjang='TERAMPIL'","tgl_periksa");
if ($jml==1) {$pa=0;$pt=1;}
if ($jml==2) {$pa=1;$pt=1;}
if ($jml==3) {$pa=1;$pt=2;}
if ($jml==4) {$pa=2;$pt=2;}
$ppa=($pa-$ala);$ppt=($pt-$alt);
$dtanya=$data['no_permohonan']." :: ".$lokasi." :: ".$data['perusahaan']."|||";

if ($_GET['random']=="run1") {
if (strstr($lokasi,"Bogor")) {} else {
if ($ppa==1) {$a+=1;$da.=$dtanya;}
if ($ppt==1) {$t+=1;$dt.=$dtanya;}
if ($ppa==2) {$a+=2;$da.=$dtanya;$da.=$dtanya;}
if ($ppt==2) {$t+=2;$dt.=$dtanya;$dt.=$dtanya;}	
	
}
} elseif ($_GET['random']=="run2") {
if (strstr(strtolower($data['perusahaan']),"unilever") or strstr(strtolower($data['perusahaan']),"bumitangerang")) {
if ($ppa==1) {$a+=1;$da.=$dtanya;}
if ($ppt==1) {$t+=1;$dt.=$dtanya;}
if ($ppa==2) {$a+=2;$da.=$dtanya;$da.=$dtanya;}
if ($ppt==2) {$t+=2;$dt.=$dtanya;$dt.=$dtanya;}	
	
}
} elseif ($_GET['random']=="run3") {
if (strstr($lokasi,"Bekasi") or strstr($lokasi,"Karawang") or strstr($lokasi,"Purwakarta")) {
if ($ppa==1) {$a+=1;$da.=$dtanya;}
if ($ppt==1) {$t+=1;$dt.=$dtanya;}
if ($ppa==2) {$a+=2;$da.=$dtanya;$da.=$dtanya;}
if ($ppt==2) {$t+=2;$dt.=$dtanya;$dt.=$dtanya;}	
	
}
} else {
if ($ppa==1) {$a+=1;$da.=$dtanya;}
if ($ppt==1) {$t+=1;$dt.=$dtanya;}
if ($ppa==2) {$a+=2;$da.=$dtanya;$da.=$dtanya;}
if ($ppt==2) {$t+=2;$dt.=$dtanya;$dt.=$dtanya;}		
}
echo "<tr valign='top'><td align=center>$n</td><td>".$data['tgl_periksa']."</td><td></td><td></td><td>".$data['perusahaan']."</td><td>".substr($data['no_permohonan'],-8)."</td><td>".$data['jml_petugas']."</td><td>".$data['kota']."</td><form method=post><td><input type=hidden name=no_permohonan value='".$data['no_permohonan']."'><input type=hidden name=src value=add><input type=submit name=del_doc value=' X ' class=x></td><td><a href='?t=Distribusi&tgl_periksa=".$tgl_periksa."&no=".$data['no_permohonan']."&kota=".$data['kota']."&pt=".$data['perusahaan']."' >d</a></td><td>$ala</td><td>$alt</td></form></tr>";
}	
	
echo "</tbody></table>Kebutuhan Ahli $a Terampil $t<br>";



   $dt = explode("|||", $dt);
   shuffle ($dt);
   $dt = "STR".implode("|||", $dt)."FNL";
   $da = explode("|||", $da);
   shuffle ($da);
   $da = "STR".implode("|||", $da)."FNL"; 
   $dt=str_replace ("||||||","|||",$dt);
   $da=str_replace ("||||||","|||",$da);
   
   $dt=str_replace ("STR|||","",$dt);
   $dt=str_replace ("|||FNL","",$dt);
   $da=str_replace ("STR|||","",$da);
   $da=str_replace ("|||FNL","",$da);
   
   $dt=str_replace ("STR","",$dt);
   $dt=str_replace ("FNL","",$dt);
   $da=str_replace ("STR","",$da);
   $da=str_replace ("FNL","",$da);
   
//echo "<br>$dt<br>$da";   

//$keb=$a+$t;
$db->connect(app_db());
$query = "SELECT * FROM jadwal JOIN popt ON jadwal.id_popt=popt.id JOIN realisasi_jml ON realisasi_jml.id_popt=popt.id WHERE tgl='".$tgl_periksa."' order by jml limit 0,".$keb."";
$results = $db->get_results( $query );

$nn=0;
foreach( $results as $data )
{ 
	$nn+=1;
$dis_a=app_jml("distribusi","id_popt='".$data['id_popt']."' and tgl_periksa='".$tgl_periksa."'","id_popt");	
if ($dis_a<=0) {
$id_lokasi=app_baca("penempatan","id_penempatan='".substr($tgl_periksa,0,4)."_".substr($tgl_periksa,5,2)."_".$data['id_popt']."'","id_lokasi");
$dtnya=	$data['nama']." :: ".$data['id_popt']." :: ".app_baca("lokasi","id_lokasi='".$id_lokasi."'","lokasi")."|||";

if ($data['jenjang']=="AHLI"){$aa+=1;}
if ($data['jenjang']=="TERAMPIL"){$tt+=1;}	

if ($_GET['random']=="run1") {
if (strstr($dtnya,"BOGOR")) {
if ($data['jenjang']=="AHLI"){
if ($aa>$a) {$si_a.=$dtnya;} else {$al_a.=$dtnya;}
}
if ($data['jenjang']=="TERAMPIL"){
if ($tt>$t) {$si_t.=$dtnya;} else {$al_t.=$dtnya;}
}	

} } elseif ($_GET['random']=="run2") {
if (strstr(strtolower($dtnya),"sihar simang") OR strstr(strtolower($dtnya),"agung fikrian")) {
if ($data['jenjang']=="AHLI"){
if ($aa>$a) {$si_a.=$dtnya;} else {$al_a.=$dtnya;}
}
if ($data['jenjang']=="TERAMPIL"){
if ($tt>$t) {$si_t.=$dtnya;} else {$al_t.=$dtnya;}
}	

} } elseif ($_GET['random']=="run3") {
if ($data['id_popt']=="137") {
if ($data['jenjang']=="AHLI"){
if ($aa>$a) {$si_a.=$dtnya;} else {$al_a.=$dtnya;}
}
if ($data['jenjang']=="TERAMPIL"){
if ($tt>$t) {$si_t.=$dtnya;} else {$al_t.=$dtnya;}
}

} } else {


if ($data['jenjang']=="AHLI"){

if ($aa>$a) {$si_a.=$dtnya;} else {$al_a.=$dtnya;}
}
if ($data['jenjang']=="TERAMPIL"){

if ($tt>$t) {$si_t.=$dtnya;} else {$al_t.=$dtnya;}
}
//var_dump($al_a);exit(); 


}
}
if ($dis_a>0) {$bg="bgcolor='#bbb'";} else {$bg="";}
$dt_peg.= "<tr valign='top' ".$bg."><td align=center>$nn</td><td>".$data['tgl']."</td><td>".$data['nama']."</td><td>".$data['jenjang']."</td><td>".$data['jml']."</td><form method=post><td><input type=hidden name=id_popt value='".$data['id_popt']."'><input type=submit name=del_popt value=' X ' class=x></td></form></tr>";
$popt_opt.="<option value='".$data['id_popt']."'>".$data['nama']."</option>";
}
$dta=str_replace ("|||FNL","",$al_a.$si_t."FNL");
$dtt=str_replace ("|||FNL","",$al_t.$si_a."FNL");
// var_dump($dtt);exit();
$query = "SELECT * FROM jadwal JOIN popt ON jadwal.id_popt=popt.id JOIN realisasi_jml ON realisasi_jml.id_popt=popt.id WHERE tgl='".$tgl_periksa."' order by jml limit ".$keb.",100";
$results = $db->get_results( $query );


foreach( $results as $data )
{ $nn+=1;
$dis_a=app_jml("distribusi","id_popt='".$data['id_popt']."' and tgl_periksa='".$tgl_periksa."'","id_popt");
if ($dis_a>0) {$bg="bgcolor='#bbb'";} else {$bg="";}
$dt_peg2.= "<tr valign='top' ".$bg."><td align=center>$nn</td><td>".$data['tgl']."</td><td>".$data['nama']."</td><td>".$data['jenjang']."</td><td>".$data['jml']."</td><form method=post><td><input type=hidden name=id_popt value='".$data['id_popt']."'><input type=submit name=del_popt value=' X ' class=x></td></form></tr>";
$popt_opt.="<option value='".$data['id_popt']."'>".$data['nama']."</option>";
}

if ($_GET['no']!="") {
echo "<form method=post><input type=hidden name=no value='".$_GET['no']."'>Alokasikan ".$_GET['no']." : ".$_GET['pt']." untuk <select name=untuk id=select2><option></option>".$popt_opt."</select><input type=submit name=alokasi value=Simpan></form>";	
}

echo "
<h3>JADWAL PETUGAS</h3>
<table class='table' width=100% id=example2>
<thead>
<tr><th>NO</th><th>JADWAL</th><th>NAMA</th><th>JENJANG</th><th>AKUMULASI PERJALANAN</th><th></th></tr>
</thead><tbody>";
echo $dt_peg.$dt_peg2;
echo "</tbody></table>Ketersediaan AHLI : $aa TERAMPIL : $tt ";
//echo "<br><br>$dtt<br>$dta<br>$dtny<br>$dt<br>$da";



echo "
<h3>SIMULASI RANDOM</h3>
<table class='table' width=100% id=example3>
<thead>
<tr><th>NO</th><th>TGL</th><th>NAMA</th><th>DOKUMEN</th><th>KETERANGAN</th></tr>
</thead><tbody>";

$c=0;
$dt = explode("|||", $dt);
$da = explode("|||", $da);
$dtt = explode("|||", $dtt);
$dta = explode("|||", $dta);


while ($c<$n) {
$nt+=1;	
$na+=2;	
// var_dump($dtt[$c]);
if ($dtt[$c]!="" and $dt[$c]!="") {
echo running($tgl_periksa,$dtt[$c],$dt[$c]);
}
if ($dta[$c]!="" and $da[$c]!="") {
echo running($tgl_periksa,$dta[$c],$da[$c]);
}
$c+=1;	
}


echo "</tbody></table>";

dis_alocate($tgl_periksa);
if (nama_hari($tgl_periksa)=="Mon") { $t1=$tgl_periksa." 11:00:00";$t2=next_date(next_date(today())).date(" H:i:s");} else {$t1=$tgl_periksa." 11:00:00";$t2=next_date(today()).date(" H:i:s");}
echo $t1." &nbsp; ".$t2;
if ($t1<=$t2) {
echo "<center><br><a href='?t=Distribusi&tgl_periksa=".$tgl_periksa."&random=run2' style='font-size:21px;'>Random Sekarang</a></center>
"; }
if ($_GET['random']=="run2") {
echo " <meta http-equiv=\"refresh\" content=\"0; URL=?t=Distribusi&tgl_periksa=".$tgl_periksa."&random=run1\">";	
}
if ($_GET['random']=="run1") {
echo " <meta http-equiv=\"refresh\" content=\"0; URL=?t=Distribusi&tgl_periksa=".$tgl_periksa."&random=run3\">";	
}
if ($_GET['random']=="run3") {
echo " <meta http-equiv=\"refresh\" content=\"0; URL=?t=Distribusi&tgl_periksa=".$tgl_periksa."&random=run4\">";
app_update("distribusi","tgl_periksa='".$tgl_periksa."'", "status='final'");	
}

if ($_GET['random']=="run4") {
echo " <meta http-equiv=\"refresh\" content=\"0; URL=?t=Distribusi&tgl_periksa=".$tgl_periksa."\">";	
}

}

function dis_alocate($tgl_periksa){
	
  $db = new database();
$db->connect(app_db());
$query = "SELECT * FROM distribusi JOIN popt ON distribusi.id_popt=popt.id  WHERE tgl_periksa='".$tgl_periksa."' order by ket desc";
$results = $db->get_results( $query );

$nn=0;
echo "
<h3>DISTRIBUSI FINAL</h3>
<table class='table' width=100% id=example4>
<thead>
<tr><th>NO</th><th>TGL</th><th>NAMA</th><th>DOKUMEN</th><th>KETERANGAN</th></tr>
</thead><tbody>";
foreach( $results as $data )
{ 	
	$n+=1;
echo "<tr valign='top'><td align=center>$n</td><td>".$data['tgl_periksa']."</td><td>".$data['nama']."</td><td>".$data['no_permohonan']."</td><td>".$data['ket']."</td></tr>";
}
echo "</tbody></table>";
}


