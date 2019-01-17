<?php
$id=$_GET['id'];
$p=$_GET['p'];
header("location:kwt_pdf.php?id=".$id."");
if ($p=="") {
echo "<h2>
<a href='kwt.php?id=".$id."&p=tl'>TOP LEFT</a><br>
<a href='kwt.php?id=".$id."&p=ml'>MIDLE LEFT</a> <a href='kwt.php?id=".$id."&p=mr'>MIDLE RIGHT</a><br>
<a href='kwt.php?id=".$id."&p=wh'>WAHYU</a>
</h2><br>

";
exit;}
if ($p=="ml") {
$style="<style>
html,body {margin:0;padding:0;background-size: 210mm 80mm;}

* {font-family:arial;}
.no {position:fixed;left:65mm;top:61mm;width:50mm;font-size:21px;}
.dari {position:fixed;left:94mm;top:70mm;width:115mm;font-size:13px;}
.jumlah {position:fixed;left:94mm;top:79mm;width:115mm;font-size:13px;}
.untuk {position:fixed;left:60mm;top:87mm;width:180mm;font-size:13px;}
.bendahara {position:fixed;left:143mm;top:104mm;width:65mm;font-size:13px;text-align:center;}
.rp {position:fixed;left:68mm;top:120mm;width:50mm;font-size:17px;}
.setuju {position:fixed;left:5mm;top:61mm;width:40mm;font-size:9px; text-align:center;border:2px solid #000;font-weight:700;}
</style>";
}
if ($p=="tl") {
$style="<style>
html, body {margin:0;padding:0;background-size: 210mm 80mm;}
* {font-family:arial;}
.no {position:fixed;left:55mm;top:6mm;width:50mm;font-size:21px;}
.dari {position:fixed;left:84mm;top:15mm;width:115mm;font-size:13px;}
.jumlah {position:fixed;left:84mm;top:24mm;width:115mm;font-size:13px;}
.untuk {position:fixed;left:50mm;top:32mm;width:145mm;font-size:13px;}
.bendahara {position:fixed;left:133mm;top:49mm;width:65mm;font-size:13px;text-align:center;}
.rp {position:fixed;left:58mm;top:65mm;width:50mm;font-size:17px;}
.setuju {position:fixed;left:5mm;top:6mm;width:40mm;font-size:9px; text-align:center;border:2px solid #000;font-weight:700;}
</style>";
}
if ($p=="mr") {
$style="<style>
html,body {margin:0;padding:0;background-size: 210mm 80mm;}

* {font-family:arial;}
.no {position:fixed;right:155mm;top:63mm;width:33mm;font-size:21px;}
.dari {position:fixed;right:15mm;top:73mm;width:140mm;font-size:13px;}
.jumlah {position:fixed;right:15mm;top:80mm;width:140mm;font-size:13px;}
.untuk {position:fixed;right:15mm;top:92mm;width:180mm;font-size:13px;}
.bendahara {position:fixed;right:15mm;top:110mm;width:65mm;font-size:13px;text-align:center;}
.rp {position:fixed;right:130mm;top:120mm;width:52mm;font-size:17px;}
.setuju {position:fixed;right:200mm;top:52mm;width:45mm;font-size:9px; text-align:center;border:2px solid #000;font-weight:700;}
</style>";
}
?>
<html>
<head>
<?php echo $style;?>
</head>
<body>
<?php
require_once( '../class/class.php' );
$id=$_GET['id'];
$rp=rq_baca("cost","id='".$id."'","harga");
$no=rq_baca("cost","id='".$id."'","no");
$ttd=rq_baca("cost","id='".$id."'","ttd");
if ($ttd=="Yang Membayarkan : Bendahara Pengeluran") {$td="Yang Membayarkan<br>Bendahara Pengeluaran,<br><br><br><br><br><u>".rq_baca("global","kolom='bendahara_nama'","isi")."</u><br>NIP. ".rq_baca("global","kolom='bendahara_nip'","isi")."";} else {$td="<br><br><br><br><br><br><u>".$ttd."</u>";}
echo "<div class=no>".$id."</div>
<div class=dari>Pejabat Pembuat Komitmen ".rq_baca("global","kolom='nama_unit'","isi")."</div>
<div class=jumlah>".terbilang($rp)." Rupiah</div>
<div class=untuk>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ".rq_baca("cost","id='".$id."'","untuk")." an ".rq_baca("cost","id='".$id."'","kepada").". Akun ".rq_baca("pok","no='".$no."'","mak")." (".rq_baca("pok","no='".$no."'","dana").") pada ".rq_baca("global","kolom='nama_unit'","isi")."</div>
<div class=bendahara>".rq_baca("global","kolom='tempat'","isi").", ".tgl_p(rq_baca("cost","id='".$id."'","tgl"))."<br>".$td."</div>
<div class=rp><b>".rp($rp).",-</b></div>

<!--<div class=setuju>SETUJU DIBAYAR<br>PEJABAT PEMBUAT KOMITMEN<br>".strtoupper(rq_baca("global","kolom='nama_unit'","isi"))."<br><br><br><br><u>".strtoupper(rq_baca("pok","no='".$no."'","ppk_nama"))."</u><br>NIP. ".rq_baca("pok","no='".$no."'","ppk_nip")."
</div>-->
";
?>
</body>
</html>
