<?php
function no_surat_depan($pizza) {
	$pieces = explode("/", $pizza);
return $pieces[0]."/".$pieces[1];
}

function tugaslist() {
//echo "<h2>PENUGASAN</h2>";

$db = new database();
$db->connect(st_db());
if ($_GET['tab']=="nominatif") { $col="waktu_selesai";} else {$desc="DESC";
	$col="tgl";}
	if ($_POST) {$mm=$_POST['waktu_mulai'];$ss=$_POST['waktu_selesai'];} else {$mm=today();$ss=today(); }
echo "
<form method='post'>Arsip <input type=date name='waktu_mulai' value='".$mm."'> sd <input type=date name='waktu_selesai' value='".$ss."'>  Tugas <input type='text' name='tugas' value='".$_POST['tugas']."'> Kat <select name=kat id='sct1'><option>".$_POST['kat']."</option><option></option><option></option><option>UMUM</option><option>TKH</option><option>TKT</option><option>LEMBUR</option></select> <input type='submit' value='Cari'></form>";

$query = "SELECT * from spt where tujuan like '%".$_POST['tugas']."%' and ".$col."<='".$ss."' and ".$col.">='".$mm."' and kat LIKE '%".$_POST['kat']."%' and mak like '%".$_POST['mak']."%'  order by tgl $desc, id $desc";
$daftar = $db->get_results( $query );

echo "
<table class=table id='dt1' width=100%>
<thead>
<tr style='background:#ddd;'><th>No</th><th>Tugas & Lokasi</th><th>Waktu Pelaksanaan</th><th>No & TGl ST</th><th>Kota</th><th>Lama & Kat</th><th>EXE</th><th width='35%'>Nama Petugas</th><th>nom</th></tr></thead><tbody>
";
$no=1;
foreach((array)$daftar as $data){
	$dob=st_baca("spt","no='".$data['no']."' LIMIT 1,1","id");
//	if($data['kat']=="TKT") {} else {st_update("spt",$data['id'],"kat='UMUM'");}
	if ($dob!="") {$color="red";} else {$color="";}
	$mak=$data['mak'];
if($data['kat']=="LEMBUR") {$lem="<a target='_blank' href='print/p_memo.php?id=".$data['id']."'>Memo</a> <a target='_blank' href='print/p_memo_lamp.php?id=".$data['id']."'>Lamp</a> <a href='inc/memo.php?id=".$data['id']."' target='_blank'>Ed</a>";}	

echo "<tr valign=top style='background:#fff;'><td>$no</td><td><span style='color:$color;'>".$data['tujuan']."</span><hr>
".$data['lokasi']."
</td><td>".tgl($data['waktu_mulai'])."-".tgl($data['waktu_selesai'])."</td><td>".$data['no']."<hr>".tgl($data['tgl'])."</td><td align=center>".$data['kota']."<hr>".$mak."</td>
<td align=center valign='middle'>".lama($data['waktu_mulai'],$data['waktu_selesai'])."<hr>".$data['kat']."</td>
<td><a href='?tab=edit&id=".$data['id']."' target='_blank'>Edit</a> <a target='_blank' href='print/p_spt.php?id=".$data['id']."'>Print</a> <a target='_blank' href='print/p_lap.php?id=".$data['id']."'>Lap</a> <a href='inc/form_lap_nice.php?id=".$data['id']."' target='_blank'>Edit Lap</a></td><td>";
petugaslist_front($data['id']);
//echo "<a href='form_petugas.php?id=".$data['id']."' target='_blank'>Edit</a>";

echo "</td>
<td>".$data['nom_id']."</td>
</tr>";
$mak=$data['mak'];
if ($data['tahun']=="2018") {
//$mak=rq_18_baca("pok","no='$mak'","mak");
}
$no++;
}
echo "<tbody></table>";
}


