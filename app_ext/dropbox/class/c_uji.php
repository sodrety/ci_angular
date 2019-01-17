 
<?php
// Berisi tabel support, bukan yang utama. yang utama ada di c_content

class uji {
	
function uji_target($id) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * from uji_target join m_optk ON uji_target.id_target=m_optk.id where id_uji='".$id."' order by jenis,nama_latin";
$results = $db->get_results( $query );
$dt.= "<table class=table><tr><th>No</th><th>Kode Target</th><th>Nama OPTK</th><th>Jenis</th><th></th></tr>";
$kode=app_baca("uji","id='".$id."'","kode");	
foreach( $results as $data )
{
$n++;
$dt.= "<tr><td>".$n."</td><td>".$data['target_kode']."</td><td>".$data['nama_latin']."</td><td>".$data['jenis']."</td><td><a href='exe/uji_target_del.php?idt=".$id."_".$data['id']."' target='iframe' onClick=\"javascript:requestContent('ajx/uji_target.php?id=".$id."','uji_target')\"> x </a></td></tr>";
}
	
$dt.= "</table>";
return $dt;
}

function uji_target_terima($id) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * from uji_target join m_optk ON uji_target.id_target=m_optk.id where id_uji='".$id."' order by jenis,nama_latin";
$results = $db->get_results( $query );
$dt.= "<table class=table><tr><th>No</th><th>Kode Target</th><th>Nama OPTK</th><th>Jenis</th></tr>";
$kode=app_baca("uji","id='".$id."'","kode");	
foreach( $results as $data )
{
$n++;
$dt.= "<tr><td>".$n."</td><td>".$data['target_kode']."</td><td>".$data['nama_latin']."</td><td>".$data['jenis']."</td></tr>";
}
	
$dt.= "</table>";
return $dt;
}


function uji_target_print($id) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * from uji_target join m_optk ON uji_target.id_target=m_optk.id where id_uji='".$id."' order by jenis,nama_latin";
$results = $db->get_results( $query );
foreach( $results as $data )
{
$n++;
$dt.= $n.". ".$data['nama_latin']." (".$data['jenis'].") 
";
}
if ($n=="") {$dt="Terlampir";}
return $dt;
}


function uji_target_distribusi($id,$no) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * from uji WHERE id='".$id."'";
$results = $db->get_results( $query );

foreach( $results as $data )
{
}

$query0 = "SELECT * from uji_target join m_optk ON uji_target.id_target=m_optk.id where id_uji='".$id."' order by jenis,nama_latin";
$results0 = $db->get_results( $query0 );
$n=0;
foreach( $results0 as $data0 )
{
$n++;
if ($n==1) {$print="<a target='_blank' href='print/distribusi.php?&id=".$data['id']."'>Print</a> <a href='?t=FormDistribusi&k=".$data['kode']."'>Edit</a>";$g="";} else {$print="";$g=" class='gray'";}
echo "<tr><td".$g.">".$no."</td><td".$g.">".$data['kode']."</td><td".$g.">".$data['komoditi']."</td><td".$g.">".$data['distribusi_kondisi']."</td><td".$g."  align=center>".app_jml("uji_lot","id_uji='".$data['id']."'","id")."</td><td".$g.">".$data['terima_tgl']."</td><td>".$n."</td><td>".$data0['target_kode']."</td><td>".$data0['nama_latin']."</td><td>".$data0['jenis']."</td><td>".app_baca("m_metode","id='".$data0['id_metode']."'","metode")."</td><td>".db_baca("user_login","karyawan","id='".$data0['preparasi']."'","nama")."</td><td>".db_baca("user_login","karyawan","id='".$data0['penguji']."'","nama")."</td><td>".$data0['ket']."</td><td>".$print."</td></tr>";
}

}


