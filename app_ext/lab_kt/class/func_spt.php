<?php
function spt_menu() {
$ap="spt.php";	
return "<a href='".$ap."?t=Tambah'>Tambah</a> <a href='".$ap."?t=Arsip'>Arsip</a><a href='".$ap."?t=Rekap'>Rekap</a><a href='inc/libur.php' target='_blank'>Libur</a>";	
}

function kota_opt() {
$db = new database();
$db->connect(real_db());
$query = "SELECT * FROM kota order by kota";
$results = $db->get_results( $query );
foreach( $results as $data )
{
$ret.="<option value='".$data['kota']."'>".$data['kota']."</option>";
}
return $ret;
}

function prov_opt() {
$db = new database();
$db->connect(real_db());
$query = "SELECT * FROM prov order by prov";
$results = $db->get_results( $query );
foreach( $results as $data )
{
$ret.="<option value='".$data['prov']."'>".$data['prov']."</option>";
}
return $ret;
}

function mak_opt($th,$no) {
$db = new database();
$db->connect("b_realisasi_".$th);
$query = "SELECT no,uraian,mak,hargasat FROM pok WHERE sat='OP' or sat='OK' order by mak";
$results = $db->get_results( $query );
foreach( $results as $data )
{
$ret.="<option value='".$data['no']."'>".$data['mak']." ".$data['uraian']." @".rp($data['hargasat'])."</option>";
if ($no==$data['no']) {$sel="<option value='".$data['no']."'>".$data['mak']." ".$data['uraian']." ".rp($data['hargasat'])."</option>";}
}
return $sel."<option></option>".$ret;
}

function spt_rekap(){
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM spt join spt_petugas ON spt.id=spt_petugas.id_spt WHERE id_user='".user_id()."' and  tgl>='".tgl_pilih("m")."' and tgl<='".tgl_pilih("s")."' and tujuan LIKE '%".tgl_pilih("h")."%' order by update_time desc";
$results = $db->get_results( $query );
$n=0;
echo tgl_pilih_f()."<table class='table' width=100% id=example>
<thead>
<tr><th>NO</th><th>TGL SURAT</th><th>NO SURAT</th><th>TUGAS</th><th>LOKASI</th><th>KOTA</th><th>TGL TUGAS</th><th>AKUN</th><th>PENERIMA&nbsp;TUGAS</th><th></th></tr>
</thead><tbody>";

foreach( $results as $data )
{
	$n++;
	if ($data['tahun']>="2018") {$mak=db_baca("b_realisasi_".$data['tahun'],"pok","no='".$data['mak']."'","mak");}	
echo "<tr valign='top'><td align=center>$n</td><td>".$data['tgl']."</td><td>".$data['no_spt']."</td><td>".$data['tujuan']."</td><td>".$data['lokasi']."</td><td>".$data['kota']."</td><td>".$data['waktu_mulai']." - ".$data['waktu_selesai']."</td><td class='small'><div>".$mak."</div></td><td class='small'>".spt_petugas($data['id'])."</td><td align=center>".print_link_spt($data['id_spt'])."</td></tr>";
}
echo "</tbody></table>";
}

function print_link_spt($id) {
$d.="<a href='print/p_spt.php?id=".$id."' target='_blank'>spt</a> ";
if (app_jml("spt_petugas","id_spt='".$id."'","nip")>3) {
$d.="<a href='print/p_spt_lamp.php?id=".$id."' target='_blank'>lmp</a> "; }
if (strstr(strtolower(app_baca("spt","id='".$id."'","kota")),"bekasi")) {$d.="<a href='print/p_spt_bkt.php?id=".$id."' target='_blank'>bkt</a>";} else {$d.="<a href='print/p_spd2.php?id_spt=".$id."' target='_blank'>spd2</a>";}
return $d;
}

function spt_arsip(){
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM spt WHERE tgl>='".tgl_pilih("m")."' and tgl<='".tgl_pilih("s")."' and tujuan LIKE '%".tgl_pilih("h")."%'  order by unik desc";
$results = $db->get_results( $query );
$n=0;
echo tgl_pilih_f()."<table class='table' width=100% id=example>
<thead>
<tr><th>NO</th><th>TGL SURAT</th><th>NO SURAT</th><th>TUGAS</th><th>KOTA</th><th>TGL TUGAS</th><th>AKUN</th><th>PENERIMA&nbsp;TUGAS</th><th></th><th></th></tr>
</thead><tbody>";

foreach( $results as $data )
{
	$n++;
if ($data['tahun']>="2018") {$mak=db_baca("b_realisasi_".$data['tahun'],"pok","no='".$data['mak']."'","mak");}	
echo "<tr valign='top'><td align=center>$n</td><td>".$data['tgl']."</td><td>".$data['no_spt']."</td><td>".$data['tujuan']."</td><td>".$data['kota']."</td><td>".$data['waktu_mulai']." - ".$data['waktu_selesai']."</td><td class='small'><div>".$mak."</div></td><td class='small'>".spt_petugas($data['id'])."</td><td align=center><a href='?t=Edit&id=".$data['id']."'><img src='css/edit.png' height='20px'></a></td><td align=center>".print_link_spt($data['id'])."</td></tr>";
}
echo "</tbody></table><div style='text-align:center'><a target='_blank' href='print/r_st.php?m=".tgl_pilih("m")."&s=".tgl_pilih("s")."'>Print to PDF</a> &nbsp; <a target='_blank' href='print/x_st.php?m=".tgl_pilih("m")."&s=".tgl_pilih("s")."'>Export to XLS</a></div><div id=update></div>";
}