function petugaslist_front($id_spt) {
$db = new database();
$db->connect(st_db());
$query = "SELECT * from spt_petugas where id_spt='$id_spt' order by no";
$daftar = $db->get_results( $query );
echo "
<table  cellpadding='1' cellspacing='0' border=0>

";
$no=1;
//$tgl=spt_;
foreach((array)$daftar as $data){
	
	
$id=$data['id'];
if ($data['spd']!="DALAM KOTA") {$pri="<a href='print/p_spd1.php?id_spt=$id_spt&id=$id' target='_blank'>SPD-1</a> SPD-2(<a href='print/p_spd2.php?id_spt=$id_spt&id=$id' target='_blank'>A4</a> <a href='print/p_spd2b.php?id_spt=$id_spt&id=$id' target='_blank'>F4</a> <a href='print/p_spd2x.php?id_spt=$id_spt&id=$id' target='_blank'>AL</a>) &nbsp; <a href='print/p_kw.php?id_spt=$id_spt&id=$id' target='_blank'>Kwt</a> <a href='print/p_rincian.php?id_spt=$id_spt&id=$id' target='_blank'>Rinc</a> <a href='print/p_riil.php?id_spt=$id_spt&id=$id' target='_blank'>Riil</a>";$sp=$data['no_spd']."".$data['no_spd_alp']."/".$data['spd'];} else {$pri="<a href='print/p_kw.php?id_spt=$id_spt&id=$id' target='_blank'>Kwt</a>";$sp=$data['spd'];}
echo "<tr valign=top><td>".$no."</td><td>".$data['nama']."</td><td>".rp(total_petugas($data['id']))."</td><td>".$pri."
</td><td>".$sp."</td>
</tr>";
$no++;
}
echo "</table>";
}

function total_petugas($id) {
$db = new database();
$db->connect(st_db());
$query = "SELECT total from realisasi where id_petugas='$id'";
$daftar = $db->get_results( $query );
foreach((array)$daftar as $data){
//echo $data['total']."<br>";
$rp+=$data['total'];
}
return $rp;
}

function petugaslist($id) {
$db=new database();
$db->st_konek();
$daftar=$db->tampil("SELECT * from spt_petugas where id_spt='$id' order by no");
//echo time();
//echo " ".date("Ymdhis").microtime(true);
echo "
<table  cellpadding='7' cellspacing='0'>
<tr><th>No</th><th>Nama</th></tr>
";
$no=1;
foreach((array)$daftar as $data){
echo "<tr valign=top><td>".$data['no']."</td><td>".$data['nama']."</td></tr>";
$no++;
}
echo "</table>";
}

function petugaslist_depan($id_spt,$print) {
$db = new database();
$db->connect(st_db());
$query = "SELECT * from spt_petugas where id_spt='$id_spt' order by no";
$daftar = $db->get_results( $query );
$j=st_jml("spt_petugas","id_spt='$id_spt'");
$no=1;
foreach((array)$daftar as $data){
if ($print=="no") {$spd="<a href='p_spd1.php?id_spt=$id_spt&id=".$data['id']."' target='_blank'>SPD(1)</a> <a href='p_spd2.php?id_spt=$id_spt&id=".$data['id']."' target='_blank'>SPD(2)</a> <a href='p_spd2b.php?id_spt=$id_spt&id=".$data['id']."' target='_blank'>SPD(2)f</a>";} else {$spd="";} 
if ($print=="sab") { $n=$no;}
if ($print=="ikt") { echo "$no. ".$data['nama']."/".$data['nip']."<br>"; } elseif ($print=="rb") {
if ($no==1) {$kepada="Kepada"; $sa=":";} else {$kepada="";$sa="";}
if ($j==1) {$nn="";} else {$nn=$no.".";}
echo "
<tr valign='top' class=petugas><td>$kepada</td><td>$sa</td><td>$nn</td> <td>Nama/NIP</td><td>:</td><td>".$data['nama']."/".$data['nip']." $spd</td></tr>

<tr valign='top' class=petugas><td></td><td></td><td></td><td>Pangkat/Gol.Ruang</td><td>:</td><td>".pangkat($data['gol'])."/".$data['gol']."</td></tr>
<tr valign='top' class=petugas><td></td><td></td><td></td><td>Jabatan</td><td>:</td><td>".$data['jab']."</td></tr>

";
} else {
echo "
<tr valign='top' class=petugas><td>$n</td><td>Nama/NIP</td><td>:</td><td>".$data['nama']."/".$data['nip']." $spd</td></tr>
<tr valign='top' class=petugas><td></td><td>Pangkat/Gol.Ruang</td><td>:</td><td>".pangkat($data['gol'])."/".$data['gol']."</td></tr>
<tr valign='top' class=petugas><td></td><td>Jabatan</td><td>:</td><td>".$data['jab']."</td></tr>
<tr height='10px'><td colspan='4'></td></tr>
";
}
$no++;
}
}

