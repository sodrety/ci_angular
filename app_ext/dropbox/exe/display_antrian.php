<?php
include "../class/class.php";
function jml_s($s) {
if ($s=="1") {$j=app_jml("barcode","last_antri LIKE '".today()."%' and last_status='1'" ,"id");} 
if ($s=="t" or $s=="2") {$j=app_jml("barcode","last_antri LIKE '".today()."%' and last_status>'2' and last_hasil='Tunda'" ,"id");} 
if ($s=="2") {$j=app_jml("barcode","last_antri LIKE '".today()."%' and last_status>'2' and last_status!='9'" ,"id")-$j;} 
if ($s=="9") {$j=app_jml("barcode","last_antri LIKE '".today()."%' and last_status='9' or (last_status='4' and sppmp='SPPMP')" ,"id");} 
//else {$j=app_jml("barcode","last_status='".$s."' and last_hasil LIKE '%".$h."%' and lintas='I' and ( last_waktu LIKE '".today()."%' or last_antri LIKE '".today()."%' )","id");}
return $j;
}
$db = new database();
$db->connect(app_db());
$no=1;
$query = "SELECT * from barcode WHERE last_status='3' and last_hasil='Tunda' and last_waktu LIKE '".today()."%' order by last_waktu DESC limit 0,15";
$results = $db->get_results( $query );
$n=0;
$s=9;
$d1=jml_s("1");
$d2=jml_s("2");
$d3=jml_s("t");
$d4=jml_s("9");
echo "<table  cellpadding='3' cellspacing='0' width='100%'><thead>
<tr><td align='right' colspan='5'>TOTAL : <b>".($d1+$d2+$d3+$d4)."</b> &nbsp; Dropping: <b class='kuning'>".$d1."</b>, Proses: <b class='hijau'>".$d2."</b>, Ditunda: <b class='red'>".$d3."</b>, Selesai: <b class='biru'>".$d4."</b></td></tr>

<tr><th align='left' width=='10%'>KODE</th><th align='left' width=='10%'>VIA</th><th align='left' width=='40%'>NO AJU</th><th align='left' width=='40%'>PERUSAHAAN</th><th align='left' width=='10%'>STATUS</th></tr>
<tbody>";
foreach( $results as $data )
{
$akun=substr($data['no_aju'],5,7);
if ($data['bidang']=="1") {$b="KH";} elseif ($data['bidang']=="2") {$b="KT";} 
echo "<tr valign='top'><td>".$data['kode']."</td><td>".$b."-".$data['lintas']."-".$data['via']."</td><td>".substr($data['no_aju'],13,22)."</td><td>".substr(app_baca("akun_pj","akun='".$akun."'","perusahaan"),0,25)."</td>
<td $war>".$data['last_hasil']."</td></TR>
";
} 
echo "
<tr><td colspan='5'></td></tr>
<tr><td colspan='5' style='font-size:20px;'>Dokumen KT-2, KH-5, SPPMP, TAGIHAN PNBP dapat didownload di PrioqKlik (http://tanjungpriok.karantina.pertanian.go.id/)</td></tr>
</body><table>";

?>