function spt_petugas($id) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM spt_petugas WHERE id_spt ='".$id."' order by no";
$results = $db->get_results( $query );
$n=0;
$kota=strtolower(app_baca("spt","id='".$id."'","kota"));

foreach( $results as $data )
{
	$n++;
if (strstr($kota,"bekasi")) { $spd1="";} else { $spd1="<a href='print/p_spd1.php?id=".$data['id']."&id_spt=".$data['id_spt']."' target='_blank'>spd1</a>";}
$row.= "<div>- ".$data['nama']." ".$spd1."</div>";
}
return $row;
}

function spt_petugas_front($id,$cl) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM spt_petugas WHERE id_spt ='".$id."' order by no";
$results = $db->get_results( $query );
$n=0;
foreach( $results as $data )
{
	$n++;
	$row.= "<tr><td>".$n."</td><td>".$data['no']."</td><td>".$data['no_spd']."".$data['no_spd_alp']."</td><td>".$data['nama']."</td><td>".$data['gol']."</td><td>".$data['jab']."</td><td><a href='print/p_spd1.php?id=".$data['id']."&id_spt=".$data['id_spt']."' target='_blank'>spd1</a></td><td><a href='print/p_spd2.php?id=".$data['id']."&id_spt=".$data['id_spt']."' target='_blank'>spd2</a></td><td>".rp(app_sum("spt_realisasi","id_petugas='".$data['id']."'","total"))."</td></tr>";
}
return "<table class='table'>".$row."</table>";
}


