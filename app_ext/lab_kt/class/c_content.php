<?php

class content {
	
function form_periode() {	
return "<form method='post'>Tanggal: <input type=date name=mm value='".$this->mm()."'> sd. <input type=date name=ss value='".$this->ss()."'> <input type='submit' value='Show'><input type='hidden' value='list' name='tab'></form>";
}
	
	
function mm() {
if ($_POST['mm']!="") {$mm=$_POST['mm'];} else {$mm=date("Y-01-01");}	
return $mm;
}	


function ss() {
if ($_POST['ss']!="") {$ss=$_POST['ss'];} else {$ss=date("Y-m-31"); }	
return $ss;	
}	
	
	
function kirim() {
$opsi = new opsi();
$uji = new uji();
$db = new database();
$db->connect(app_db());
echo $this->form_periode()."<form>New</a>:<input type=hidden name=t value='FormKirim'><select id='select2' name='ll'>".$opsi->m_ll($ll)."</select><input type=submit value='exe'></form></a>
<table class=table id='dt1' width=100%>
<thead>
<tr><th>NO</th><th>TGL KIRIM</th><th>NO SURAT</th><th>KODE</th><th>KATEGORI</th><th>LOKASI PEMOHON</th><th>KOMODITI</th><th>ASAL/TUJUAN</th><th>JUMLAH SAMPEL/LOT</th><th>TARGET PEST</th><th>HASIL UJI</th><th>PRINT</th><th></th></tr></thead><tbody>";
$no=1;
$query = "SELECT * from uji WHERE kirim_tgl<='".$this->ss()."' and kirim_tgl>='".$this->mm()."' order by kirim_tgl desc,kirim_nomor desc";
$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{

if ($data['kode']=="") {} else {$kode=$data['kode'];}
//$kode=kode($data['kirim_nomor']); 
//app_update("uji","id='".$data['id']."'","kode_no='".$data['kirim_nomor']."'");
//app_update("uji","id='".$data['id']."'","kode='".$kode."'");
$lot=app_jml("uji_lot","id_uji='".$data['id']."'","id");
$trg=app_jml("uji_target","id_uji='".$data['id']."'","idt");
echo "<tr valign='top'><td>".$no."</td><td>".$data['kirim_tgl']."</td><td>".$data['kirim_nomor']."</td><td>".$kode."</td><td>".app_baca("m_ll","id='".$data['ll']."'","ll")."</td><td>".app_baca("m_lokasi","id_lokasi='".$data['lokasi']."'","lokasi")."</td><td>".$data['komoditi']."</td><td>".$data['asal']."</td><td align=center>".app_jml("uji_lot","id_uji='".$data['id']."'","id")."</td><td align=center>".app_jml("uji_target","id_uji='".$data['id']."'","idt")."</td></td><td>".$uji->uji_hasil_persen($data['id'],($trg*$lot))."</td><td><a target='_blank' href='print/kirim.php?&id=".$data['id']."'>Lab</a> <a target='_blank' href='print/kirim.php?&id=".$data['id']."&u=arsip'>Arsip</a></td><td><a href='?t=FormKirim&id=".$data['id']."'>Edit</a></td></tr>";

$no+=1; 

}
echo "</tbody></table>";
	
}	
	
	
function formkirim() {
$id=$_GET['id'];	
if ($_POST['form']=="uji") {
	if ($id=="") {
		$unik=unik();
app_query("INSERT INTO uji (`unik`,`kirim_tgl`,`kirim_nomor`,`ll`,`asal`,`jumlah`,`satuan`,`komoditi`,`no_reg`,`kirim_nama`,`kirim_jab`,`kirim_ket`,`jenis_mp`,`alamat`,`ambil_tgl`,`ambil_petugas`,`kirim_input_oleh`,`kirim_input_pada`,`lokasi`,`serahkan_oleh`) VALUES ('".$unik."', '".$_POST['kirim_tgl']."', '".$_POST['kirim_nomor']."', '".$_POST['ll']."', '".$_POST['asal'].$_POST['asal2']."', '".$_POST['jumlah']."', '".$_POST['satuan']."', '".$_POST['komoditi']."', '".$_POST['no_reg']."', '".$_POST['kirim_nama']."', '".$_POST['kirim_jab']."', '".$_POST['kirim_ket']."', '".$_POST['jenis_mp']."', '".$_POST['alamat']."', '".$_POST['kirim_tgl']."', '".$_POST['ambil_petugas']."', '".user_id()."', '".now()."', '".$_POST['lokasi']."', '".$_POST['serahkan_oleh']."')");
$idny=app_baca("uji","unik='".$unik."'","id");
$kdx=(app_baca("uji","kirim_tgl LIKE '".date("Y-")."%' order by kode_no desc","kode_no"))+1;	
app_update("uji","unik='".$unik."'","kode_no='".$kdx."'");
app_update("uji","unik='".$unik."'","kode='".kode($kdx)."'");
echo " Tersimpan<meta http-equiv=\"refresh\" content=\"0; URL=?t=FormKirim&id=".$idny."\">";
} else {

app_update("uji", "id='".$id."'", "kirim_tgl='".$_POST['kirim_tgl']."', kirim_nomor='".$_POST['kirim_nomor']."', komoditi='".$_POST['komoditi']."', asal='".$_POST['asal'].$_POST['asal2']."', jumlah='".$_POST['jumlah']."', satuan='".$_POST['satuan']."', kirim_nama='".$_POST['kirim_nama']."', kirim_jab='".$_POST['kirim_jab']."', kirim_update_oleh='".user_id()."', kirim_update_pada='".now()."', ll='".$_POST['ll']."', no_reg='".$_POST['no_reg']."', kirim_ket='".$_POST['kirim_ket']."', jenis_mp='".$_POST['jenis_mp']."', alamat='".$_POST['alamat']."', ambil_tgl='".$_POST['ambil_tgl']."', ambil_petugas='".$_POST['ambil_petugas']."', lokasi='".$_POST['lokasi']."', serahkan_oleh='".$_POST['serahkan_oleh']."'");
}
}	

$opsi = new opsi();
$sup = new sup();
$uji = new uji();
if ($id!="") {	

$db = new database();
$db->connect(app_db());
$query = "SELECT * from uji where id='".$id."' limit 0,1";
$results = $db->get_results( $query );
foreach( $results as $data )
{	
		$no_reg=$data['no_reg'];	
		$ll=$data['ll'];
		$kode=$data['kode'];
		$kirim_tgl=$data['kirim_tgl'];
		$kirim_nomor=$data['kirim_nomor'];
		$jumlah=$data['jumlah'];
		$satuan=$data['satuan'];
		$komoditi=$data['komoditi'];
		$kirim_nama=$data['kirim_nama'];
		$serahkan_oleh=$data['serahkan_oleh'];		
		$kirim_jab=$data['kirim_jab'];
		$asal=$data['asal'];
		$kirim_ket=$data['kirim_ket'];
		$jenis_mp=$data['jenis_mp'];
		$alamat=$data['alamat'];
		$ambil_tgl=$data['ambil_tgl'];
		$ambil_petugas=$data['ambil_petugas'];		
		$lokasi=$data['lokasi'];
}	
} else {
		$ll=$_GET['ll'];
		$no_reg=date("Y").".2.0300.0.S01.".$ll.".";	
$kdx=(app_baca("uji","kirim_tgl LIKE '".date("Y-")."%' order by kode_no desc","kode_no"))+1;	
		$kode=kode($kdx);
		$kirim_tgl=today();		
		$kirim_nomor=(app_baca("uji","kirim_tgl LIKE '".date("Y-")."%' and ll='".$ll."' order by kirim_nomor desc","kirim_nomor"))+1;
		$jumlah=1;
		$satuan="kg";
		$kirim_nama=15;
		$kirim_jab="Koordinator Jabatan Fungsional POPT";
		$jenis_mp="Benih";
		$alamat="Jakarta Utara";
		$ambil_tgl=today();
		$ambil_petugas="";

}	
echo "
<table class=table><form method='post'>
<tr><td width='10%'>Tanggal Surat</td><td width='5px'>:</td><td><input type=date name=kirim_tgl value='".$kirim_tgl."'></td></tr>
<tr><td>Tanggal Ambil Sampel</td><td>:</td><td><input type=date name=ambil_tgl value='".$ambil_tgl."'> oleh: <input type=text name=ambil_petugas value='".$ambil_petugas."'></td></tr>
<tr><td>Lalu Lintas</td><td>:</td><td><input type=hidden value='".$ll."' name=ll>".$ll." (".app_baca("m_ll","id='".$ll."'","ll").")</td></tr>
<tr><td>Jenis Media Pembawa</td><td>:</td><td><select name='jenis_mp'><option>".$jenis_mp."</option><option>Benih</option><option>Non-Benih</option></select></td></tr>
<tr><td>Nomor</td><td>:</td><td><input style='width:100px;' type=text name=kirim_nomor value='".$kirim_nomor."'>".$sup->no_srt_kirim($id,$ll)."</td></tr>
<tr><td>No Reg SP-1</td><td>:</td><td><input type='text' style='width:200px;' value='".$no_reg."' name='no_reg'></td></tr> 
<tr><td>Lokasi Pemohon</td><td>:</td><td><select name='lokasi' id=select6>".$opsi->m_lokasi($lokasi)."</select></td></tr>
<tr><td>Kode Sampel</td><td>:</td><td><b>".$kode."</b> (Terisi Otomatis)</td></tr>
<tr><td>Nama MP / Komoditi</td><td>:</td><td><input type='text' style='width:90%;' value='".$komoditi."' name='komoditi'></td></tr>

<tr><td>Negara/Daerah Asal/Tujuan</td><td>:</td><td><select name='asal' id=select4><option value='".$asal."'>".$asal."</option><option value=''> atau =</option>".$opsi->m_negara()."</select> atau = <input type='text' name='asal2' style='width:50%;' value=''></td></tr>
<tr><td>Volume Sampel</td><td>:</td><td><input type='number' name='jumlah' style='width:60px;' value='$jumlah'> <input type='text' name='satuan' style='width:60px;' value='$satuan'></td></tr>

<tr><td>Keterangan</td><td>:</td><td><input type='text' name='kirim_ket' style='width:80%;' value='$kirim_ket'></td></tr>

<tr><td>Jabatan</td><td>:</td><td><input type='text' name='kirim_jab' style='width:400px;' value='$kirim_jab'></td></tr>
<tr><td>Penanda Tangan</td><td>:</td><td><select name='kirim_nama' id='select2'>".karyawan_opt($kirim_nama)."</select></td></tr>
<tr><td>Diserahkan oleh</td><td>:</td><td><select name='serahkan_oleh' id='select3'>".karyawan_opt($serahkan_oleh)."</select></td></tr>
<tr><td>Alamat</td><td>:</td><td><input type='text' style='width:90%;' value='".$alamat."' name='alamat'></td></tr>

<tr><td colspan='3'><input type='submit' value='Simpan' name='submit'> &nbsp; Print untuk &nbsp; <a target='_blank' href='print/kirim.php?&id=".$data['id']."'>Lab</a> &nbsp; <a target='_blank' href='print/kirim.php?&id=".$data['id']."&u=arsip'>Arsip</a></td>
<input type='hidden' value='uji' name='form'></tr>
</form>
</table>
<br>";
if ($_GET['id']!="") { echo "
<b>Sampel / Lot</b>
<form method='post' target='iframe' action='exe/uji_lot.php'>
Nama Lot/Sampel <input type=text name=nama> Keterangan: <input type=text name=ket> <input type='submit' value='Tambah' name='submit' onClick=\"javascript:requestContent('ajx/uji_lot.php?id=".$id."','uji_lot'); \"> <input type='hidden' value='".$id."' name='id'> <a onClick=\"javascript:requestContent('ajx/uji_lot.php?id=".$id."','uji_lot'); \">Refresh</a> </form>
<div id='uji_lot'>
".$uji->uji_lot($id)."</div>
<b>Target OPTK</b>
<form method='post' target=iframe action='exe/uji_target.php'><select name='uji_target' id='select5'>".$opsi->m_optk()."</select> <input type='submit' value='Tambah' name='submit' onClick=\"javascript:requestContent('ajx/uji_target.php?id=".$id."','uji_target'); \"> <input type='hidden' value='".$id."' name='id'> <a onClick=\"javascript:requestContent('ajx/uji_target.php?id=".$id."','uji_target'); \">Refresh</a> </form>
<div id='uji_target'>
".$uji->uji_target($id)."</div>
<center><a href='?t=Kirim'>Selesai</a></center>
";
}
}	

	
	
function terima() {
$uji = new uji();
$sup = new sup();
$db = new database();
$db->connect(app_db());
echo "
<form><input type=hidden name=t value='FormTerima'>Kode Sampel <input type=text name=k autofocus></form>
<div class=center>LOG BOOK AGENDA PENGUJIAN SAMPLE DI LABORATORIUM</div>
<div class=right>FM. 46/T.04/Rev.00</div>
".$this->form_periode()."
<table class=table id=dt1 width=100%>
<thead>
<tr valign='top'><th rowspan=2>No Urut</th><th rowspan=2>Tanggal Terima</th><th rowspan=2>Identitas Pemilik</th><th rowspan=2>Alamat</th><th rowspan=2>No Agenda</th><th rowspan=2>Media Pembawa</th><th rowspan=2>Volume COntoh Uji</th><th colspan=2>Contoh Uji</th><th rowspan=2>No. Kontainer</th><th rowspan=2>Nomor Contoh Uji</th><th rowspan=2>Negara Asal</th><th rowspan=2>Target OPTK/HPHK</th><th rowspan=2>PPC</th><th rowspan=2>Keterangan</th><th rowspan=2>Print Kirim</th><th rowspan=2>Terima</th></tr>
<tr><th>Kondisi</th><th>Kemasan</th></tr>
</thead><tbody>";
$no=1;
$query = "SELECT * from uji WHERE (terima_tgl<='".$this->ss()."' and terima_tgl>='".$this->mm()."') or (kirim_tgl<='".$this->ss()."' and kirim_tgl>='".$this->mm()."') order by kirim_tgl desc";
$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{

//if ($data['kode']=="") {$kode=kode($data['id']); //app_update("uji","id='".$data['id']."'","kode='".$kode."'");
//} else {$kode=$data['kode'];}
if ($data['terima_tgl']=="") {$bg=" bgcolor='#dddddd'";$terima="";} else {$bg="";$terima="<a target='_blank' href='print/terima.php?&id=".$data['id']."'>Terima</a> ";}
echo "<tr valign='top'".$bg."><td>".$no."</td><td>".$data['terima_tgl']."</td><td>".$data['kirim_jab']."</td><td>".$data['alamat']."</td><td align=center>".$data['kode']."</td><td>".$data['komoditi']."</td><td>".$data['jumlah']." ".$data['satuan']."</td><td>Baik</td><td align=center>".app_jml("uji_lot","id_uji='".$data['id']."'","id")."</td><td></td><td>".$data['kirim_nomor']."".$sup->no_srt_kirim($data['id'],$data['ll'])."</td><td>".$data['asal']."</td><td>".nl2br($uji->uji_target_print($data['id']))."</td></td><td>".$data['ambil_petugas']."</td><td>".$data['catatan']."</td><td><a target='_blank' href='print/kirim.php?&id=".$data['id']."'>Kirim</a></td><td>".$terima."<a href='?t=FormTerima&k=".$data['kode']."'>Edit</a></td></tr>";

$no+=1; 

}
echo "</tbody></table>";
	
}		
	
function formterima() {
$id=app_baca("uji","kode='".substr($_GET['k'],0,7)."'","id");	
if ($id=="") {echo "Kode Tidak Ditemukan";
echo "<meta http-equiv=\"refresh\" content=\"1; URL=?t=Terima\">";
exit;}
if ($_POST['form']=="uji") {
app_update("uji", "id='".$id."'", "terima_tgl='".$_POST['terima_tgl']."', v1='".$_POST['v1']."', v2='".$_POST['v2']."', v3='".$_POST['v3']."', v4='".$_POST['v4']."', v5='".$_POST['v5']."', v6='".$_POST['v6']."', v7='".$_POST['v7']."', kesimpulan='".$_POST['kesimpulan']."', catatan='".$_POST['catatan']."', serahkan_oleh='".$_POST['serahkan_oleh']."', terima_oleh='".$_POST['terima_oleh']."', kaji_oleh='".$_POST['kaji_oleh']."'");
}	

$opsi = new opsi();
$sup = new sup();
$uji = new uji();
$db = new database();
$db->connect(app_db());
$query = "SELECT * from uji where id='".$id."' limit 0,1";
$results = $db->get_results( $query );
foreach( $results as $data )
{	
		$no_reg=$data['no_reg'];	
		$ll=$data['ll'];
		$kode=$data['kode'];
		$kirim_tgl=$data['kirim_tgl'];
		
		if ($data['terima_tgl']=="") {$terima_tgl=today();} else {$terima_tgl=$data['terima_tgl'];}
		$kirim_nomor=$data['kirim_nomor'];
		$jumlah=$data['jumlah'];
		$satuan=$data['satuan'];
		$komoditi=$data['komoditi'];
		$kirim_nama=$data['kirim_nama'];
		$kirim_jab=$data['kirim_jab'];
		$asal=$data['asal'];
		$kirim_ket=$data['kirim_ket'];
		$jenis_mp=$data['jenis_mp'];
		$alamat=$data['alamat'];
		$ambil_tgl=$data['ambil_tgl'];
		$ambil_petugas=$data['ambil_petugas'];
		$v1=$data['v1'];
		$v2=$data['v2'];
		$v3=$data['v3'];
		$v4=$data['v4'];
		$v5=$data['v5'];
		$v6=$data['v6'];
		$v7=$data['v7'];
		$catatan=$data['catatan'];
		$kesimpulan=$data['kesimpulan'];
		$serahkan_oleh=$data['serahkan_oleh'];
		$terima_oleh=$data['terima_oleh'];
		$kaji_oleh=$data['kaji_oleh'];
		
		if ($kesimpulan=="2") {$k2="checked";} else {$k1="checked";}
}
echo "<form><input type=hidden name=t value='FormTerima'>Kode Sampel <input type=text name=k autofocus></form>
<table class=table><form method='post'>

<tr><td width='20%'>Nomor Seri Contoh uji / Kode Sampel</td><td width='5px'>:</td><td><b>".$kode."</b></td></tr>
<tr><td>Jenis Media Pembawa</td><td>:</td><td>".$jenis_mp."</td></tr>
<tr><td>Jumlah </td><td>:</td><td>",app_jml("uji_lot","id_uji='".$data['id']."'","id")." lot/sampel
".	
$uji->uji_lot_terima($id)."
</td></tr>
<tr><td>Identitas Pemilik</td><td>:</td><td>$kirim_jab</td></tr>
<tr><td>Alamat</td><td>:</td><td>$alamat</td></tr>
<tr><td>Tanggal Pengambilan</td><td>:</td><td>".$ambil_tgl."</td></tr>
<tr><td>Petugas	</td><td>:</td><td>".$ambil_petugas."</td></tr>
<tr><td>Tanggal Kirim</td><td>:</td><td>".$kirim_tgl."</td></tr>

<tr><td>Nomor Berita Acara</td><td>:</td><td>".$kirim_nomor.$sup->no_srt_kirim($id,$ll)."</td></tr>
<tr><td>Kategori</td><td>:</td><td>".app_baca("m_ll","id='".$ll."'","ll")."</td></tr>
<tr><td>Nama MP / Komoditi</td><td>:</td><td>".$komoditi."</td></tr>
<tr><td>Negara/Daerah Asal/Tujuan</td><td>:</td><td>".$asal."</td></tr><tr><td>Volume Sampel</td><td>:</td><td>$jumlah  $satuan</td></tr>
<tr><td>Keterangan</td><td>:</td><td>$kirim_ket</td></tr>


<tr><td>Penanda Tangan</td><td>:</td><td>".db_baca("user_login","karyawan","id='".$kirim_nama."'","nama")."</td></tr>
<tr bgcolor='#ddd'><td>Tanggal Terima Contoh uji</td><td>:</td><td><input type=date name='terima_tgl' value='".$terima_tgl."'></td></tr>


<tr bgcolor='#ddd'><td>Verifikasi</td><td>:</td><td>
<input type='checkbox' name='v1' value='checked' ".$v1."> Ketersediaan Metode Uji<br>
<input type='checkbox' name='v2' value='checked' ".$v2."> Kemampuan Peralatan<br>
<input type='checkbox' name='v3' value='checked' ".$v3."> Ketersediaan Reagen<br>
<input type='checkbox' name='v4' value='checked' ".$v4."> Keterampilan Analis<br>
<input type='checkbox' name='v5' value='checked' ".$v5."> Kecukupan Jumlah Contoh uji<br>
<input type='checkbox' name='v6' value='checked' ".$v6."> Kenormalan Kondisi Contoh uji<br>
<input type='checkbox' name='v7' value='checked' ".$v7."> Kemampuan laboratorium Sub Kontrak <br>
</td></tr>
<tr bgcolor='#ddd'><td>Catatan</td><td>:</td><td><input type=text name='catatan' value='".$catatan."' style='width:98%'></td></tr>
<tr bgcolor='#ddd'><td>Kesimpulan</td><td>:</td><td>
<input type='radio' name='kesimpulan' value='1' ".$k1."> Dapat dilakukan pengujian<br>
<input type='radio' name='kesimpulan' value='2' ".$k2."> Tidak dapat dilakukan pengujian<br>
</td></tr>
<tr bgcolor='#ddd'><td>Diserahkan oleh</td><td>:</td><td><select name='serahkan_oleh' id='select2'>".karyawan_opt($serahkan_oleh)."</select></td></tr>
<tr bgcolor='#ddd'><td>Diterima oleh</td><td>:</td><td><select name='terima_oleh' id='select3'>".karyawan_opt($terima_oleh)."</select></td></tr>
<tr bgcolor='#ddd'><td>Dikaji oleh</td><td>:</td><td><select name='kaji_oleh' id='select4'>".karyawan_opt($kaji_oleh)."</select></td></tr>
<tr bgcolor='#ddd'><td></td><td></td><td><input type='submit' value='Simpan' name='submit'> &nbsp; &nbsp; <a target='_blank' href='print/terima.php?&id=".$id."'>Print</a></td>
<input type='hidden' value='uji' name='form'></tr>
</form>
</table>

<b>Target OPTK</b>
<form method='post' target='iframe' action='exe/uji_target.php'><select name='uji_target' id=select5>".$opsi->m_optk()."</select> <input type='submit' value='Tambah' name='submit' onClick=\"javascript:requestContent('ajx/uji_target.php?id=".$id."','uji_target'); \"> <input type='hidden' value='".$id."' name='id'> <a onClick=\"javascript:requestContent('ajx/uji_target.php?id=".$id."','uji_target'); \">Refresh</a> </form>
<div id='uji_target'>
".$uji->uji_target($id)."</div>
<center><a href='?t=Terima'>Selesai</a></center>
";

}		
	
	
function distribusi() {
$uji = new uji();
$db = new database();
$db->connect(app_db());
echo "
<form><input type=hidden name=t value='FormDistribusi'>Kode Sampel <input type=text name=k autofocus></form>
".$this->form_periode()."
<table class=table id=dt1 width=100%>
<thead>
<tr><th>NO URUT</th><th>TANGGAL DISTRIBUSI</th><th>NO. SERI</th><th>JENIS</th><th>KONDISI</th><th>JUMLAH</th><th>TANGGAL TERIMA</th><th>NO</th><th>KODE TARGET</th><th>TARGET OPTK / 
HPH(K)</th><th>JENIS</th><th>METODE PENGUJIAN</th><th>ANALIS PENGUJI</th><th>KETERANGAN</th><th>DISTRIBUSI</th></tr></thead><tbody>";
$no=1;
$query = "SELECT * from uji WHERE ( distribusi_tgl<='".$this->ss()."' and distribusi_tgl>='".$this->mm()."') or (terima_tgl<='".$this->ss()."' and terima_tgl>='".$this->mm()."') order by distribusi_tgl desc";
$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{
	
	
echo $uji->uji_target_distribusi($data['id'],$no);
$no+=1; 

}
echo "</tbody></table>

";
	
}			
	

function formdistribusi() {
$id=app_baca("uji","kode='".$_GET['k']."'","id");	
app_update("uji","id='".$_POST['id']."'","distribusi_tgl='".$_POST['distribusi_tgl']."',distribusi_kondisi='".$_POST['distribusi_kondisi']."',distribusi_oleh='".$_POST['distribusi_oleh']."'");

if ($id=="") {echo "Kode Tidak Ditemukan";
echo "<meta http-equiv=\"refresh\" content=\"1; URL=?t=Distribusi\">";
exit;}
if (app_baca("uji","kode='".$_GET['k']."'","terima_tgl")=="") {echo "Penerimaan Sampel Belum Diisi !";
echo "<meta http-equiv=\"refresh\" content=\"3; URL=?t=Distribusi\">";
exit;}

echo "<form><input type=hidden name=t value='FormDistribusi'>Kode Sampel <input type=text name=k autofocus></form>";
$opsi = new opsi();
$sup = new sup();
$uji = new uji();
$db = new database();
$db->connect(app_db());
$query = "SELECT * from uji where id='".$id."' limit 0,1";
$results = $db->get_results( $query );
foreach( $results as $data )
{	
if ($data['distribusi_tgl']=="") {$distribusi_tgl=today();} else {$distribusi_tgl=$data['distribusi_tgl'];}
echo "
<table class=table>

<tr><td width='20%'>Nomor Seri Contoh uji / Kode Sampel</td><td width='5px'>:</td><td><b>".$data['kode']."</b></td></tr>
<tr><td>Jenis Contoh Uji</td><td>:</td><td>".$data['jenis_mp']."</td></tr>
<tr><td>Jumlah Contoh Uji</td><td>:</td><td>",app_jml("uji_lot","id_uji='".$data['id']."'","id")." lot/sampel
".	
$uji->uji_lot_terima($id)."
</td></tr>
<tr><td>Tanggal Terima</td><td>:</td><td>".$data['terima_tgl']."</td></tr>
</table>
<form method='post'>
".$uji->uji_target_distribusi_form($id)."
<input type=hidden name=id value='".$data['id']."'>
Tgl Distribusi <input type='date' value='".$distribusi_tgl."' name='distribusi_tgl'> Kondisi Sampel <select name='distribusi_kondisi' id='sle2'> <option value='".$data['distribusi_kondisi']."'>".$data['distribusi_kondisi']."</option><option value='Baik'>Baik</option><option value='Rusak'>Rusak</option></select> <select name='distribusi_oleh' id='sle1'>".karyawan_opt($data['distribusi_oleh'])."</select> <input type='submit' value='Simpan'>
<a target='_blank' href='print/distribusi.php?&id=".$id."'>Print</a></form>

<b>Analis</b>
<form method='post' target=iframe action='exe/uji_analis.php?id=".$id."'><select name='analis' id='sct1'>".karyawan_opt($serahkan_oleh)."</select> <input type='submit' value='Tambah' name='submit' onClick=\"javascript:requestContent('ajx/uji_analis.php?id=".$id."','uji_analis'); \"> <input type='hidden' value='".$id."' name='id'> <a onClick=\"javascript:requestContent('ajx/uji_analis.php?id=".$id."','uji_analis'); \">Refresh</a> </form>
<div id='uji_analis'>
".$uji->uji_analis($id)."</div>

<center><a href='?t=Distribusi'>Selesai</a></center>
";
}
}		
	
function pengujian() {
$uji = new uji();
$db = new database();
$db->connect(app_db());
echo "
<form><input type=hidden name=t value='Pengujian'>Kode Sampel <input type=text name=k autofocus></form>
".$this->form_periode()."
<table class=table id=dt1 width=100%>
<thead>
<tr><th>NO URUT</th><th>KODE SAMPEL</th><th>JENIS MEDIA PEMBAWA</th><th>TGL DISTRIBUSI</th><th>KODE TARGET</th><th>TARGET OPTK / 
HPH(K)</th><th>JENIS</th><th>METODE PENGUJIAN</th><th>PREPARASI</th><th>PENGUJI</th><th>KODE LOT</th><th>NAMA LOT</th><th>HASIL UJI</th><th></th></tr></thead><tbody>";
$no=1;
if ($_GET['k']=="") {$wh="distribusi_tgl<='".$this->ss()."' and distribusi_tgl>='".$this->mm()."'";} else {$wh="kode='".$_GET['k']."'";}
$query = "SELECT * from uji WHERE ".$wh." order by distribusi_tgl desc";
$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{
$td="<td>".$no."</td><td>".$data['kode']."</td><td>".$data['komoditi']."</td><td>".$data['distribusi_tgl']."</td>";	
echo $uji->uji_pengujian($data['id'],$td);
	
$no+=1; 

}
echo "</tbody></table>";
	
}			
	

	
function formpengujian() {
$idt=app_baca("uji_target","target_kode='".$_GET['k']."'","idt");	
if ($idt=="") {echo "Kode Tidak Ditemukan";
echo "<meta http-equiv=\"refresh\" content=\"1; URL=?t=Pengujian\">";
exit;}
$uji = new uji();
$db = new database();
$db->connect(app_db());
echo "<form><input type=hidden name=t value='FormPengujian'>Kode Target Uji <input type=text name=k></form>
<table class=table width=100%>
<thead>
<tr><th>NO URUT</th><th>KODE SAMPEL</th><th>JENIS MEDIA PEMBAWA</th><th>TGL DISTRIBUSI</th><th>KODE TARGET</th><th>TARGET OPTK / 
HPH(K)</th><th>JENIS</th><th>METODE PENGUJIAN</th><th>PREPARASI</th><th>PENGUJI</th></tr></thead><tbody>";
$no=1;
$query = "SELECT * from uji JOIN uji_target ON uji.id=uji_target.id_uji WHERE target_kode='".$_GET['k']."'";
$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{
echo "<tr><td>".$no."</td><td>".$data['kode']."</td><td>".$data['komoditi']."</td><td>".$data['distribusi_tgl']."</td><td>".$data['target_kode']."</td><td>".app_baca("m_optk","id='".$data['id_target']."'","nama_latin")."</td><td>".app_baca("m_optk","id='".$data['id_target']."'","jenis")."</td><td><b>".app_baca("m_metode","id='".$data['id_metode']."'","metode")."</b></td><td>".db_baca("user_login","karyawan","id='".$data['preparasi']."'","nama")."</td><td>".db_baca("user_login","karyawan","id='".$data['penguji']."'","nama")."</td></tr>";	
$preparasi=$data['preparasi'];
$penguji=$data['penguji'];
$penyelia=$data['penyelia'];
$pr=app_baca("m_metode","id='".$data['id_metode']."'","print");
$id=$data['id_uji'];
$no+=1; 
$m=$data['id_metode'];
}
echo "</tbody></table>";

if ($m=="4") { 
$uji->elisa_data($idt);

$h1="<th colspan=5>HASIL UJI ELISA</th>";
$h2="<tr><th>Nilai 1</th><th>Nilai 2</th><th>Warna 1</th><th>Warna 2</th><th>Ket</th></tr>";
} 

elseif ($m=="5") { 
$h1="<th>FOTO PCR</th>";
} 

else {
	$h1="<th colspan=4>TAMBAH STADIA</th><th rowspan=2>TAMBAH TEMUAN</th><th rowspan=2>&nbsp;&nbsp;HASIL&nbsp;UJI&nbsp;/&nbsp;TEMUAN&nbsp;&nbsp;</th>";
	$h2="<tr><th>Te</th><th>La</th><th>Pu</th><th>Im</th></tr>";
	}

echo "
<table class=table>
<thead>
<tr><th rowspan=2>NO</th><th rowspan=2>KODE LOT</th><th rowspan=2>NAMA LOT</th>".$h1."<th rowspan=2>TGL SELESAI UJI</th><th rowspan=2>KESIMPULAN</th></tr>
".$h2."
</thead><tbody>";
$uji->uji_pengujian_form($data['id'],$idt,$m);	
echo "</tbody></table>
<form method='post' target='iframe' action='exe/uji_uj.php'><input type=hidden name=idt value='".$idt."'>
Preparasi <select name='preparasi' id='sle2' onchange=\"javascript:this.form.submit();\">".karyawan_opt($preparasi)."</select>
Analis <select name='penguji' id='sle3' onchange=\"javascript:this.form.submit();\">".karyawan_opt($penguji)."</select>
Penyelia <select name='penyelia' id='sle1' onchange=\"javascript:this.form.submit();\">".karyawan_opt($penyelia)."</select>
<a target='_blank' href='print/uji_".$pr.".php?&id=".$id."&idt=".$idt."'>Print</a></form>
<center><a href='?t=Pengujian&k=".$data['kode']."'>Selesai</a></center>
<br><br><br><br><br><br><br><br><br><br><br><br><br>
";
}			
	
	
function hasil() {
$uji = new uji();
$sup = new sup();
$db = new database();function uji_hasil($id) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * from uji_target join m_optk ON uji_target.id_target=m_optk.id where id_uji='".$id."' order by jenis,nama_latin";
$results = $db->get_results( $query );

foreach( $results as $data )
{
$n++;

//echo "<tr><td>".$data['target_kode']."</td><td>".$data['nama_latin']."</td><td>".app_baca("m_metode","id='".$data['id_metode']."'","metode")."</td><td>".db_baca("user_login","karyawan","id='".$data['preparasi']."'","nama")."</td><td>".db_baca("user_login","karyawan","id='".$data['penguji']."'","nama")."</td></tr>";
//$this->uji_pengujian_lot($id,$td,$td2,$n,$data['target_kode'],$data['idt']);
}

}
$db->connect(app_db());
echo "
<form><input type=hidden name=t value='FormHasil'>Kode Sampel <input type=text name=k autofocus></form>
".$this->form_periode()."
<table class=table id=dt1 width=100%>
<thead>
<tr><th>No Urut</th><th>Tanggal Terima</th><th>Identitas Pemilik</th><th>Alamat</th><th>No Agenda</th><th>Media Pembawa</th><th>Jumlah Lot</th><th>Nomor Contoh Uji</th><th>Negara Asal/Tujuan</th><th>Target OPTK/HPHK</th><th>Hasil Uji (%)</th><th></th></tr>
</thead><tbody>";
$no=1;
$query = "SELECT * from uji WHERE hasil_tgl<='".$this->ss()."' and hasil_tgl>='".$this->mm()."' order by hasil_tgl desc";
$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{
$lot=app_jml("uji_lot","id_uji='".$data['id']."'","id");
$trg=app_jml("uji_target","id_uji='".$data['id']."'","idt");
echo "<tr valign='top'><td>".$no."</td><td>".$data['terima_tgl']."</td><td>".$data['kirim_jab']."</td><td>".$data['alamat']."</td><td align=center>".$data['kode']."</td><td>".$data['komoditi']."</td><td align=center>".$lot."</td><td>".$data['kirim_nomor']."".$sup->no_srt_kirim($data['id'],$data['ll'])."</td><td>".$data['asal']."</td><td>".nl2br($uji->uji_target_print($data['id']))."</td></td><td>".$uji->uji_hasil_persen($data['id'],($trg*$lot))."</td><td><a target='_blank' href='print/hasil.php?&id=".$data['id']."'>Print</a> <a href='?t=FormHasil&k=".$data['kode']."'>Edit</a></td></tr>";

$no+=1; 

}
echo "</tbody></table>";
	
}	
	