function waktu($a,$b) {
if ($a==$b) { return "".nama_hari_id($a).", ".tgl_p($a); } elseif (substr ($a, 5, 2)==substr ($b, 5, 2)) {return "".nama_hari_id($a)."-".nama_hari_id($b).", ".substr ($a, 8, 2)."-".tgl_p($b); } else {return "".nama_hari_id($a)."-".nama_hari_id($b).", ".tgl_p($a)." s.d ".tgl_p($b); }
}

function pada($a,$b) {
if ($a==$b) { return "".tgl_p($a); } elseif (substr ($a, 5, 2)==substr ($b, 5, 2)) {return "".substr ($a, 8, 2)."-".tgl_p($b); } else {return "".tgl_p($a)." s.d ".tgl_p($b); }
}


function kep_nama_opt($kep_nama) {
$db=new database();
$db->st_konek();
$daftar=$db->tampil("SELECT * from kepala order by kep_nama");
echo "<select name='kep_nama'><option value='$kep_nama'>$kep_nama</option>";
$no=1;
foreach((array)$daftar as $data){
echo "<option value='".$data['kep_nama']."'>".$data['kep_nama']."</option>";
$no++;
}
echo "</select>";
}

function item($item,$kota,$jumlah,$nilai,$dari) {
if (strstr($item,"transport_lokal")) {$p="Angkutan dari tempat kedudukan ke tempat tujuan : ".$dari." - ".$kota." (PP) dengan angkutan darat";} 
if (strstr($item,"transport_darat")) {$p="Angkutan dari tempat kedudukan ke tempat tujuan : ".$dari." - ".$kota." (PP) dengan angkutan darat";} 
elseif (strstr($item,"transport_udara")) {$p="Angkutan dari tempat kedudukan ke tempat tujuan : ".$dari." - ".$kota." (PP) dengan pesawat udara";} 
elseif (strstr($item,"penginapan")) {$p="Biaya Penginapan : $jumlah Malam di $kota: $jumlah Malam @ Rp. ".rp($nilai).",-";} 
elseif (strstr($item,"harian")) {$p=" Uang harian : $jumlah hari di $kota: $jumlah hari @ Rp. ".rp($nilai).",-";} 
elseif (strstr($item,"representasi")) {$p=" Uang Representasi : $jumlah hari di $kota: $jumlah hari @ Rp. ".rp($nilai).",-";} 
return $p;
}


function tugasmenu($ta) {
echo "<form>TA : <select name='ta' onchange='if(this.value != 0) { this.form.submit(); }'><option value='$ta'>$ta</option><option value='2015'>2015</option><option value='2016'>2016</option></select>
<input type='hidden' name='m' value='kegiatan'>
 | Master data: <a href='?ta=$ta&m=dipa'>DIPA</a> <a href='?ta=$ta&m=kegiatan'>Kegiatan</a>  <a href='?ta=$ta&m=petugas'>Petugas</a></form>";
}

function konten($ta,$m) {
if ($m=="dipa") {dipa($ta);}
if ($m=="kegiatan" or $m=="") {kegiatan($ta);}
if ($m=="detail_kegiatan") {detail_kegiatan($_GET['id']);}
}

function dipa($ta) {
echo "<h2>DIPA TA $ta</h2>";

if ($_POST) {
replace_tugasdb("dipa","'$ta','".$_POST['no_dipa']."','".$_POST['tgl']."'");
echo "Tersimpan";
}
$no_dipa=baca_tugasdb("dipa","ta='$ta'","no_dipa");
$tgl=baca_tugasdb("dipa","ta='$ta'","tgl");
echo "<form action='' method=post>NO DIPA: <input type=input name='no_dipa' value='$no_dipa' style='width:300px;'> TGL: ".tglpilih("tgl","$tgl")." <input type=submit value='Simpan'></form>";
}




