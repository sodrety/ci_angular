<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$_POST['bidang']."_".$_POST['mulai']."_".$_POST['selesai'].".xls");

?>

<style>
* {font-family:arial;font-size:13px;}
h2 {font-size:17px;}
* input {width:100%;}
table {border-left:1px solid #ccc; border-top:1px solid #ccc; border-spacing: 0px; border-collapse: separate;}

table tr td,table tr th {border-right:1px solid #ccc; border-bottom:1px solid #ccc; }
</style>
</head>
<body>
<?php
require_once( '../class/class.php' );
function rp_x($v) {
return $v;
}

function des_x($v) {
return $v;
}

function rq_bidang_xls() {
if ($_POST['mulai']=="") {$m=date("Y")."-01-01";} else {$m=$_POST['mulai'];}
if ($_POST['selesai']=="") {$s=date("Y-m-d");} else {$s=$_POST['selesai'];}
$jml=pok_bidang_sum('1');
$co=rq_bidang_cost(1,$m,$s);
$sp=rq_bidang_sp2d(1,$m,$s);
if ($m==date("Y-01-01") and $s==today()) {
rq_update("serapan_bidang","bidang='".$_POST['bidang']."'","jumlah='".$jml."',cost='".$co."',sp2d='".$sp."'");}
if ($_GET['file']=="xls") {} else {
echo "<form method=post>
Periode : <input type=date name=mulai value='".$m."'> s.d <input type=date name=selesai value='".$s."'> Bidang: <select name='bidang'><option value='".$_POST['bidang']."'>".$_POST['bidang']."</option>
<option value='um'>um</option><option value='kt'>kt</option><option value='kh'>kh</option><option value='ws'>ws</option><option value=''>semua</option></select> <input type=submit value='Lihat'></form>
<form method=post target='_blank' action='exe/xls_bidang.php?file=xls'>
<input type=hidden name=mulai value='".$m."'> <input type=hidden name=selesai value='".$s."'>
<input type=hidden name='bidang' value='".$_POST['bidang']."'> <input type=submit value='Export to Spreadsheet'></form>";
}
echo "
<table class='table' width=100% ><thead>
<tr><th>NO</th><th>ID</th><th>TOP</th><th>AKUN (MAK)</th><th>KODE</th><th>URAIAN</th><th>VOL</th><th>SAT</th><th>HARGASAT</th><th>JUMLAH</th><th>REALISASI USULAN</th><th>USULAN PERSEN</th><th>REALISASI SP2D</th><th>PERSENTASE SP2D</th><th>UM</th><th>KT</th><th>KH</th><th>WS</th><th>DANA</th><th>SISA DANA</th></tr></thead>
<tbody>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td align=right><b>".rp_x($jml)."</b></td><td align=right><b>".rp_x($co)."</b></td><td align=right><b>".des_x(($co/$jml)*100)."</b></td><td align=right><b>".rp_x($sp)."</b></td><td align=right><b>".des_x(($sp/$jml)*100)."</b></td><td></td><td></td><td></td><td></td><td></td><td align=right><b>".rp_x($jml-$co)."</b></td></tr>
";
echo rq_bidang_td_xls(1,$m,$s);
echo "</tbody></table>";	
	
}

function rq_bidang_td_xls($top,$m,$s) {
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok WHERE top='".$top."' order by kode,no";
$results = $db->get_results( $query );
foreach( $results as $data )
{
	$no=rq_baca("pok","top='".$data['no']."'","no");
	
	if ($no>0) {
	$dana=pok_bidang_sum($data['no']);		
	$dt.="<tr><td></td><td>".$data['no']."</td><td>".$data['top']."</td><td>".$data['mak']."</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td align=right>".rp_x($data['vol'])."</td><td align=center>".$data['sat']."</td><td align=right>".rp_x($data['hargasat'])."</td><td align=right><b>".rp_x($dana)."</b></td><td align=right><b></b></td><td align=right><b></b></td><td></td><td></td><td></td><td align=center></td><td></td><td></td><td>".$data['dana']."</td><td></td></tr>";
	$dt.=rq_bidang_td_xls($data['no'],$m,$s);
	}
	else {
	//$co=monitoring_sp2d($data['no'],$m,$s);
	$co=rq_bidang_cost_sum($data['no'],$m,$s);	
	$sp=rq_bidang_sp2d_sum($data['no'],$m,$s);
	if ($_POST['bidang']=="") {$dana=$data['jumlah'];} else {$pro=(rq_baca("proporsi","no='".$data['no']."'",$_POST['bidang'])/100);$dana=$data['jumlah']*$pro;}
	
	$dt.="<tr><td></td><td>".$data['no']."</td><td>".$data['top']."</td><td>".$data['mak']."</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td align=right>".rp_x($data['vol'])."</td><td align=center>".$data['sat']."</td><td align=right>".rp_x($data['hargasat'])."</td><td align=right>".rp_x($dana)."</td><td align=right>".rp_x($co)."</td><td align=right>".des_x(($co/$data['jumlah'])*100)."</td><td align=right>".rp_x($sp)."</td><td align=right>".des_x(($sp/$data['jumlah'])*100)."</td>".proporsi2($data['no'])."<td>".$data['dana']."</td><td align=right>".rp_x($dana-$co)."</td></tr>";
	//if (strstr($data['mak'],"1823.951")) {rq_replace("proporsi","'".$data['no']."','".$data['jumlah']."','100','','',''");}
	}
	}
	return $dt;
}

rq_bidang_xls();

?>
</body>
</html>
