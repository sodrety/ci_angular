<?php include "../class/class.php"; 
$id=$_GET['id'];
$id_spt=$_GET['id_spt'];
?>
<?php
$wid="575px"; $m="margin: 5mm 0 0 27mm;";
echo "
<style>
* { font-family:arial, sans; font-size:13px;}
body { $m width:$wid;}
#judul { text-align:center;}
td {padding:2;}
#lam * {font-size:9px;}
#border { border-top:1px solid #000; border-right:1px solid #000; }
#bor2 { border:1px solid #000; }
#borl { border-left:1px solid #000; }
#border * td{ border-left:1px solid #000; padding:4px;}
#bo td {border-bottom:1px solid #000;}
#bot td {border-top:1px solid #000;}
</style>";
?>
<body>
<?php
if (app_baca("spt_petugas","id='$id'","no_spd")<=0) {$spdnya=" &nbsp;  &nbsp; ";} else {
	$spdnya=app_baca("spt_petugas","id='$id'","no_spd").app_baca("spt_petugas","id='$id'","no_spd_alp");
}

 echo "
 <center>
 <img src=garuda.jpg height=70px><br>MENTERI KEUANGAN<br>REPUBLIK INDONESIA
 </center>

<table width='100%' cellspacing=0 cellpadding=0>


<tr valign='top'><td align=left rowspan=3>Kementerian Negara/Lembaga:<br>
Kementerian Pertanian<br>
Badan Karantina Pertanian<br>
Balai Uji Terap Teknik dan Metode Karantina Pertanian
</td>

<td width='100px'>Lembar Ke&nbsp;</td><td>:&nbsp;</td><td width='100px'>1&nbsp;</td></tr>
<tr><td>Kode No&nbsp;</td><td>:&nbsp;</td><td> &nbsp;</td></tr>
<tr valign='top'><td>Nomor&nbsp;</td><td>:&nbsp;</td><td>";
echo $spdnya."/".str_replace(" ","&nbsp;",app_baca("spt_petugas","id='$id'","spd"));
echo "".substr (tgl(app_baca("spt","id='$id_spt'","tgl")), 3, 7)."</td></tr>
</table>

"; ?>
</div><br>
<div id=judul><b>SURAT PERJALANAN DINAS (SPD)</b></div><br>
<?php
$mak=app_baca("spt","id='$id_spt'","mak");
$tahun=app_baca("spt","id='$id_spt'","tahun");
if ($tahun>="2018") {$mak=db_baca(real_db()."_".$tahun,"pok","no='".$mak."'","mak");}
$ppkn=db_baca(real_db(),"karyawan","id='".app_baca("spt","id='$id_spt'","ppk_nama")."'","nama");
$ppknip=db_baca(real_db(),"karyawan","id='".app_baca("spt","id='$id_spt'","ppk_nama")."'","nip");

$tgl=app_baca("spt","id='$id_spt'","tgl");