function kegiatan($ta) {
$d=$_GET['d'];
$id=$_GET['id'];
echo "<h2>KEGIATAN TA $ta</h2>";
if ($_POST) {
if ($id=="") {

tambah_tugasdb("kegiatan","'','$ta','".$_POST['nama_keg']."','".$_POST['mak']."','".$_POST['sk']."'");

} else {
replace_tugasdb("kegiatan","'$id','$ta','".$_POST['nama_keg']."','".$_POST['mak']."','".$_POST['sk']."'");
}
} else {

if ($d=="edit") {
$nama_keg=baca_tugasdb("kegiatan","id='$id'","nama_keg");
$mak=baca_tugasdb("kegiatan","id='$id'","mak");
$sk=baca_tugasdb("kegiatan","id='$id'","sk");
echo "<form action='' method=post>Nama Kegiatan: <input type=input name='nama_keg' value='$nama_keg' style='width:500px;'><br>
MAK: <input type=input name='mak' value='$mak' style='width:200px;'><br> Dasar SK / Surat: <input type=input name='sk' value='$sk' style='width:500px;'><br>
<input type=submit value='Simpan'></form>";
}

}

//replace_tugasdb("dipa","'$ta','".$_POST['no_dipa']."','".$_POST['tgl']."'");
//echo "Tersimpan";
//$nama_keg=baca_tugasdb("keg","nama_keg='$nama_keg'","no_dipa");
//$tgl=baca_tugasdb("keg","ta='$ta'","tgl");



$db=new database();
$db->st_konek();
$daftar=$db->tampil("SELECT * from kegiatan where ta='$ta' order by nama_keg");
//echo time();
//echo " ".date("Ymdhis").microtime(true);
echo "
<a href='?ta=$ta&m=kegiatan&d=edit'>New</a><table  cellpadding='7' cellspacing='0'>
<tr><th>NO</th><th>Nama Kegiatan</th><th>MAK</th><th>DASAR</th><th></th><th></th></tr>
";
$no=1;
foreach((array)$daftar as $data){
echo "<tr><td>$no</td><td>".$data['nama_keg']."</td><td>".$data['mak']."</td><td>".$data['sk']."</td><td><a href='?ta=$ta&m=kegiatan&d=edit&id=".$data['id']."'>Edit</a></td><td><a href='?ta=$ta&m=detail_kegiatan&d=edit&id=".$data['id']."'>Detail Kegiatan</a></td></tr>";
$no++;
}
echo "</table>";
}

function detail_kegiatan_petugas($id) {
$db=new database();
$db->ul_konek();

echo "<table  cellpadding='7' cellspacing='0'><tr><td></td><td>
<form action='' method=post>
                <div class='input_container'>
                    <input type='text' id='country_id' onkeyup='autocomplet()' name='negara'>
                    <ul id='country_list_id'></ul>
                </div>
            
</td><td><input type=submit value='Tambahkan'></td></tr></form>";

$daftar=$db->tampilDataWhere("petugas","nip!='' order by nama_petugas");
$no=1;
foreach((array)$daftar as $data){
$j=jumlah_row_tugasdb("petugas","id_keg='$id' and nip='".$data[nip]."'");
if ($j>0) {
echo "<tr><td>$no</td><td>".$data[nama_petugas]."</td><td>".$data[nip]."</td></tr>";
$no++; }
}
echo "</table>";
}



function detail_kegiatan($id) {
echo "<h2>DETAIL KEGIATAN</h2>
<table  cellpadding='7' cellspacing='0'>
<tr><td>ID</td><td><b>$id</b></td></tr>
<tr><td>Nama Kegiatan</td><td><b>".baca_tugasdb("kegiatan","id='$id'","nama_keg")."</b></td></tr>
<tr><td>MAK </td><td><b>".baca_tugasdb("kegiatan","id='$id'","mak")."</td></tr>
<tr><td>TA </td><td><b>".baca_tugasdb("kegiatan","id='$id'","ta")."</td></tr>
<tr><td>DIPA </td><td><b>".baca_tugasdb("dipa","ta='".baca_tugasdb("kegiatan","id='$id'","ta")."'","no_dipa")."</td></tr>
<tr><td>Dasar / SK </td><td><b>".baca_tugasdb("kegiatan","id='$id'","sk")."</td></tr>
</table>
<br>
<b>PETUGAS/PEGAWAI YANG DILIBATKAN:</b>
";
detail_kegiatan_petugas($id);

}

