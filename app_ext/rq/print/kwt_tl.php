<html>
<head>
<style>
html, body {margin:0;padding:0;background-size: 210mm 80mm;}
* {font-family:arial;}
.no {position:fixed;left:55mm;top:6mm;width:50mm;font-size:21px;}
.dari {position:fixed;left:84mm;top:15mm;width:115mm;font-size:13px;}
.jumlah {position:fixed;left:84mm;top:24mm;width:115mm;font-size:13px;}
.untuk {position:fixed;left:50mm;top:32mm;width:145mm;font-size:13px;}
.bendahara {position:fixed;left:133mm;top:49mm;width:65mm;font-size:13px;text-align:center;}
.rp {position:fixed;left:58mm;top:65mm;width:50mm;font-size:17px;}
.setuju {position:fixed;left:5mm;top:6mm;width:40mm;font-size:9px; text-align:center;border:2px solid #000;font-weight:700;}
</style>
</head>
<body>
<?php
require_once( '../class/class.php' );
$id=$_GET['id'];
$rp=rq_baca("cost","id='".$id."'","harga");
$no=rq_baca("cost","id='".$id."'","no");
echo "<div class=no>".$id."</div>
<div class=dari>Pejabat Pembuat Komitmen ".rq_baca("global","kolom='nama_unit'","isi")."</div>
<div class=jumlah>".terbilang($rp)."</div>
<div class=untuk>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ".rq_baca("pok","no='".$no."'","uraian")." ".rq_baca("cost","id='".$id."'","untuk")." Akun ".rq_baca("pok","no='".$no."'","mak")." pada ".rq_baca("global","kolom='nama_unit'","isi")."</div>
<div class=bendahara>".rq_baca("global","kolom='tempat'","isi").", ".tgl_p(rq_baca("cost","id='".$id."'","tgl"))."<br>Bendahara Pengeluaran,<br><br><br><br><u>".rq_baca("global","kolom='bendahara_nama'","isi")."</u><br>NIP. ".rq_baca("global","kolom='bendahara_nip'","isi")."</div>
<div class=rp><b>".rp($rp).",-</b></div>
<div class=setuju>SETUJU DIBAYAR<br>PEJABAT PEMBUAT KOMITMEN<br>".strtoupper(rq_baca("global","kolom='nama_unit'","isi"))."<br><br><br><br><u>".strtoupper(rq_baca("pok","no='".$no."'","ppk_nama"))."</u><br>NIP. ".rq_baca("pok","no='".$no."'","ppk_nip")."
</div>
";
?>
</body>
</html>