function uji_target_distribusi_form($id) {
$db = new database();
$opsi= new opsi();
$db->connect(app_db());
$query = "SELECT * from uji_target join m_optk ON uji_target.id_target=m_optk.id where id_uji='".$id."' order by jenis,nama_latin";
$results = $db->get_results( $query );
$dt.= "<table class=table><tr><th>No</th><th>Kode Target</th><th>Nama OPTK</th><th>Jenis</th><th>Metode</th><th>Preparasi</th><th>Penguji</th><th>Keterangan</th><th></th></tr>";
$kode=app_baca("uji","id='".$id."'","kode");	
foreach( $results as $data )
{
$n++;
$dt.= "<form method='post' target='iframe' action='exe/uji_distribusi.php'><tr><td>".$n."</td><td>".$kode."~".$data['target_kode']."</td><td>".$data['nama_latin']."</td><td>".$data['jenis']."</td><td><input type=hidden name=idt value='".$data['idt']."'><select name='id_metode' id=select".$n.">".$opsi->m_metode($data['id_metode'])."</select></td><td><select name=preparasi id=slct".$n.">".karyawan_opt($data['preparasi'])."</select></td><td><select name=penguji id=sct".$n.">".karyawan_opt($data['penguji'])."</select></td><td><input type=text name='ket' value='".$data['ket']."'></td><td><input type='submit' value='Simpan' name='submit'></td></tr></form>";
$inp.=$data['id']."|||";
}
	
$dt.= "</table><input type=hidden name=inp value='".$inp."'>";
return $dt;
}


function uji_pengujian($id,$td) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * from uji_target join m_optk ON uji_target.id_target=m_optk.id where id_uji='".$id."' order by jenis,nama_latin";
$results = $db->get_results( $query );

foreach( $results as $data )
{
$n++;
$pr=app_baca("m_metode","id='".$data['id_metode']."'","print");
$td2="<td>".$data['target_kode']."</td><td>".$data['nama_latin']."</td><td>".$data['jenis']."</td><td>".app_baca("m_metode","id='".$data['id_metode']."'","metode")."</td><td>".db_baca("user_login","karyawan","id='".$data['preparasi']."'","nama")."</td><td>".db_baca("user_login","karyawan","id='".$data['penguji']."'","nama")."</td>";
$this->uji_pengujian_lot($id,$td,$td2,$n,$data['target_kode'],$data['idt'],$pr);
}

}

function uji_pengujian_lot($id,$td,$td2,$n,$k,$idt,$pr) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * from uji_lot where id_uji='".$id."' order by no";
$results = $db->get_results( $query );
$kode=app_baca("uji","id='".$id."'","kode");	
foreach( $results as $data )
{
$nn++;
if ($n==1 and $nn==1) { $tda=$td;} else {$tda=str_replace("<td","<td class='gray' ",$td); }
if ($nn==1) { $td2a=$td2;$print="<a target='_blank' href='print/uji_".$pr.".php?id=".$id."&idt=".$idt."'>Print</a> <a href='?t=FormPengujian&k=".$k."'>Edit</a>"; } else {$td2a=str_replace("<td","<td class='gray' ",$td2);$print="";  }
$idh=$idt."_".$data['lot_kode'];
echo "<tr>".$tda.$td2a."<td>".$kode."1".$data['lot_kode']."</td><td>".$data['nama']."</td><td>".app_baca("uji_hasil","id='".$idh."'","hasil")."</td><td>".$print."</td></tr>";

}

}