function nominatif($th) {
	$db=new database();

echo "<form method='post'>
Periode: ".tglpilih("waktu_mulai",$_POST['waktu_mulai'],"waktu_mulai")." sd ".tglpilih("waktu_selesai",$_POST['waktu_selesai'],"waktu_selesai")." 
MAK: <select name=mak onchange='if(this.value != 0) { this.form.submit(); }'>";
$id=$mak=$_POST['mak'];

if ($th=="2018") {
		echo "<option value='".$id."'>".rq_18_baca("pok","no='$id'","mak")." :  : ".rq_18_baca("pok","no='$id'","uraian")."</option>";
	$db->rq_18_konek();$daftar=$db->tampil("SELECT * from pok where sat='OP' or sat='OK' order by mak");$v="no";} else {
	echo "<option value='".$id."'>".st_baca("mak","mak='$id'","mak")." : ".st_baca("mak","mak='$id'","tahun")." : ".st_baca("mak","mak='$id'","uraian")."</option>";
	$db->st_konek();$daftar=$db->tampilDataAsc("mak","mak");$v="mak";}

foreach((array)$daftar as $data){
echo "<option value='".$data[$v]."'>".$data['mak']." : ".$data['tahun']." : ".rp($data['jumlah'])." : ".$data['uraian']."</option>";	
}
	echo "</select><select name='ttd'><option value='".$_POST['ttd']."'>".$_POST['ttd']."</option><option value='view'>view</option><option value='hide'>hide</option></select>
 <input type='submit' name='submit' value='Go..'>

	";
$db->st_konek();	
$daftar=$db->tampil("SELECT id FROM spt WHERE mak='$mak' and waktu_selesai>='".$_POST['waktu_mulai']."' and waktu_selesai<='".$_POST['waktu_selesai']."'");
foreach((array)$daftar as $data){
$j=st_jml("spt_petugas","id_spt='".$data['id']."'");
$jml+=$j;
$s+=1;
}	
echo "<br>Jumlah Penugasan: ".$s."<br>Jumlah Pegawai: ".$jml."<br>
Print Halaman: ";
$h=keatas($jml/10);
while ($t<=$h) {
echo "<a href='inc/nom.php?mak=$mak&h=$t&ht=$h&m=".$_POST['waktu_mulai']."&a=".$_POST['waktu_selesai']."&ttd=".$_POST['ttd']."' target='_blank'>$t</a> ";	
$t+=1;
}
echo " <a href='inc/nom_all.php?mak=$mak&h=$t&ht=$h&m=".$_POST['waktu_mulai']."&a=".$_POST['waktu_selesai']."&ttd=".$_POST['ttd']."&by=nama&by2=waktu_selesai' target='_blank'>All by Nama</a> <a href='inc/nom_all.php?mak=$mak&h=$t&ht=$h&m=".$_POST['waktu_mulai']."&a=".$_POST['waktu_selesai']."&ttd=".$_POST['ttd']."&by2=nama&by=waktu_selesai' target='_blank'>All by Tgl</a>
</form>";

}



function nominatif_spj($th) {
	$db=new database();
echo "<form method='post'>
Periode: ".tglpilih("waktu_mulai",$_POST['waktu_mulai'],"waktu_mulai")." sd ".tglpilih("waktu_selesai",$_POST['waktu_selesai'],"waktu_selesai")." 
MAK: <select name=mak onchange='if(this.value != 0) { this.form.submit(); }'>";
$id=$mak=$_POST['mak'];

if ($th=="2018") {
		echo "<option value='".$id."'>".rq_18_baca("pok","no='$id'","mak")." :  : ".rq_18_baca("pok","no='$id'","uraian")."</option>";
	$db->rq_18_konek();$daftar=$db->tampil("SELECT * from pok where sat='OP' or sat='OK' order by mak");$v="no";} else {
	echo "<option value='".$id."'>".st_baca("mak","mak='$id'","mak")." : ".st_baca("mak","mak='$id'","tahun")." : ".st_baca("mak","mak='$id'","uraian")."</option>";
	$db->st_konek();$daftar=$db->tampilDataAsc("mak","mak");$v="mak";}
foreach((array)$daftar as $data){
echo "<option value='".$data[$v]."'>".$data['mak']." : ".$data['tahun']." : ".rp($data['jumlah'])." : ".$data['uraian']."</option>";		
}
	echo "</select><select name='ttd'><option value='".$_POST['ttd']."'>".$_POST['ttd']."</option><option value='view'>view</option><option value='hide'>hide</option></select>
 <input type='submit' name='submit' value='Go..'>

	";
$db->st_konek();	
$daftar=$db->tampil("SELECT id FROM spt WHERE mak='$mak' and tgl_spj>='".$_POST['waktu_mulai']."' and tgl_spj<='".$_POST['waktu_selesai']."'");
foreach((array)$daftar as $data){
$j=st_jml("spt_petugas","id_spt='".$data['id']."'");
$jml+=$j;
$s+=1;
}	
echo "<br>Jumlah Penugasan: ".$s."<br>Jumlah Pegawai: ".$jml."<br>
Print Halaman: ";
$h=keatas($jml/10);
while ($t<=$h) {
	if ($t=="1") {echo "<a href='inc/nom_spj_xls.php?mak=$mak&h=$t&ht=$h&m=".$_POST['waktu_mulai']."&a=".$_POST['waktu_selesai']."&ttd=".$_POST['ttd']."' target='_blank'>All</a> ";}
echo "<a href='inc/nom_spj.php?mak=$mak&h=$t&ht=$h&m=".$_POST['waktu_mulai']."&a=".$_POST['waktu_selesai']."&ttd=".$_POST['ttd']."' target='_blank'>$t</a> ";	
$t+=1;
}

//echo " <a href='inc/nom_all.php?mak=$mak&h=$t&ht=$h&m=".$_POST['waktu_mulai']."&a=".$_POST['waktu_selesai']."&ttd=".$_POST['ttd']."&by=nama&by2=waktu_selesai' target='_blank'>All by Nama</a> <a href='inc/nom_all.php?mak=$mak&h=$t&ht=$h&m=".$_POST['waktu_mulai']."&a=".$_POST['waktu_selesai']."&ttd=".$_POST['ttd']."&by2=nama&by=waktu_selesai' target='_blank'>All by Tgl</a>";
echo "</form>";

}


