<html>
<head>
<style>
html,body {margin:0;padding:0;background-size: 210mm 80mm;}

* {font-family:arial;}
.no {position:fixed;right:155mm;top:60mm;width:33mm;font-size:21px;}
.dari {position:fixed;right:15mm;top:70mm;width:140mm;font-size:13px;}
.jumlah {position:fixed;right:15mm;top:79mm;width:140mm;font-size:13px;}
.untuk {position:fixed;right:15mm;top:90mm;width:180mm;font-size:13px;}
.bendahara {position:fixed;right:15mm;top:110mm;width:65mm;font-size:13px;text-align:center;}
.rp {position:fixed;right:135mm;top:125mm;width:52mm;font-size:17px;}
.setuju {position:fixed;right:200mm;top:61mm;width:45mm;font-size:9px; text-align:center;border:2px solid #000;font-weight:700;}
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
<div class=untuk>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ".rq_baca("pok","no='".$no."'","uraian")." ".rq_baca("cost","id='".$id."'","untuk")." Akun ".rq_baca("pok","no='".$no."'","mak")." pada ".rq_baca("global","kolom='nama_unit'","isi")."</div>
<div class=bendahara>".rq_baca("global","kolom='tempat'","isi").", ".tgl_p(rq_baca("cost","id='".$id."'","tgl"))."<br>Bendahara Pengeluaran,<br><br><br><br><u>".rq_baca("global","kolom='bendahara_nama'","isi")."</u><br>NIP. ".rq_baca("global","kolom='bendahara_nip'","isi")."</div>
<div class=rp><b>".rp($rp).",-</b></div>
<div class=setuju>SETUJU DIBAYAR<br>PEJABAT PEMBUAT KOMITMEN<br>".strtoupper(rq_baca("global","kolom='nama_unit'","isi"))."<br><br><br><br><u>".strtoupper(rq_baca("pok","no='".$no."'","ppk_nama"))."</u><br>NIP. ".rq_baca("pok","no='".$no."'","ppk_nip")."
</div>
";
?>
</body>
</html>
