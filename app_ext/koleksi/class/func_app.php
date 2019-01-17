<?php

function user_id() {
return $_SESSION['user_id'];
}

function arsip($b) {
if ($_GET['l']=="") {$l=20;} else {$l=$_GET['l'];}
echo "
<form method='GET'>
<div class='h2'>Arsip Koleksi <span class='limit'>Limit: <select name='l' onchange='this.form.submit();'>
<option value='".$l."'>".$l."</option>  
<option value='20'>20</option>   
<option value='50'>50</option>   
<option value='100'>100</option>                
<option value='500'>500</option>                
<option value='1000'>1.000</option>                
<option value='5000'>5.000</option>                
<option value='10000'>10.000</option>                 
<option value='20000'>20.000</option>                
</select></span>
</div>
</form>
<table class='table' id='dt1'>
<thead>
<tr><th>NO</th><th>TGL KOLEKSI</th><th>NO REGISTRASI</th><th>INANG</th><th>SUMBER</th><th>LOKASI</th><th>KOLEKTOR</th><th>JENIS</th><th></th><th></th></tr>
</thead><tbody>";
$db = new database();
$db->connect(app_db());

$query = "SELECT * FROM koleksi WHERE id>0 and bidang='".$b."' order by tgl_koleksi desc,id desc limit 0,".$l."";
$results = $db->get_results( $query );
foreach( $results as $data) {
$nrk1="000000".$data['nrk'];
$m=strlen($nrk1)-6;
$nrkp=substr ($nrk1, $m, 6);
$no++;
echo "<tr><td>".$no."</td><td>".$data['tgl_koleksi']."</td><td>".$data['kd'].$nrkp.substr($data['jenis_kel'], 0, 2).".".$data['bidang']."</td><td>".$data['inang']."</td><td>".$data['sumber']."</td><td>".$data['lokasi']."</td><td>".$data['kolektor']."</td><td>".$data['jenis_ordo']." - ".$data['jenis_fam']." - ".$data['jenis_spes']."<br></td><td><a target='_blank' href='?func=form&tab=edit&id=".$data['id']."'>Edit</a></td><td><a target='_blank' href='print/print.php?id=".$data['id']."'>Print</a></td></tr>";
}
}

function karyawan_option($k) {
$dt.="<option value='$k'>$k</option><option value=''></option>";
$db = new database();
$db->connect("user_login");
$query = "SELECT nama FROM karyawan order by nama";
$results = $db->get_results( $query );
foreach( $results as $data) {
$dt.="<option value='".$data['nama']."'>".$data['nama']."</option>";
}
$dt.="";
return $dt;
}


function table_option($name,$table,$k,$sl) {
$dt.="<select name='$name' id='sl".$sl."'><option value='$k'>$k</option><option value=''></option>";
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM ".$table." WHERE kode!='' order by kode";
$results = $db->get_results( $query );
foreach( $results as $data) {
$dt.="<option value='".$data['kode']."'>".$data['kode']."</option>";
}
$dt.="</select>";
return $dt;
}

function koleksi_foto_thumb($id) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM koleksi_foto WHERE file LIKE '".$id."_%'";
$results = $db->get_results( $query );
foreach( $results as $data) {
$dt.="<img src='../../class/thumb.php?size=100&src=../app/koleksi/foto/".$data['file']."' style='float:left;margin:0 10px 5px 0;'>";	
}
return $dt;
}