function rekap_absen() {

echo "<form method='post'>
Periode: ".tglpilih("waktu_mulai",$_POST['waktu_mulai'],"waktu_mulai")." sd ".tglpilih("waktu_selesai",$_POST['waktu_selesai'],"waktu_selesai")." 
Nama: <input id=\"karyawan_autocomplete\" name='kepada' style='width:200px;' value='".$_POST['kepada']."'>
 <input type='submit' name='submit' value='Go..'></form><br><br>
<table><tr><th>NO</th><th>NAMA</th><th>TGL SPT</th><th>TGL MULAI</th><th>TGL SELESAI</th><th>KOTA</th><th>TUGAS</th><th>ALAMAT</th><th></th><th></th></tr>
	";
$nip=ul_baca("karyawan","nama='".$_POST['kepada']."'","nip");
	$db=new database();
$db->st_konek();
$daftar=$db->tampil("SELECT spt.id,spt.waktu_mulai,spt.waktu_selesai,spt.kota,spt.tujuan,spt.lokasi,spt_petugas.nama,spt.tgl FROM spt join spt_petugas ON spt.id=spt_petugas.id_spt WHERE (( spt.waktu_mulai>='".$_POST['waktu_mulai']."' and spt.waktu_mulai<='".$_POST['waktu_selesai']."') or  ( spt.waktu_selesai>='".$_POST['waktu_mulai']."' and spt.waktu_selesai<='".$_POST['waktu_selesai']."')) and nip='".$nip."' order by spt.waktu_mulai limit 0,100");
foreach((array)$daftar as $data){
$j=st_jml("spt_petugas","id_spt='".$data['id']."'");
$s+=1;
echo "<tr><td>".$s."</td><td>".$data['nama']."</td><td>".tgl($data['tgl'])."</td><td>".tgl($data['waktu_mulai'])."</td><td>".tgl($data['waktu_selesai'])."</td><td>".$data['kota']."</td><td>".$data['tujuan']."</td><td>".$data['lokasi']."</td><td><a target='_blank' href='?tab=edit&id=".$data['id']."'>Edit SPT</a></td><td>".$data['nom_id']."</td></tr>";
}	
echo "</table></form>";
}


function spt_option_kota($kota) {
$db=new database();
$db->ops_konek();

$datanya.="<select name='kota'><option value='".$kota."'>$kota</option><option value=''>=</option>";

$daftar=$db->tampilDataWhere("tarif","kode_tarif LIKE 'C1B%' order by uraian");
$no=1;
foreach((array)$daftar as $data){
$datanya.="<option value='".$data['uraian']."'>".$data['uraian']."</option>";	
}
return $datanya;
}

