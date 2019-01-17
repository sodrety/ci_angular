<?php
$tgl=$_GET['tgl'];
$id_lokasi=$_GET['id_lokasi'];
?><html>
<head>
<style>
* {font-family:arial;font-size:14px;}
h2 {font-size:21px;}
.table {border-top:1px solid #000;border-left:1px solid #000;border-collapse: separate;}
.table td, .table th {border-bottom:1px solid #000;border-right:1px solid #000;padding:3px;}
</style>
</head>
<body>
<?php
require_once( '../class/class.php' );
$db = new database();
$db->connect(app_db());
if ($id_lokasi!="") {$whl=""; }
$query = "SELECT * FROM sla_fisik WHERE kt9 LIKE '".$tgl."%' and id_lokasi='".$id_lokasi."' order by no_reg";
$results = $db->get_results( $query );
$lokasi=app_baca("lokasi","id_lokasi='".$id_lokasi."'","lokasi");
echo "<h2>
LAPORAN PELAKSANAAN KEGIATAN TINDAKAN KARANTINA TUMBUHAN <br>TPK/WILAYAH KERJA : ".$lokasi."<br>
TANGGAL ".strtoupper(tgl_p($tgl))."</h2>

<table class='table' width=100% id=example2 cellspacing='0'>
<thead>
<tr><th>NO</th><th>NO DOKUMEN</th><th>NO SERI</th><th>SAMPLING</th><th>TOTAL</th><th>STATUS</th><th>WAKTU AWAL (DP-1)</th><th>WAKTU NSW (KT-9)</th><th>DURASI (MENIT)</th></tr>
</thead>

<tbody>";
foreach( $results as $data )
{
	$n++;
$du=durasi($data['dp1'],$data['kt9']);
echo "<tr valign='top' align=center><td>$n</td><td>".$data['no_reg']."</td><td>".$data['seri']."</td><td>".$data['sampling']."</td><td>".$data['total']."</td><td>".$data['status']."</td><td>".$data['dp1']."</td><td>".$data['kt9']."</td><td>".$du."</td></tr>";
$sam+=$data['sampling'];
$to+=$du;
$kon+=$data['total'];
if ($du<=(24*60)) {$cap+=1;}
}
echo "</tbody><tfoot>
<tr valign='top' align=center><td></td><td></td><td></td><td><b>".rp($sam)."</b></td><td><b>".rp($kon)."</b></td><td></td><td></td><td></td><td><b>".des($to/$n)."</b></td></tr>
</tfoot>
</table>
Capaian SLA : <b>".des(($cap/$n)*100)." %</b>
<br>";
$jab=app_baca("sla_f_ttd","id='".$tgl."_".$id_lokasi."'","jab");
$id_popt=app_baca("sla_f_ttd","id='".$tgl."_".$id_lokasi."'","id_popt");
$nama_popt=app_baca("popt","id='".$id_popt."'","nama");
$nip_popt=db_baca("user_login","karyawan","id='".$id_popt."'","nip");
echo "<br>
<table align=right><tr><td>Jakarta, ".tgl_p($tgl)."<br>".$jab."<br><br><br><br>
".$nama_popt."<br>NIP. ".$nip_popt."<td></tr></table>

";
?>
</body>
</html>