$lama=lama(app_baca("spt","id='$id_spt'","waktu_mulai"),app_baca("spt","id='$id_spt'","waktu_selesai"));
echo "<table width='100%'  cellspacing=0 cellpadding=0 id=border>
<tr id=bo valign='top'><td align=center>1&nbsp;</td><td width='43%'>Pejabat Pembuat Komitmen&nbsp;</td><td colspan=2  width='55%'>Balai Uji Terap Teknik dan Metode Karantina Pertanian&nbsp;</td></tr>
<tr id=bo valign='top'><td align=center>2&nbsp;</td><td>Nama/NIP Pegawai yang melaksanakan
perjalanan dinas&nbsp;</td><td colspan=2>".app_baca("spt_petugas","id='$id'","nama")." / ".app_baca("spt_petugas","id='$id'","nip")."&nbsp;</td></tr>
<tr valign='top'><td align=center>3&nbsp;</td><td>a. Pangkat dan Golongan&nbsp;</td><td colspan=2>".pangkat(app_baca("spt_petugas","id='$id'","gol"))." (".app_baca("spt_petugas","id='$id'","gol").")&nbsp;</td></tr>
<tr valign='top'><td align=center>&nbsp;</td><td>b. Jabatan/Instansi&nbsp;</td><td colspan=2>".app_baca("spt_petugas","id='$id'","jab")."&nbsp;<br>Balai Uji Terap Teknik dan Metode Karantina Pertanian</td></tr>
<tr id=bo valign='top'><td align=center>&nbsp;</td><td>c. Tingkat Biaya Perjalanan Dinas&nbsp;</td><td colspan=2>&nbsp;</td></tr>
<tr id=bo valign='top'><td align=center>4&nbsp;</td><td>Maksud Perjalanan Dinas&nbsp;</td><td colspan=2>
".app_baca("spt","id='$id_spt'","tujuan")."<br>
Berdasarkan Surat Tugas<br> No ".$no_spt=app_baca("spt","id='$id'","no_spt")."/".app_baca("spt_global","name='nomor'","value")."/".substr($tgl,5,2)."/".substr($tgl,0,4)." Tanggal ".tgl_p(app_baca("spt","id='$id_spt'","tgl"))."
</td></tr>
<tr id=bo valign='top'><td align=center>5&nbsp;</td><td>Alat angkutan yang dipergunakan&nbsp;</td><td colspan=2>".app_baca("spt","id='$id_spt'","angkutan")."&nbsp;</td></tr>
<tr valign='top'><td align=center>6&nbsp;</td><td>a. Tempat berangkat&nbsp;</td><td colspan=2>".app_baca("spt","id='$id_spt'","dari")."&nbsp;</td></tr>
<tr id=bo valign='top'><td align=center>&nbsp;</td><td>b. Tempat Tujuan&nbsp;</td><td colspan=2>".app_baca("spt","id='$id_spt'","lokasi").", ".app_baca("spt","id='$id_spt'","kota")."&nbsp;</td></tr>
<tr valign='top'><td align=center>7&nbsp;</td><td>a. Lamanya Perjalanan Dinas&nbsp;</td><td colspan=2>$lama (".terbilang($lama).") hari</td></tr>
<tr valign='top'><td align=center>&nbsp;</td><td>b. Tanggal berangkat&nbsp;</td><td colspan=2>".tgl_p(app_baca("spt","id='$id_spt'","waktu_mulai"))."&nbsp;</td></tr>
<tr id=bo valign='top'><td align=center>&nbsp;</td><td>c. Tanggal harus kembali/tiba di tempat baru *)&nbsp;</td><td colspan=2>".tgl_p(app_baca("spt","id='$id_spt'","waktu_selesai"))."&nbsp;</td></tr>
<tr valign='top'><td align=center>8&nbsp;</td><td>Pengikut : Nama&nbsp;</td><td>Tanggal Lahir&nbsp;</td><td>Keterangan&nbsp;</td></tr>
<tr id=bo valign='top'><td align=center>&nbsp;</td><td>1.<br>2.<br>3. &nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr valign='top'><td align=center>9&nbsp;</td><td>Pembebanan Anggaran&nbsp;</td><td colspan=2>&nbsp;</td></tr>
<tr valign='top'><td align=center>&nbsp;</td><td>a. Instansi&nbsp;</td><td colspan=2>Balai Uji Terap Teknik dan Metode Karantina Pertanian&nbsp;</td></tr>
<tr id=bo valign='top'><td align=center>&nbsp;</td><td>b. Akun&nbsp;</td><td colspan=2>"
.$mak."&nbsp;</td></tr>
<tr id=bo valign='top'><td align=center>10&nbsp;</td><td>Keterangan lain-lain&nbsp;</td><td colspan=2>&nbsp;</td></tr>
</table>
coret yang tidak perlu<br>
<table align='right'>
<tr valign='top'><td>
Dikeluarkan di Bekasi, <br>
Tanggal 
".tgl_p(app_baca("spt","id='$id_spt'","tgl"))."
<br>Pejabat Pembuat Komitmen<br><br><br><br>
".$ppkn."<br>
NIP. ".$ppknip."&nbsp;</td></tr>
</table>

";
//echo tgl_aju("2016-01-01");

?>

</body></html>