function uji_pengujian_form($id,$idt,$m) {
$db = new database();
$opsi = new opsi();
$db->connect(app_db());
$query = "SELECT * from uji_lot where id_uji='".$id."' order by no";
$results = $db->get_results( $query );
$kode=app_baca("uji","id='".$id."'","kode");	
foreach( $results as $data )
{
$nn++;
$idh=$idt."_".$data['lot_kode'];
$opt=$opsi->m_optk();
if ($m=="4") {
$td="<form method='post' target='iframe' action='exe/uji_hasil.php'>
<td><input type=number name='abs_1' value='".app_baca("uji_hasil","id='".$idh."'","abs_1")."' onchange=\"javascript:this.form.submit();\" style='width:90px;'></td>
<td><input type=number name='abs_2' value='".app_baca("uji_hasil","id='".$idh."'","abs_2")."' onchange=\"javascript:this.form.submit();\" style='width:90px;'></td>
<td>
<select name='warna_1' onchange=\"javascript:this.form.submit();\"><option value='".app_baca("uji_hasil","id='".$idh."'","warna_1")."'>".app_baca("uji_hasil","id='".$idh."'","warna_1")."</option><option value=''></option><option value='+'>+</option><option value='-'>-</option></select>
</td>
<td>
<select name='warna_2' onchange=\"javascript:this.form.submit();\"><option value='".app_baca("uji_hasil","id='".$idh."'","warna_2")."'>".app_baca("uji_hasil","id='".$idh."'","warna_2")."</option><option value=''></option><option value='+'>+</option><option value='-'>-</option></select></td>
<input type=hidden name=idh value='".$idh."'><input type=hidden name=id_uji value='".$id."'>
<td></td>"; }

else {
$td="<form method='post' target='iframe' action='exe/uji_temuan.php'><td><input type='checkbox' name='s1' value='V'></td><td><input type='checkbox' name='s2' value='V'></td><td><input type='checkbox' name='s3' value='V'></td><td><input type='checkbox' name='s4' value='V'></td><td><select name='temuan' id=sct".$nn." onChange=\"javascript:this.form.submit();javascript:requestContent('ajx/uji_temuan.php?idh=".$idh."','".$idh."'); \">".$opt."</select></td><input type=hidden name=idh value='".$idh."'></form>
<td><div id='".$idh."'>".$this->uji_temuan($idh)."</div></td><form method='post' target='iframe' action='exe/uji_hasil.php'>";
}

echo "<tr><td>".$nn."</td><td>".$kode."1".$data['lot_kode']."</td><td>".$data['nama']."</td>".$td."

<td><input type=date name='selesai_tgl' value='".app_baca("uji_hasil","id='".$idh."'","selesai_tgl")."' onchange=\"javascript:this.form.submit();\"></td><td><select name=hasil onchange=\"javascript:this.form.submit();\">".$opsi->h_uji($idh)."</select></td><input type=hidden name=id value='".$idh."'><input type=hidden name=id_uji value='".$id."'></tr></form>";

}

}

function elisa_data($idt) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * from uji_elisa WHERE idt='".$idt."'";
$results = $db->get_results( $query );
foreach( $results as $data )
{ }

echo "
<table class=table>
<form method='post' target='iframe' action='exe/uji_elisa.php'>
<tr><td>Antibodi</td><td>:</td><td><input type=text name='antibodi_v' value='".$data['antibodi_v']."' style='width:90px;'></td><td>Kons</td><td>:</td><td><input type=text name='antibodi_k' value='".$data['antibodi_k']."' style='width:90px;'></td><td>Waktu</td><td>:</td><td><input type=text name='antibodi_w' value='".$data['antibodi_w']."' style='width:90px;'></td><td>Temp</td><td>:</td><td><input type=text name='antibodi_t' value='".$data['antibodi_t']."' style='width:90px;'></td></tr>
<tr><td>Antigen</td><td>:</td><td><input type=text name='antigen_v' value='".$data['antigen_v']."' style='width:90px;'></td><td>Kons</td><td>:</td><td><input type=text name='antigen_k' value='".$data['antigen_k']."' style='width:90px;'></td><td>Waktu</td><td>:</td><td><input type=text name='antigen_w' value='".$data['antigen_w']."' style='width:90px;'></td><td>Temp</td><td>:</td><td><input type=text name='antigen_t' value='".$data['antigen_t']."' style='width:90px;'></td></tr>
<tr><td>Blocking</td><td>:</td><td><input type=text name='blocking_v' value='".$data['blocking_v']."' style='width:90px;'></td><td>Kons</td><td>:</td><td><input type=text name='blocking_k' value='".$data['blocking_k']."' style='width:90px;'></td><td>Waktu</td><td>:</td><td><input type=text name='blocking_w' value='".$data['blocking_w']."' style='width:90px;'></td><td>Temp</td><td>:</td><td><input type=text name='blocking_t' value='".$data['blocking_t']."' style='width:90px;'></td></tr>
<tr><td>Probe</td><td>:</td><td><input type=text name='probe_v' value='".$data['probe_v']."' style='width:90px;'></td><td>Kons</td><td>:</td><td><input type=text name='probe_k' value='".$data['probe_k']."' style='width:90px;'></td><td>Waktu</td><td>:</td><td><input type=text name='probe_w' value='".$data['probe_w']."' style='width:90px;'></td><td>Temp</td><td>:</td><td><input type=text name='probe_t' value='".$data['probe_t']."' style='width:90px;'></td></tr>
<tr><td>Conjugate</td><td>:</td><td><input type=text name='conjugate_v' value='".$data['conjugate_v']."' style='width:90px;'></td><td>Kons</td><td>:</td><td><input type=text name='conjugate_k' value='".$data['conjugate_k']."' style='width:90px;'></td><td>Waktu</td><td>:</td><td><input type=text name='conjugate_w' value='".$data['conjugate_w']."' style='width:90px;'></td><td>Temp</td><td>:</td><td><input type=text name='conjugate_t' value='".$data['conjugate_t']."' style='width:90px;'></td></tr>
<tr><td>Substrat</td><td>:</td><td><input type=text name='substrat_v' value='".$data['substrat_v']."' style='width:90px;'></td><td>Kons</td><td>:</td><td><input type=text name='substrat_k' value='".$data['substrat_k']."' style='width:90px;'></td><td>Waktu</td><td>:</td><td><input type=text name='substrat_w' value='".$data['substrat_w']."' style='width:90px;'></td><td>Temp</td><td>:</td><td><input type=text name='substrat_t' value='".$data['substrat_t']."' style='width:90px;'></td></tr>
</table>
<table class=table>
<tr><th>Contoh Uji</th><th>Absorb 1</th><th>Absorb 2</th><th>Warna 1</th><th>Warna 2</th><th>Kesimpulan</th></tr>

<tr><td>Kontrol +</td>
<td><input type=text name='kontrol_p_abs_1' value='".$data['kontrol_p_abs_1']."' style='width:90px;'></td>
<td><input type=text name='kontrol_p_abs_2' value='".$data['kontrol_p_abs_2']."' style='width:90px;'></td>
<td>
<select name='kontrol_p_warna_1'><option value='".$data['kontrol_p_warna_1']."'>".$data['kontrol_p_warna_1']."</option><option value=''></option><option value='+'>+</option><option value='-'>-</option></select>
</td>
<td>
<select name='kontrol_p_warna_2'><option value='".$data['kontrol_p_warna_2']."'>".$data['kontrol_p_warna_1']."</option><option value=''></option><option value='+'>+</option><option value='-'>-</option></select>
</td>
<td><select name='kontrol_p_kesimpulan'><option value='".$data['kontrol_p_kesimpulan']."'>".$data['kontrol_p_kesimpulan']."</option><option value=''></option><option value='Positif'>Positif</option><option value='Negatif'>Negatif</option></select></td>
</tr>

<tr><td>Kontrol -</td>
<td><input type=text name='kontrol_n_abs_1' value='".$data['kontrol_n_abs_1']."' style='width:90px;'></td>
<td><input type=text name='kontrol_n_abs_2' value='".$data['kontrol_n_abs_2']."' style='width:90px;'></td>
<td>
<select name='kontrol_n_warna_1'><option value='".$data['kontrol_n_warna_1']."'>".$data['kontrol_n_warna_1']."</option><option value=''></option><option value='+'>+</option><option value='-'>-</option></select>
</td>
<td>
<select name='kontrol_n_warna_2'><option value='".$data['kontrol_n_warna_2']."'>".$data['kontrol_n_warna_1']."</option><option value=''></option><option value='+'>+</option><option value='-'>-</option></select>
</td>
<td><select name='kontrol_n_kesimpulan'><option value='".$data['kontrol_n_kesimpulan']."'>".$data['kontrol_n_kesimpulan']."</option><option value=''></option><option value='Positif'>Positif</option><option value='Negatif'>Negatif</option></select></td>
</tr>
<tr><td>Buffer</td>
<td><input type=text name='kontrol_b_abs_1' value='".$data['kontrol_b_abs_1']."' style='width:90px;'></td>
<td><input type=text name='kontrol_b_abs_2' value='".$data['kontrol_b_abs_2']."' style='width:90px;'></td>
<td>
<select name='kontrol_b_warna_1'><option value='".$data['kontrol_b_warna_1']."'>".$data['kontrol_b_warna_1']."</option><option value=''></option><option value='+'>+</option><option value='-'>-</option></select>
</td>
<td>
<select name='kontrol_b_warna_2'><option value='".$data['kontrol_b_warna_2']."'>".$data['kontrol_b_warna_1']."</option><option value=''></option><option value='+'>+</option><option value='-'>-</option></select>
</td>
<td><select name='kontrol_b_kesimpulan'><option value='".$data['kontrol_b_kesimpulan']."'>".$data['kontrol_b_kesimpulan']."</option><option value=''></option><option value='Positif'>Positif</option><option value='Negatif'>Negatif</option></select></td>
</tr>

<tr><td colspan=5><input type=hidden name=idt value='".$idt."'>
<input type=submit  value='Simpan'></td></tr></form>
</table>
";

}