function next_alp($a) {
if ($a=="z") {$p="";}
if ($a=="y") {$p="z";}
if ($a=="x") {$p="y";}
if ($a=="w") {$p="x";}
if ($a=="v") {$p="w";}
if ($a=="u") {$p="v";}
if ($a=="t") {$p="u";}
if ($a=="s") {$p="t";}
if ($a=="r") {$p="s";}
if ($a=="q") {$p="r";}
if ($a=="p") {$p="q";}
if ($a=="o") {$p="p";}
if ($a=="n") {$p="o";}
if ($a=="m") {$p="n";}
if ($a=="l") {$p="m";}
if ($a=="k") {$p="l";}
if ($a=="j") {$p="k";}
if ($a=="i") {$p="j";}
if ($a=="h") {$p="i";}
if ($a=="g") {$p="h";}
if ($a=="f") {$p="g";}
if ($a=="e") {$p="f";}
if ($a=="d") {$p="e";}
if ($a=="c") {$p="d";}
if ($a=="b") {$p="c";}
if ($a=="a") {$p="b";}
if ($a=="") {$p="a";}
return $p;	
}

function rekap_user($nip) {

echo "
<style>
.tugas {font-size:11px;}
</style>
	<div id='tengah'><b style='color:#333;'>
PENUGASAN</b><br><table class=tugas>";
	$db=new database();
$db->st_konek();
$daftar=$db->tampil("SELECT spt.id,spt.waktu_mulai,spt.waktu_selesai,spt.kota,spt.tujuan,spt.lokasi,spt_petugas.nama,spt.tgl FROM spt join spt_petugas ON spt.id=spt_petugas.id_spt WHERE nip='".$nip."' order by spt.waktu_mulai desc limit 0,100");
foreach((array)$daftar as $data){
$j=st_jml("spt_petugas","id_spt='".$data['id']."'");
$s+=1;
echo "<tr valign=top><td>".tgl($data['tgl'])."<br>".tgl($data['waktu_mulai'])." - ".tgl($data['waktu_selesai'])."<br>".$data['kota']."</td><td>".$data['tujuan']."</td><td>".$data['lokasi']."</td><td><a target='_blank' href='app/tugas/inc/form_lap_nice.php?id=".$data['id']."'>Edit</a> <a target='_blank' href='app/tugas/print/p_lap.php?id=".$data['id']."'>Print</a></td></tr>";
}	
echo "</table></div>";
}


function realisasi_mak_spt($th,$mak) {
	$db=new database();
$db->st_konek();
$daftar=$db->tampil("SELECT spt_petugas.id from spt join spt_petugas on spt.id=spt_petugas.id_spt WHERE spt.mak='$mak' and spt.tahun='$th'");
foreach((array)$daftar as $data){
$total+=biayanya($data['id']);
}
return $total;
}

function realisasi_mak() {
	$db=new database();
$db->st_konek();
$sc = explode(" ", $_POST['uraian']);
$daftar=$db->tampil("SELECT * from mak where tahun='".$_POST['tahun']."' and uraian LIKE '%".$sc[0]."%' and uraian LIKE '%".$sc[1]."%' and uraian LIKE '%".$sc[2]."%' and uraian LIKE '%".$sc[3]."%' and uraian LIKE '%".$sc[4]."%' and uraian LIKE '%".$sc[5]."%' order by mak");
echo "<form method='post' action=''> Tahun <input type='text' name='tahun' value='".date("Y")."'> Uraian  <input type='text' name='uraian' value='".$_POST['uraian']."'>
<input type='hidden' name='mak' value=''>
<input type='submit' name='submit' value='Cari'>
 </form><table><tr><th>TA</th><th>MAK</th><th>URAIAN</th><th>SATUAN</th><th>PAGU</th><th>REALISASI</th><th>SISA</th><th>%</th></tr>";
foreach((array)$daftar as $data){
	
	$real=realisasi_mak_spt($data['tahun'],$data['mak']);
echo "<tr valign=top><td>".$data['tahun']."</td><td>".$data['mak']."</td><td>".$data['uraian']."</td><td align=right>".rp($data['harga_satuan'])."</td><td align=right>".rp($data['pagu'])."</td><td align=right>".rp($real)."</td><td align=right>".rp($data['pagu']-$real)."</td><td align=right>".des(($real/$data['pagu'])*100)."</td></tr>";

}
	
echo "</table>";	
}

function biayanya($id_p){

	$db=new database();
$db->st_konek();
$daftar2=$db->tampil("SELECT * from realisasi WHERE id_petugas='$id_p'");
foreach((array)$daftar2 as $data2){
	$total+=$data2['total'];
}	
	return $total;
}