function form() {

$tab=$_GET['tab'];
$bidang=$_GET['b'];
$id=$_GET['id'];
$user=db_baca("user_login","karyawan","id='".user_id()."'","nama");
if ($_POST) {
if ($tab=="new") {
$kd=strtoupper(substr ($_POST['jenis_ordo'], 0, 4));
$nrk=app_baca("koleksi","kd='".$kd."' and bidang='".$bidang."' order by nrk desc","nrk")+1;
app_tambah("koleksi","'', '".$_POST['tahun']."', '".$bidang."', '".$nrk."', '".$kd."', '".$_POST['inang']."', '".$_POST['lokasi']."', '".$_POST['gps_ns_a']."', '".$_POST['gps_ns_b']."', '".$_POST['gps_ns_c']."', '".$_POST['gps_ns']."', '".$_POST['gps_we_a']."', '".$_POST['gps_we_b']."', '".$_POST['gps_we_c']."', '".$_POST['gps_we']."', '".$_POST['sumber']."', '".$_POST['tgl_koleksi']."', '".$_POST['kolektor']."', '".$_POST['pengumpulan']."', '".$_POST['jenis_kel']."', '".$_POST['jenis_subs']."', '".$_POST['jenis_spes']."', '".$_POST['jenis_fam']."', '".$_POST['jenis_ordo']."', '".$_POST['status']."', '".$_POST['ref']."', '".$_POST['gender']."', '".$_POST['stadia']."', '".$_POST['mounting']."', '".$_POST['jumlah_spesimen']."', '".$_POST['tgl_ident']."', '".$_POST['ident_oleh']."', '".$_POST['foto']."', '".$_POST['lokasi_simpan']."', '".$_POST['ket']."', '".$_POST['kode_pemilik']."', '".$user."', '".now()."', '', ''");
$idn=app_baca("koleksi","tahun='".$_POST['tahun']."' and bidang='".$bidang."' and nrk='".$nrk."'","id");
	echo now()." Tersimpan<meta http-equiv=\"refresh\" content=\"1; URL=?func=form&tab=edit&id=".$idn."\">";
} elseif ($tab=="edit") {
app_replace("koleksi","'$id', '".$_POST['tahun']."', '".$_POST['bidang']."', '".$_POST['nrk']."', '".$_POST['kd']."', '".$_POST['inang']."', '".$_POST['lokasi']."', '".$_POST['gps_ns_a']."', '".$_POST['gps_ns_b']."', '".$_POST['gps_ns_c']."', '".$_POST['gps_ns']."', '".$_POST['gps_we_a']."', '".$_POST['gps_we_b']."', '".$_POST['gps_we_c']."', '".$_POST['gps_we']."', '".$_POST['sumber']."', '".$_POST['tgl_koleksi']."', '".$_POST['kolektor']."', '".$_POST['pengumpulan']."', '".$_POST['jenis_kel']."', '".$_POST['jenis_subs']."', '".$_POST['jenis_spes']."', '".$_POST['jenis_fam']."', '".$_POST['jenis_ordo']."', '".$_POST['status']."', '".$_POST['ref']."', '".$_POST['gender']."', '".$_POST['stadia']."', '".$_POST['mounting']."', '".$_POST['jumlah_spesimen']."', '".$_POST['tgl_ident']."', '".$_POST['ident_oleh']."', '".$_POST['foto']."', '".$_POST['lokasi_simpan']."', '".$_POST['ket']."', '".$_POST['kode_pemilik']."', '".$_POST['entri_oleh']."', '".now()."', '".$user."', '".now()."'");
//echo now()." Tersimpan<meta http-equiv=\"refresh\" content=\"1; URL=?tab=edit&id=".$id."\">";
//exit;
}
}

if ($tab=="new") {
$tahun=date("Y");
$tgl_koleksi=today();
$tgl_ident=today();
$entri_oleh=$user;
} elseif ($tab=="edit") {
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM koleksi WHERE id='".$id."'";
$results = $db->get_results( $query );
foreach( $results as $data) {
$id=$data['id'];
$tahun=$data['tahun'];
$bidang=$data['bidang'];
$nrk=$data['nrk'];
$kd=strtoupper($data['kd']);
$inang=$data['inang'];
$lokasi=$data['lokasi'];
$gps_ns_a=$data['gps_ns_a'];
$gps_ns_b=$data['gps_ns_b'];
$gps_ns_c=$data['gps_ns_c'];
$gps_ns=$data['gps_ns'];
$gps_we_a=$data['gps_we_a'];
$gps_we_b=$data['gps_we_b'];
$gps_we_c=$data['gps_we_c'];
$gps_we=$data['gps_we'];
$sumber=$data['sumber'];
$tgl_koleksi=$data['tgl_koleksi'];
$kolektor=$data['kolektor'];
$pengumpulan=$data['pengumpulan'];
$jenis_kel=$data['jenis_kel'];
$jenis_subs=$data['jenis_subs'];
$jenis_spes=$data['jenis_spes'];
$jenis_fam=$data['jenis_fam'];
$jenis_ordo=$data['jenis_ordo'];
$status=$data['status'];
$ref=$data['ref'];
$gender=$data['gender'];
$stadia=$data['stadia'];
$mounting=$data['mounting'];
$jumlah_spesimen=$data['jumlah_spesimen'];
$tgl_ident=$data['tgl_ident'];
$ident_oleh=$data['ident_oleh'];
$foto=$data['foto'];
$lokasi_simpan=$data['lokasi_simpan'];
$ket=$data['ket'];
$kode_pemilik=$data['kode_pemilik'];
$entri_oleh=$data['entri_oleh'];
$entri_tgl=$data['entri_tgl'];
$update_oleh=$data['update_oleh'];
$update_tgl=$data['update_tgl'];
}
$nrk1="000000".$nrk;
$m=strlen($nrk1)-6;
$nrkp=substr ($nrk1, $m, 6);
$ei="<input name='kd' value='$kd' style='width:70px;'><input name='nrk' value='$nrkp'>";
}

if ($bidang=="KT") {$n="optk";}
if ($bidang=="KH") {$n="hphk";}
echo "<h2>FORM</h2><form method=post>
<input type='hidden' name='nrk' value='$nrk'>
<input type='hidden' name='bidang' value='$bidang'>
<input type='hidden' name='entri_oleh' value='$entri_oleh'>
<input type='hidden' name='entri_tgl' value='$entri_tgl'>
<table width=99% cellspacing='2px'><tr><td width='150px'>NRK</td><td width='10px'>:</td><td>".$ei.substr($jenis_kel, 0, 2).".$bidang</td></tr>
<tr><td>Inang/MP/Attractan</td><td>:</td><td><input type='text' name='inang' value='$inang' style='width:100%;'></td></tr>
<tr><td>Lokasi</td><td>:</td><td><input type='text' name='lokasi' value='$lokasi' style='width:100%;'></td></tr>
<tr><td>GPS</td><td>:</td><td>Latitude <input type='number' name='gps_ns_a' value='$gps_ns_a' style='width:70px;'> <input type='number' name='gps_ns_b' value='$gps_ns_b' style='width:70px;'>' <input type='number' name='gps_ns_c' value='$gps_ns_c' style='width:70px;'>\" <select name='gps_ns'><option value='$gps_ns'>$gps_ns</option><option value='N'>N</option><option value='S'>S</option></select></td></tr>
<tr><td></td><td></td><td>Longitude <input type='number' name='gps_we_a' value='$gps_we_a' style='width:70px;'> <input type='number' name='gps_we_b' value='$gps_we_b' style='width:70px;'>' <input type='number' name='gps_we_c' value='$gps_we_c' style='width:70px;'>\" <select name='gps_we'><option value='$gps_we'>$gps_we</option><option value='W'>W</option><option value='E'>E</option></select></td></tr>
<tr><td>Sumber</td><td>:</td><td><input type='text' name='sumber' value='$sumber' style='width:100%;'></td></tr>
<tr><td>Tanggal Koleksi</td><td>:</td><td><input type='date' name='tgl_koleksi' value='".$tgl_koleksi."'></td></tr>
<tr><td>Kolektor</td><td>:</td><td><input id=\"karyawan_autocomplete\" name='kolektor' style='width:400px;' value='$kolektor'></td></tr>
<tr><td>Metode Pengumpulan</td><td>:</td><td>".table_option("pengumpulan","pengumpulan",$pengumpulan,"5")." <a target='_blank' href='table.php?t=pengumpulan'>D</a></td></tr>
<tr><td>Data Jenis</td><td>:</td><td></td></tr>
<tr><td>- Kelompok</td><td>:</td><td>".table_option("jenis_kel","kelompok",$jenis_kel,"2")." <a target='_blank' href='table.php?t=kelompok'>D</a></td></tr>
<tr><td>- Ordo</td><td>:</td><td>".table_option("jenis_ordo","ordo",$jenis_ordo,"8")." <a target='_blank' href='table.php?t=ordo'>D</a></td></tr>
<tr><td>- Family</td><td>:</td><td>".table_option("jenis_fam","family",$jenis_fam,"9")." <a target='_blank' href='table.php?t=family'>D</a></td></tr>
<tr><td>- Spesies</td><td>:</td><td><input type='text' name='jenis_spes' value='$jenis_spes' style='width:400px;'></td></tr>
<tr><td>- Sub spesies</td><td>:</td><td><input type='text' name='jenis_subs' value='$jenis_subs' style='width:500px;'></td></tr>
<tr><td>Status</td><td>:</td><td><select name='status' id='sl6'>
<option value='$status'>$status</option>
<option value='OPTK-A1'>OPTK-A1</option>
<option value='OPTK-A2'>OPTK-A2</option>
<option value='OPT'>OPT</option>
<option value='OPT-LAIN'>OPT-LAIN</option>
<option value='HPHK-1'>HPHK-1</option>
<option value='HPHK-2'>HPHK-2</option>
<option value='HPH'>HPH</option>
<option value='HPH-LAIN'>HPH-LAIN</option>
</select></td></tr>
<tr><td>Referensi</td><td>:</td><td><input type='text' name='ref' value='$ref' style='width:500px;'></td></tr>
<tr><td>Gender</td><td>:</td><td><select name='gender' id='sl7'><option value='$gender'>$gender</option><option value='JANTAN'>JANTAN</option><option value='BETINA'>BETINA</option></select></td></tr>
<tr><td>Stadia</td><td>:</td><td>".table_option("stadia","stadia",$stadia,"3")."  <a target='_blank' href='table.php?t=stadia'>D</a></td></tr>
<tr><td>Mounting/Metode</td><td>:</td><td>".table_option("mounting","mounting",$mounting,"4")." <a target='_blank' href='table.php?t=mounting'>D</a></td></tr>
<tr><td>Jumlah Spesimen</td><td>:</td><td><input type='number' name='jumlah_spesimen' value='$jumlah_spesimen' style='width:70px;'></td></tr>
<tr><td>Tanggal Identifikasi</td><td>:</td><td><input type='date' name='tgl_ident' value='".$tgl_ident."'></td></tr>
<tr><td>Identifikasi Oleh</td><td>:</td><td>
<select name='ident_oleh' id='sl10'>".karyawan_option($ident_oleh)."</select></td></tr>
<tr valign=top><td>Foto</td><td>:</td><td><a href='exe/upload_form.php?id=".$id."' target='_blank'>Manage</a><br>
".koleksi_foto_thumb($id)."
</td></tr>
<tr><td>Lokasi Simpan</td><td>:</td><td><input type='text' name='lokasi_simpan' value='$lokasi_simpan' style='width:500px;'></td></tr>
<tr valign='top'><td>Keterangan</td><td>:</td><td><textarea name='ket' style='width:100%;height:50px;'>$ket</textarea></td></tr>
<tr><td>Dientry by</td><td>:</td><td>$entri_oleh</td></tr>
<tr><td>Tanggal entry</td><td>:</td><td>$entri_tgl</td></tr>
<tr><td>Update by</td><td>:</td><td>$update_oleh</td></tr>
<tr><td>Tanggal update</td><td>:</td><td>$update_tgl</td></tr>
<tr><td>Tahun</td><td>:</td><td><input type='text' name='tahun' value='$tahun' style='width:50px;'></td></tr>
<tr><td></td><td></td><td><input type=submit value=Simpan> &nbsp; &nbsp; &nbsp; <a href='".$n.".php'>Selesai</a></td></tr>
</table>
</form>
";
}