function uji_hasil($id) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * from uji_target join m_optk ON uji_target.id_target=m_optk.id where id_uji='".$id."' order by jenis,nama_latin";
$results = $db->get_results( $query );

foreach( $results as $data )
{
$n++;

$td="<td>".$data['target_kode']."</td><td>".$data['nama_latin']."</td><td>".app_baca("m_metode","id='".$data['id_metode']."'","metode")."</td><td>".db_baca("user_login","karyawan","id='".$data['preparasi']."'","nama")."</td><td>".db_baca("user_login","karyawan","id='".$data['penguji']."'","nama")."</td>";
$this->uji_hasil_lot($id,$td,$data['idt']);
}

}


function uji_temuan($idh) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * from uji_temuan join m_optk ON uji_temuan.temuan=m_optk.id where idh='".$idh."' order by nama_latin";
$results = $db->get_results( $query );

foreach( $results as $data )
{
$n++;
$dt.=$n.". ".$data['nama_latin']." <a href='exe/uji_temuan_del.php?idte=".$data['idte']."' target='iframe' onClick=\"javascript:requestContent('ajx/uji_temuan.php?idh=".$idh."','".$idh."')\"> X </a><br>";
}
return $dt;
}

function uji_temuan_print($idh) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * from uji_temuan join m_optk ON uji_temuan.temuan=m_optk.id where idh='".$idh."' order by nama_latin";
$results = $db->get_results( $query );

