<?php
function rq_cost_sum($top) {
if ($_POST['mulai']=="") {$m=date("Y-m-")."01";} else {$m=$_POST['mulai'];}
if ($_POST['selesai']=="") {$s=date("Y-m-d");} else {$s=$_POST['selesai'];}
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok WHERE top='".$top."' order by kode,no";
$results = $db->get_results( $query );
foreach( $results as $data )
{
	$no=rq_baca("pok","top='".$data['no']."'","no");
	if ($no>0) {
	$co+=rq_cost_sum($data['no']);
	}
	else {
	//$jumlah=rq_baca("pok","no='".$data['no']."' AND sat!=''","jumlah");
	$co+=monitoring_sp2d($data['no'],$m,$s);
	}
	}
	return $co;
}

function pok_sum($no) {
$explode_arr = explode("|||", rq_pok_tree2_jml($no));
$sum = 0;
foreach($explode_arr as $value) {
    $sum +=$value;
}
return $sum;
}

if ($_POST['mulai']=="") {$m=date("Y-m-")."01";} else {$m=$_POST['mulai'];}
if ($_POST['selesai']=="") {$s=date("Y-m-d");} else {$s=$_POST['selesai'];}
$jml=pok_sum('1');
$co=rq_cost_sum(1);
echo "
<table class='table' width=100% ><thead>
<tr><th>NO</th><th>ID</th><th>TOP</th><th>AKUN (MAK)</th><th>KODE</th><th>URAIAN</th><th>VOL</th><th>SAT</th><th>HARGASAT</th><th>JUMLAH</th><th>REALISASI</th><th>PERSENTASE</th><th>SDANA</th><th>DANA</th><th>VIEW</th><th>EXE</th><th>UM</th><th>KT</th><th>KH</th><th>WS</th></tr></thead>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td align=right><b>".rp($jml)."</b></td><td align=right><b>".rp($co)."</b></td><td align=right><b>".des(($co/$jml)*100)."</b></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tbody>
";
echo rq_pok_td(1);
echo "</tbody></table>";
?>