function formhasil() {
$id=app_baca("uji","kode='".$_GET['k']."'","id");	
if ($id=="") {echo "Kode Tidak Ditemukan";
echo "<meta http-equiv=\"refresh\" content=\"1; URL=?t=Hasil\">";
exit;}
$uji = new uji();
$sup = new sup();
$db = new database();
$db->connect(app_db());
echo "
<form><input type=hidden name=t value='FormHasil'>Kode Sampel <input type=text name=k></form>
<table class=table width=100%>
<thead>
<tr><th>No Urut</th><th>Tanggal Terima</th><th>Identitas Pemilik</th><th>Alamat</th><th>No Agenda</th><th>Media Pembawa</th><th>Jumlah Lot</th><th>Sumber</th><th>Nomor Contoh Uji</th><th>Negara Asal/Tujuan</th></tr>
</thead><tbody>";
$no=1;
$query = "SELECT * from uji WHERE id='".$id."'";
$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{
$lot=app_jml("uji_lot","id_uji='".$data['id']."'","id");
$trg=app_jml("uji_target","id_uji='".$data['id']."'","idt");
echo "<tr valign='top'><td>".$no."</td><td>".$data['terima_tgl']."</td><td>".$data['kirim_jab']."</td><td>".$data['alamat']."</td><td align=center>".$data['kode']."</td><td>".$data['komoditi']."</td><td align=center>".$lot."</td><td>".app_baca("m_ll","id='".$data['ll']."'","ll")."</td><td>".$data['kirim_nomor']."".$sup->no_srt_kirim($data['id'],$data['ll'])."</td><td>".$data['asal']."</td></tr>";

$no+=1; 

}
echo "</tbody></table><table class=table width=100%>
<tr><th>KODE TARGET</th><th>TARGET OPTK / 
HPH(K)</th><th>METODE PENGUJIAN</th><th>PREPARASI</th><th>PENGUJI</th><th>NO</th><th>KODE LOT</th><th>NAMA LOT</th><th>TGL SELESAI UJI</th><th>HASIL UJI</th></tr>";
$uji->uji_hasil($id);	
echo "</tbody></table>
<form method='post' target='iframe' action='exe/uji_has.php'><input type=hidden name=id value='".$data['id']."'>
Tgl Hasil: <input type='date' value='".$data['hasil_tgl']."' name='hasil_tgl'> 
<select name='iso' id='sle2'> <option value='".$data['iso']."'>".$data['iso']."</option><option value='ISO'>ISO</option><option value='NO-ISO'>NO-ISO</option></select>
Tandatangan: <select name='hasil_oleh' id='sle1'>".karyawan_opt($data['hasil_oleh'])."</select> M. Teknis <select name='mt' id='sle4'>".karyawan_opt($data['mt'])."</select> <input type='submit' value='Simpan'>
<a target='_blank' href='print/hasil.php?&id=".$id."'>Print</a></form>
";	
}	
	
	
	
	
	
function m_optk() {
$opsi = new opsi();
$db = new database();
$db->connect(app_db());
echo "
<script>
function FillBilling(f,d) {
var dt=d;
f.nama.value = dt;
}
</script>";

echo "<form method=post target='iframe' action='exe/m_optk.php' id=f>Tambah: Nama Ilmiah <input type=text name=nama ><select id='select2' name='jenis'>".$opsi->m_jenis("Serangga")."</select><input type=submit value='exe'></form></a>
<table class=table id='dt1' width=100%>

<thead>
<tr><th>NO</th><th>NAMA ILMIAH</th><th>JENIS</th><th>EDIT</th></tr></thead>
<tbody>";
$no=1;
$query = "SELECT id,nama_latin,jenis from m_optk order by nama_latin";
$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{

if ($data['kode']=="") {} else {$kode=$data['kode'];}

echo "<tr valign='top'><td>".$no."</td><td>".$data['nama_latin']."</td><td>".$data['jenis']."</td><td><input type='radio' onclick=\"FillBilling(f,'".$data['nama_latin']."')\"></td></tr>";

$no+=1; 

}
echo "</tbody></table>";
	
}		
	
}
