<?php include "../class/class.php"; 
$id_sptb=$_GET['id_sptb'];
echo "";
?>
<html><head>
<style>
* { font-family:arial, sans;font-size:12px; }
body { margin:10mm 0 0 25mm; width:630px; text-align:justify;}
.judul {text-align:center;}
.judul b {text-decoration:underline;font-size:15px;}
.permenkeu *{font-size:8px; padding:0;margin:0;text-align:justify; }
.clear {clear: both; }
.hr {clear: both; border-top:1px solid #333;}
.border {border-top:1px solid #333;border-left:1px solid #333;}
.border tr td,.border tr th {border-bottom:1px solid #333;border-right:1px solid #333; padding:3px;font-size:11px;}
#kanan {float:right;}
.next {bottom:0px;left:0px;right:0px;height:30px; position:fixed;display:block; color:#fff; text-align:center;}
.next:hover{color:#000;background:#ccc;}
</style>

</head>
<body>
<?php

$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM cost join pok ON cost.no=pok.no WHERE cost.id_sptb='".$id_sptb."' order by pok.mak";
$results = $db->get_results( $query );
$pg=$_GET['p'];
$hal=15;
$a=($pg-1)*$hal;
$b=$pg*$hal;
//echo $a." ".$b;
foreach( $results as $data )
{

$n++;
$mak=rq_baca("pok","no='".$data['no']."'","mak");
$no=$data['no'];
$p=strlen($mak);
$akun=substr ($mak, ($p-7), 6);

if ($n>$a and $n<=$b) {
$row.= "<tr valign=top><td>$n</td><td>".$akun."</td><td>".$data['kepada']."</td><td>".str_replace("- ","",rq_baca("pok","no='".$data['no']."'","uraian"))." ".$data['untuk']."</td><td align=right>".rp($data['harga'])."</td><td align=right>".rp($data['ppn'])."</td><td align=right>".rp($data['pph'])."</td></tr>";
}
if ($n<=$a) {
$rpp+=$data['harga'];
$ppnp+=$data['ppn'];
$pphp+=$data['pph'];
}

if ($n<=$b) {
$rp+=$data['harga'];
$ppn+=$data['ppn'];
$pph+=$data['pph'];
}
}
$tpg=$n/$hal;

if (rq_baca("sptb","id_sptb='".$id_sptb."'","cara")=="LS") {
$tgl=rq_baca("global","kolom='tempat'","isi").", ".tgl_p(rq_baca("sptb","id_sptb='".$id_sptb."'","tgl"));	
}	
$ttdppk="<table><tr valign='top'><td align=center>".$tgl."<br>Pejabat Pembuat Komitmen<br><br><br><br><u>".rq_baca("pok","no='".$no."'","ppk_nama")."</u><br>NIP. ".rq_baca("pok","no='".$no."'","ppk_nip")."</td></tr></table>";	
$ttdb="<table><tr valign='top'><td align=center>".rq_baca("global","kolom='tempat'","isi").", ".tgl_p(rq_baca("sptb","id_sptb='".$id_sptb."'","tgl"))."<br>Bendahara Pengeluaran<br><br><br><br><u>".rq_baca("global","kolom='bendahara_nama'","isi")."</u><br>NIP. ".rq_baca("global","kolom='bendahara_nip'","isi")."</td></tr></table>";

if (rq_baca("sptb","id_sptb='".$id_sptb."'","cara")=="GU") {
$ttd1=$ttdppk;$ttd2=$ttdb;
} else {
$ttd2=$ttdppk;
}
if ($pg==1) {
echo "
<div class=judul>
<b>SURAT PERNYATAAN TANGGUNG JAWAB BELANJA</b><br>
No :".rq_baca("sptb","id_sptb='".$id_sptb."'","nomor")."/SPTB-".rq_baca("sptb","id_sptb='".$id_sptb."'","cara")."/".rq_baca("global","kolom='kode_satker'","isi")."/".bln_thn_no(rq_baca("sptb","id_sptb='".$id_sptb."'","tgl"))."
</div>
<div class=clear><br><br></div>
<table cellspacing=0 cellpadding=1px>
<tr><td>1.</td><td>Kode Satuan Kerja</td><td>:</td><td>".rq_baca("global","kolom='kode_satker'","isi")."</td></tr>
<tr><td>2.</td><td>Nama Satuan Kerja</td><td>:</td><td>".rq_baca("global","kolom='nama_unit'","isi")."</td></tr>
<tr><td>3.</td><td>Tanggal & Nomor DIPA</td><td>:</td><td>".tgl_p(rq_baca("global","kolom='tgl_dipa'","isi")).", ".rq_baca("global","kolom='no_dipa'","isi")."</td></tr>
<tr><td>4.</td><td>Klasifikasi Anggaran</td><td>:</td><td>".substr ($mak, 0, 8)." / ".substr ($akun, 0, 4)."</td></tr>
</table>
Yang bertandatangan dibawah ini atas nama Kuasa Pengguna Anggaran Satuan Kerja ".rq_baca("global","kolom='nama_unit'","isi")." menyatakan, bahwa saya bertanggungjawab secara formal dan material atas segala pengeluaran yang telah dibayar lunas oleh Bendahara Pengeluaran kepada yang berhak menerima serta kebenaran perhitungan dan setoran pajak yang telah dipungut atas pembayaran tersebut dengan perincian sebagai berikut:<br><br>
"; }

if ($tpg<$pg) {
	$foot="<br>
Bukti-bukti pengeluaran anggaran dan asli setoran pajak (SSP/BPN) tersebut di atas disimpan oleh Pengguna Anggaran/Kuasa Pengguna Anggaran untuk kelengkapan administrasi dan pemeriksaan aparat pengawasan fungsional<br>


Demikian Surat Pernyataan ini kami buat dengan sebenarnya.<br><br>
<table width='100%'>
<tr><td align=left>".$ttd1."


</td><td align=right>".$ttd2."

</td></tr>
</table>";$pnd="";
} else {$pnd="Dipindahkan";$foot="";}
if ($pg>1) {
$thead="<tr valign='top'><td colspan=4 align=center>Jumlah Pindahan</td><td align=right>".rp($rpp)."</td><td align=right>".rp($ppnp)."</td><td align=right>".rp($pphp)."</td></tr>";	
}

 echo "
<table align='center' width='100%' cellpadding='7' cellspacing='0' class=border>
<tr valign='middle'><th rowspan=2 style='width:20px;'>No</th><th rowspan=2 style='width:40px;'>MAK</th><th rowspan=2 style='width:150px;'>Penerima</th><th rowspan=2 style='width:250px;'>Uraian</th><th rowspan=2 style='width:70px;'>Jumlah </th><th colspan=2>Pajak yang dipungut</th></tr>
<tr><th style='width:70px;'>PPN</th><th style='width:70px;'>PPH</th></tr>
".$thead.$row."
<tr valign='top'><td colspan=4 align=center>Jumlah ".$pnd."</td><td align=right>".rp($rp)."</td><td align=right>".rp($ppn)."</td><td align=right>".rp($pph)."</td></tr>
</table>";

echo $foot."

<a href='?id_sptb=".$id_sptb."&p=".($pg+1)."' class=next>&nbsp;</a>

"; 

?>
</body>