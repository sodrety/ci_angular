<?php
include "../class/class.php";
$id=$_GET['id'];
?>
<style>
* {font-size:14px; font-family:arial, sans;}
body { margin:10mm 0 0 10mm; width:190mm;}
#judul {text-decoration:underline;text-align:center; font-weight:700;}
.permenkeu *{font-size:9px; padding:0;margin:0;text-align:justify; }
.clear {clear: both; }
.hr {clear: both; border-top:1px solid #333;}
.bborder {border-top:1px solid #333;border-left:1px solid #333;}
.bborder tr td {border-bottom:1px solid #333;border-right:1px solid #333;}
.noborder tr td {border-bottom:0px solid #fff;border-right:0px solid #fff;}
.cetak {position:fixed; bottom:5mm; left:10mm;}
</style>


<body>
<div class=clear><br></div>

<div class=clear></div>



<?php 
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM cost WHERE id='".$id."'";
$results = $db->get_results( $query );
foreach( $results as $data )
{
	
echo "
<center><b>KEMENTERIAN PERTANIAN<br>BADAN KARANTINA PERTANIAN<br>".strtoupper(rq_baca("global","kolom='nama_unit'","isi"))."</b><br><br>
<u>SURAT PERINTAH BAYAR</u><BR>Tanggal : ".tgl($data['tgl_spby'])."   No. : ".$data['no_spby']."/".rq_baca("global","kolom='kode_surat'","isi")."/".bln_thn_no($data['tgl_spby'])." </center>
<br><br><div style='text-align:justify;' >
Saya yang bertanda tangan di bawah ini selaku Pejabat Pembuat Komitmen memerintahkan Bendahara Pengeluaran agar melakukan pembayaran sejumlah :</div>
<div style='margin:5px 0;'><span style='border-bottom:dotted 1px #555;font-weight:700;'>Rp. ".rp($data['harga'])."</span></div>
<div style='border-bottom:dotted 1px #555;margin:5px 0;'>( ".str_replace("Satu Ribu", "Seribu",rp_terbilang($data['harga'],""))." Rupiah )</div>
<br>
<table width=100%>
<tr valign='top'><td width='20%'>Kepada</td><td width='1%'>:</td><td>
<div style='border-bottom:dotted 1px #555;margin:2px 0;'>".$data['kepada']."&nbsp;</div>
</td></tr>
<tr valign='top'><td>Untuk Pembayaran</td><td>:</td><td>
<div style='border-bottom:dotted 1px #555;margin:2px 0;'>".$data['untuk']."&nbsp;</div>
</td></tr>
</table><br>
<table width='100%'>
<tr valign='top'><td width='15%'>Atas dasar :</td><td width='35%'></td><td width='1%'></td></td><td></tr>
<tr valign='top'><td align='right'>1.</td><td>Kuitansi/bukti pembelian </td><td>:</td><td><div style='border-bottom:dotted 1px #555;margin:2px 0;'>".$data['no_spby']."&nbsp;</div></td></tr>
<tr valign='top'><td align='right'>2.</td><td>Nota/bukti penerimaan barang / jasa </td><td>:</td><td><div style='border-bottom:dotted 1px #555;margin:2px 0;'>".$data['dasar_nota']."&nbsp;</div></td></tr>
<tr valign='top'><td align='right'>(bukti lainnya)</td><td></td><td></td><td></td></tr>
</table>
<br>
<table>
<tr valign='top'><td>Dibebankan pada : </td><td></td><td></td></tr>
<tr valign='top'><td>Kegiatan, output, MAK</td><td>:</td><td>".rq_baca("pok","no='".$data['no']."'","mak")."</td></tr>
<tr valign='top'><td>Kode</td><td>:</td><td></td></tr>
</table>
<br>
<table class=noborder width=100%><tr valign='top'><td>
Setuju/lunas dibayar, tgl ".tgl($data['tgl_spby']).",<br><br>
Bendahara Pengeluaran<br><br><br><br>
<u>".rq_baca("global","kolom='bendahara_nama'","isi")."</u><br>NIP. ".rq_baca("global","kolom='bendahara_nip'","isi")."
</td><td>
Diterima tgl ".tgl($data['tgl_spby'])."<br><br>
Penerima Uang/UMK<br><br><br><br>
<u>".$data['ttd']."</u><br>
</td><td>Bekasi, ".tgl($data['tgl_spby'])."<br><br>
Pejabat Pembuat Komitmen<br><br><br><br>
<u>".rq_baca("global","kolom='ppk_nama'","isi")."</u><br>NIP. ".rq_baca("global","kolom='ppk_nip'","isi")."
</td></tr></table>
</td></tr>
</table>
<div class='cetak'>
<img style='height:10mm;' src='../../../barcode/barcode.php?id=".md5(substr ($data['tgl_spby'], 0, 4).$data['id'])."'><br>
Tgl Cetak : ".tgl2($data['tgl_spby'])." ".dua_angka(rand(8,15))."".date(":i:s")."</div>
";
}
?>
</body>