foreach( $results as $data )
{
$n++;
$dt.=$n.") ".$data['nama_latin']."; ";
}
return $dt;
}

function uji_hasil_lot($id,$td,$idt) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * from uji_lot where id_uji='".$id."' order by no";
$results = $db->get_results( $query );
$kode=app_baca("uji","id='".$id."'","kode");	
foreach( $results as $data )
{
$nn++;
if ($nn==1) { $tda=$td;} else {$tda="<td></td><td></td><td></td><td></td><td></td>";  }
$idh=$idt."_".$data['lot_kode'];
echo "<tr>".$tda."<td>".$nn."</td><td>".$kode."1".$data['lot_kode']."</td><td>".$data['nama']."</td><td>".app_baca("uji_hasil","id='".$idh."'","hasil")."</td><td>".$print."</td></tr>";

}

}


function uji_lot($id) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * from uji_lot where id_uji='".$id."' order by nama";
$results = $db->get_results( $query );
$dt.= "<table class=table><tr><th>No</th><th>Kode Lot</th><th>Nama Lot</th><th>Keterangan</th><th>PRINT</th><th></th></tr>";
$kode=app_baca("uji","id='".$id."'","kode");	
foreach( $results as $data )
{
$n++;
$dt.= "<tr><td>".$n."</td><td>".$kode."1".$data['lot_kode']."</td><td>".$data['nama']."</td><td>".$data['ket']."</td><td><a target='_blank' href='print/lot.php?&k=".$kode."1".$data['lot_kode']."'>Label</a></td><td><a href='exe/uji_lot_del.php?id=".$data['id']."' target='iframe' onClick=\"javascript:requestContent('ajx/uji_lot.php?id=".$id."','uji_lot'); \"> x </a></td></tr>";
}
	
$dt.= "</table>";
return $dt;
}


function uji_lot_terima($id) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * from uji_lot where id_uji='".$id."' order by nama";
$results = $db->get_results( $query );
$dt.= "<table class=table><tr><th>No</th><th>Kode Lot</th><th>Nama Lot</th><th>Keterangan</th><th>PRINT</th></tr>";
$kode=app_baca("uji","id='".$id."'","kode");	
foreach( $results as $data )
{
$n++;
$dt.= "<tr><td>".$n."</td><td>".$kode."1".$data['lot_kode']."</td><td>".$data['nama']."</td><td>".$data['ket']."</td><td><a target='_blank' href='print/lot.php?&k=".$kode."1".$data['lot_kode']."'>Label</a></td></tr>";
}
	
$dt.= "</table>";
return $dt;
}


function uji_hasil_persen($id,$to) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * from uji_hasil where id_uji='".$id."'";
$results = $db->get_results( $query );
$p=0;
$n=0;
foreach( $results as $data )
{
$nn++;
if ($data['hasil']=="Positif") {$p++;} elseif ($data['hasil']=="Negatif") {$n++;}
}
$b=$to-($p+$n);
if ($nn>0) {
return "+".des(($p/$to)*100)."; -".des(($n/$to)*100)."; ?".des(($b/$to)*100).";";
}
}


}