function rekap_absen_baca() {


echo "<h2>REALISASI PENUGASAN PEGAWAI / KARYAWAN </h2><form method='post'>
Periode: <input type=date name='waktu_mulai' value='".$_POST['waktu_mulai']."'> sd <input type=date name='waktu_selesai' value='".$_POST['waktu_selesai']."'> 
Nama: <input id=\"karyawan_autocomplete\" name='kepada' style='width:200px;' value='".$_POST['kepada']."'>
 <input type='submit' name='submit' value='Go..'><br><br>
 <h2>".ul_baca("karyawan","nama='".$_POST['kepada']."'","nama")."</h2>
<table id='horis'><tr>
<th rowspan=2>NO</th><th rowspan=2>NAMA</th><th rowspan=2>TGL SPT</th><th colspan=3>LUAR KOTA</th><th colspan=3>DALAM KOTA</th><th rowspan=2>TUGAS</th><th rowspan=2>LOKASI</th><th rowspan=2>PRINT</th><th rowspan=2>PRINT</th><th rowspan=2></th></tr>
<tr>
<th>TGL MULAI</th><th>TGL SELESAI</th><th>KOTA</th><th>TGL MULAI</th><th>TGL SELESAI</th><th>KOTA</th></tr>
	";
$id_user=ul_baca("karyawan","nama='".$_POST['kepada']."'","id");
	$db=new database();
$db->st_konek();
$daftar=$db->tampil("SELECT spt_petugas.spd,spt_petugas.id,spt_petugas.id_spt,spt.waktu_mulai,spt.waktu_selesai,spt.kota,spt.tujuan,spt.lokasi,spt_petugas.nama,spt.tgl,spt.nom_id FROM spt join spt_petugas ON spt.id=spt_petugas.id_spt WHERE (( spt.waktu_mulai>='".$_POST['waktu_mulai']."' and spt.waktu_mulai<='".$_POST['waktu_selesai']."') or  ( spt.waktu_selesai>='".$_POST['waktu_mulai']."' and spt.waktu_selesai<='".$_POST['waktu_selesai']."')) and id_user='".$id_user."' order by spt.waktu_mulai limit 0,100");
foreach((array)$daftar as $data){
$j=st_jml("spt_petugas","id_spt='".$data['id']."'");
$s+=1;

if ($data['spd']!="DALAM KOTA") {$pri="<a href='print/p_spd1.php?id_spt=".$data['id_spt']."&id=".$data['id']."' target='_blank'>SPD-1</a>SPD-2(<a href='print/p_spd2.php?id_spt=".$data['id_spt']."&id=".$data['id']."' target='_blank'>A4</a>&nbsp;<a href='print/p_spd2b.php?id_spt=".$data['id_spt']."&id=".$data['id']."' target='_blank'>F4</a>&nbsp;<a href='print/p_spd2x.php?id_spt=".$data['id_spt']."&id=".$data['id']."' target='_blank'>AL</a>)&nbsp;<a href='print/p_kw.php?id_spt=".$data['id_spt']."&id=".$data['id']."' target='_blank'>Kwt</a>&nbsp;<a href='print/p_rincian.php?id_spt=".$data['id_spt']."&id=".$data['id']."' target='_blank'>Rinc</a>&nbsp;<a href='print/p_riil.php?id_spt=".$data['id_spt']."&id=".$data['id']."' target='_blank'>Riil</a>";} else {$pri="<a href='print/p_kw.php?id_spt=".$data['id_spt']."&id=".$data['id']."' target='_blank'>Kwt</a>";}


echo "<tr><td>".$s."</td><td>".$data['nama']."</td><td align=center>".tgl($data['tgl'])."</td>";
$dtn="<td align=center>".tgl_aja($data['waktu_mulai'])."</td><td align=center>".tgl_aja($data['waktu_selesai'])."</td><td align=center>".$data['kota']."</td>";
if (strstr($data['kota'],"Jakarta")) {
echo "<td></td><td></td><td></td>".$dtn;	
} else {echo $dtn."<td></td><td></td><td></td>";}

echo "<td>".$data['tujuan']."</td><td>".$data['lokasi']."</td><td><a target='_blank' href='print/p_spt.php?id=".$data['id_spt']."'>ST</a>&nbsp;<a target='_blank' href='print/p_lap.php?id=".$data['id_spt']."'>Lap</a> <a href='inc/form_lap_nice.php?id=".$data['id_spt']."' target='_blank'>EdLap</a></td><td>".$pri."</td><td>".$data['nom_id']."</td></tr>";
}	
echo "</table></form>";
}
