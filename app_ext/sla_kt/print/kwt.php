<?php
$id=$_GET['id'];
?><html>
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