function spt_form($tab) {

if ($tab=="Tambah") {
$unik=unik();
$no_spt=(app_baca("spt","no_spt!='' order by no_spt desc","no_spt"))+1;
$dipa="Daftar Isian Pelaksanaan Anggaran (DIPA) Balai Uji Terap Teknik dan Metode Karantina Pertanian";
$kep_jab="Kepala";
$dari="Bekasi";
$angkutan="Angkutan Darat";
$kep_nama=app_baca("spt_global","name='kepala'","value");
$kep_jab="Kepala";
$ppk_nama=app_baca("spt_global","name='ppk'","value");
app_insert("spt","'', '            ".$no_spt."', '".$p1."', '\n', '".today()."', '".today()."', '\n','".$dipa."', '".date("Y")."', '\n', '".today()."', '".$kep_jab."', '".$kep_nama."', '".$post_kep_nip."', '".$unik."', '".$kota."', '".$tembusan."', '".$angkutan."', '".$jml_petugas."', '".$kat."', '".$dari."', '".$ppk_nama."', '".$post_ppk_nip."', '".today()."', '".$pukul."', '".user_id()."', '".user_id()."', '".now()."', '".now()."'");

$idny=app_baca("spt","unik='".$unik."'","id");	
echo "<meta http-equiv=\"refresh\" content=\"0; URL=?t=Edit&id=".$idny."\">";

}
if ($tab=="Edit") {
$id=$_GET['id'];
$m=$_GET['m'];
if ($_POST and $m=="") {
app_replace("spt","'$id', '".$_POST['no_spt']."', '".$_POST['p1']."', '".$_POST['tujuan']."', '".$_POST['waktu_mulai']."', '".$_POST['waktu_selesai']."', '".$_POST['lokasi']."','".$_POST['dipa']."', '".$_POST['tahun']."', '".$_POST['mak']."', '".$_POST['tgl']."', '".$_POST['kep_jab']."', '".$_POST['kep_nama']."', '".$post_kep_nip."', '".$_POST['unik']."', '".$_POST['kota'].$_POST['kota2']."', '".$_POST['tembusan']."', '".$_POST['angkutan']."', '".$_POST['jml_petugas']."', '".$_POST['kat']."', '".$_POST['dari']."', '".$_POST['ppk_nama']."', '".$_POST['prov']."', '".$_POST['tgl_spj']."', '".$_POST['pukul']."', '".$_POST['input_oleh']."', '".user_id()."', '".$_POST['input_time']."', '".now()."'");	
}

if ($_POST and $m=="Petugas") {
	$idp=$id."_".$_POST['nama'];
	$id_spt_ul=$_POST['nama'];
		$nama=db_baca(real_db(),"karyawan","id='".$id_spt_ul."'","nama");
	$nip=db_baca(real_db(),"karyawan","id='".$id_spt_ul."'","nip");
$gol=db_baca(real_db(),"karyawan","id='".$id_spt_ul."'","golongan");
$jabatan=db_baca(real_db(),"karyawan","id='".$id_spt_ul."'","jabatan");
 app_replace("spt_petugas","'".$idp."', '".$id."', '".$nama."', '".$nip."', '".$gol."', '".$jabatan."', '".$_POST['no']."', '".$_POST['spd']."', '".$id_spt_ul."', '".$_POST['no_spd']."', '".$_POST['no_spd_alp']."'");
 
 $lama=lama(app_baca("spt","id='".$id."'","waktu_mulai"),app_baca("spt","id='".$id."'","waktu_selesai"));
  $harian=db_baca(real_db(),"prov","prov='".app_baca("spt","id='".$id."'","prov")."'","harian");
  $transport=db_baca(real_db(),"kota","kota='".app_baca("spt","id='".$id."'","kota")."'","transport");
  if (strstr(app_baca("spt","id='".$id."'","kota"),"Bekasi")) {
app_replace("spt_realisasi","'".$idp."_harian', '".$idp."', '".$id."', 'harian', '".$lama."', '0', '0', 'tidak_ada', '4', ''"); 
  } else {  app_replace("spt_realisasi","'".$idp."_harian', '".$idp."', '".$id."', 'harian', '".$lama."', '".$harian."', '".kali($harian,$lama)."', 'tidak_ada', '4', ''"); }
 app_replace("spt_realisasi","'".$idp."_transport_lokal', '".$idp."', '".$id."', 'transport_lokal', '1', '".$transport."', '".$transport."', 'tidak_ada', '6', ''");
 
}
if ($_POST and $m=="Akun") {
 app_update("spt","id='".$id."'", "mak='".$_POST['mak']."'");
}

if ($m=="Petugas") {
echo "<form method='post' action=''>
Tugas: <b>".app_baca("spt","id='".$id."'","tujuan")."</b> (".app_baca("spt","id='".$id."'","waktu_mulai")." - ".app_baca("spt","id='".$id."'","waktu_selesai").")<br>
No Urut: <input type='text' name='no' size='1' value=''> <select id='select1' name=nama ><option value=''></option><option></option>".karyawan_opt()."</select> No SPD: <input type='number' name='no_spd' size='5' value=''><input type='text' name='no_spd_alp' size='1' value=''><input type='submit' value='Tambahkan' /> <a href='?t=Edit&id=".$id."'>Selesai</a>
</form>
";
echo spt_petugas_front($id,"");
}

if ($m=="Akun") {
echo "<form method='post' action=''>
Tugas: <b>".app_baca("spt","id='".$id."'","tujuan")."</b> (".app_baca("spt","id='".$id."'","waktu_mulai")." - ".app_baca("spt","id='".$id."'","waktu_selesai").")<br>
Akun:  <select id='select1' name=mak style='width:89%;'>".mak_opt(app_baca("spt","id='".$id."'","tahun"),app_baca("spt","id='".$id."'","mak"))."</select> <input type='submit' value='Gunakan' /> <a href='?t=Edit&id=".$id."'>Selesai</a>
</form>
";
}

if ($m=="") {
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM spt WHERE id = '".$id."' order by id desc";
$results = $db->get_results( $query );
foreach( $results as $data )
{
	
if ($data['tahun']>="2018") {$mak=db_baca("b_realisasi_".$data['tahun'],"pok","no='".$data['mak']."'","mak")." ".db_baca("b_realisasi_".$data['tahun'],"pok","no='".$data['mak']."'","uraian");}
	
echo "
<form method='post' action=''>

<center><b>S U R A T &nbsp; T U G A S</b></br>No: <input type='number' name='no_spt' value='".$data['no_spt']."' style='text-align:right;width:90px;'>/".app_baca("spt_global","name='nomor'","value")."/".substr($data['tgl'],5,2)."/".substr($data['tgl'],0,4)." <a href='print/p_spt.php?id=".$data['id']."' target='_blank'><img src='css/print.png' height='20px'></a>&nbsp;<a href='print/p_spt_lamp.php?id=".$data['id']."' target='_blank'><img src='css/print.png' height='15px'></a></center>
<p align='right'>".$data['print']."</p>
<table width='100%'>
<tr valign='top'><td>1.</td><td style='width:150px;'>Dasar</td><td>:</td><td><textarea name='p1' style='width:99%;height:70px;'>".$data['p1']."</textarea></td></tr>
<tr valign='top'><td>2.</td><td>Ditugaskan kepada</td><td>:</td><td>".spt_petugas_front($data['id'],"")."<a href='?t=Edit&id=".$id."&m=Petugas'><img src='css/edit.png' height='15px'> Ubah</a>
</td></tr>
<tr valign='top'><td>3.</td><td>Tujuan Penugasan</td><td>:</td><td>
<textarea name='tujuan' style='width:99%;height:60px;'>".$data['tujuan']."</textarea>
</td></tr>

<tr valign='top'><td>4.</td><td>Waktu</td><td>:</td><td><input type=date value='".$data['waktu_mulai']."' name=waktu_mulai> sd. <input type=date value='".$data['waktu_selesai']."' name=waktu_selesai> Pukul: <input type=text value='".$data['pukul']."' name=pukul></td></tr>
<tr valign='top'><td></td><td>Lokasi Penugasan</td><td>:</td><td>Dari: <input type='text' name='dari' value='".$data['dari']."' style='width:150px;'> Ke :<br><input type='text' name='lokasi' value='".$data['lokasi']."' style='width:99%;'> Kota : 
<select id='select3' name=kota ><option value='".$data['kota']."'>".$data['kota']."</option><option value=''>=</option>".kota_opt()."</select> 
<input type='text' name='kota2' value='' style='width:150px;'> Provinsi <select id='select4' name=prov ><option value='".$data['prov']."'>".$data['prov']."</option><option></option>".prov_opt()."</select><br>
Angkutan: <select name='angkutan'><option value='".$data['angkutan']."'>".$data['angkutan']."</option><option value='Angkutan Darat'>Angkutan Darat</option><option value='Angkutan Udara'>Angkutan Udara</option><option value='Angkutan Laut'>Angkutan Laut</option></select>
</td></tr>
<tr valign='top'><td>5.</td><td>Pembiayaan</td><td>:</td><td>
<input style='width:98%' value='".$data['dipa']."' name='dipa'><br>
 Tahun Anggaran <input type='text' name='tahun' value='".$data['tahun']."' style='width:40px;'></td></tr>
<tr valign='top'><td></td><td>Mata Anggaran</td><td>:</td><td>".$mak." <a href='?t=Edit&id=".$id."&m=Akun'><img src='css/edit.png' height='15px'> Ubah</a></td></tr> 
 
</table><br>
 Bekasi, <input type=date value='".$data['tgl']."' name=tgl> 
 <select name='kep_jab'>
 <option value='".$data['kep_jab']."'>".$data['kep_jab']."</option>
 <option value='Kepala'>Kepala</option>
 <option value='Plh. Kepala'>Plh. Kepala</option>
 </select>  <select id='select1' name=kep_nama ><option value='".$data['kep_nama']."'>".db_baca(real_db(),"karyawan","id='".$data['kep_nama']."'","nama")."</option><option></option>".karyawan_opt()."</select> PPK: <select id='select2' name=ppk_nama ><option value='".$data['ppk_nama']."'>".db_baca(real_db(),"karyawan","id='".$data['ppk_nama']."'","nama")."</option><option></option>".karyawan_opt()."</select> 
Tgl SPJ: <input type=date value='".$data['tgl_spj']."' name=tgl_spj><br>
 Tembusan:<br>

<textarea name='tembusan' style='width:99%;height:100px;'>".$data['tembusan']."</textarea><br> 
  <input type='hidden' name='id' value='".$data['id']."'> <input type='hidden' name='mak' value='".$data['mak']."'>
 <input type='hidden' name='input_oleh' value='".$data['input_oleh']."'>
  <input type='hidden' name='input_time' value='".$data['input_time']."'>
  <input type='hidden' name='unik' value='".$data['unik']."'>
 <input type='submit' name='submit' value='Simpan' style='width:98%;'>
 </form>
";
}
}
}	
	
}

function waktu($a,$b) {
if ($a==$b) { return "".nama_hari_id($a).", ".tgl_p($a); } elseif (substr ($a, 5, 2)==substr ($b, 5, 2)) {return "".nama_hari_id($a)."-".nama_hari_id($b).", ".substr ($a, 8, 2)."-".tgl_p($b); } else {return "".nama_hari_id($a)."-".nama_hari_id($b).", ".tgl_p($a)." s.d ".tgl_p($b); }
}

function pangkat($gol) {
	return db_baca(real_db(),"gol","gol='".$gol."'","pangkat");
}

