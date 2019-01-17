<?php



function pok_bidang_sum($no) {
$explode_arr = explode("|||", rq_pok_bidang_jml($no));
$sum = 0;
foreach($explode_arr as $value) {
    $sum +=$value;
}
return $sum;
}



function rq_pok_bidang_jml($top) {
$bid=$_POST['bidang'];
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok WHERE top='".$top."' order by kode,no";
$results = $db->get_results( $query );
foreach( $results as $data )
{
	$no=rq_baca("pok","top='".$data['no']."'","no");
	if ($no>0) {//$dt.=$data['no']."<br>";
	$dt.=rq_pok_bidang_jml($data['no']);
	}
	else {
	$jumlah=rq_baca("pok","no='".$data['no']."' AND sat!=''","jumlah");
	if ($bid=="") {$pro=1;} else {$pro=(rq_baca("proporsi","no='".$data['no']."'",$bid)/100);}
	$dt.="".($pro*$jumlah)."|||";	}
	}
	return $dt;
}





function rq_bidang() {
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
<tr><th>NO</th><th>ID</th><th>TOP</th><th>AKUN (MAK)</th><th>KODE</th><th>URAIAN</th><th>VOL</th><th>SAT</th><th>HARGASAT</th><th>JUMLAH</th><th>REALISASI USULAN</th><th>USULAN PERSEN</th><th>REALISASI SP2D</th><th>PERSENTASE SP2D</th><th>UM</th><th>KT</th><th>KH</th><th>WS</th><th>DANA</th><th>SISA DANA</th><th></th></tr></thead>
<tbody>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td align=right><b>".rp($jml)."</b></td><td align=right><b>".rp($co)."</b></td><td align=right><b>".des(($co/$jml)*100)."</b></td><td align=right><b>".rp($sp)."</b></td><td align=right><b>".des(($sp/$jml)*100)."</b></td><td></td><td></td><td></td><td></td><td></td><td align=right><b>".rp($jml-$co)."</b></td><td></td></tr>
";
echo rq_bidang_td(1,$m,$s);
echo "</tbody></table>";	
	
}

function rq_bidang_td($top,$m,$s) {
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok WHERE top='".$top."' order by kode,no";
$results = $db->get_results( $query );
foreach( $results as $data )
{
	$no=rq_baca("pok","top='".$data['no']."'","no");
	
	if ($no>0) {
	$dana=pok_bidang_sum($data['no']);		
	$dt.="<tr><td></td><td>".$data['no']."</td><td>".$data['top']."</td><td>".$data['mak']."</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td align=right>".rp($data['vol'])."</td><td align=center>".$data['sat']."</td><td align=right>".rp($data['hargasat'])."</td><td align=right><b>".rp($dana)."</b></td><td align=right><b></b></td><td align=right><b></b></td><td></td><td></td><td></td><td align=center></td><td></td><td></td><td>".$data['dana']."</td><td></td><td></td></tr>";
	$dt.=rq_bidang_td($data['no'],$m,$s);
	}
	else {
	//$co=monitoring_sp2d($data['no'],$m,$s);
	$co=rq_bidang_cost_sum($data['no'],$m,$s);	
	$sp=rq_bidang_sp2d_sum($data['no'],$m,$s);
	if ($_POST['bidang']=="") {$dana=$data['jumlah'];} else {$pro=(rq_baca("proporsi","no='".$data['no']."'",$_POST['bidang'])/100);$dana=$data['jumlah']*$pro;}
	$dt.="<tr><td></td><td>".$data['no']."</td><td>".$data['top']."</td><td>".$data['mak']."</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td align=right>".rp($data['vol'])."</td><td align=center>".$data['sat']."</td><td align=right>".rp($data['hargasat'])."</td><td align=right>".rp($dana)."</td><td align=right>".rp($co)."</td><td align=right>".des(($co/$data['jumlah'])*100)."</td><td align=right>".rp($sp)."</td><td align=right>".des(($sp/$data['jumlah'])*100)."</td>".proporsi2($data['no'])."<td>".$data['dana']."</td><td align=right>".rp($dana-$co)."</td><td><a target='_blank' href='print/usulan.php?no=".$data['no']."'>Log</a></td></tr>";
	//if (strstr($data['mak'],"1823.951")) {rq_replace("proporsi","'".$data['no']."','".$data['jumlah']."','100','','',''");}
	}
	}
	return $dt;
}

function rq_bidang_cost($top,$m,$s) {
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok WHERE top='".$top."' order by kode,no";
$results = $db->get_results( $query );
foreach( $results as $data )
{
	$no=rq_baca("pok","top='".$data['no']."'","no");
	if ($no>0) {
	$co+=rq_bidang_cost($data['no'],$m,$s);
	}
	else {
	$co+=rq_bidang_cost_sum($data['no'],$m,$s);
	}
	}
	return $co;
}

function rq_bidang_cost_sum($no,$m,$s) {
$db = new database();
$db->connect(rq_db());
//$query = "SELECT harga FROM cost join spm ON spm.id_spm=cost.id_spm WHERE cost.no='".$no."' AND spm.tgl_sp2d>='".$m."' AND spm.tgl_sp2d<='".$s."'";
$bid=$_POST['bidang'];
if ($bid=="") {$wh="";} else {$wh="and bidang='".$bid."'";}
	
$query = "SELECT harga FROM cost  WHERE no='".$no."' AND tgl>='".$m."' AND tgl<='".$s."' ".$wh."";
$results = $db->get_results( $query );
foreach( $results as $data )
{
	$co+=$data['harga'];
	}
	return $co;
}


function rq_bidang_sp2d($top,$m,$s) {
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok WHERE top='".$top."' order by kode,no";
$results = $db->get_results( $query );
foreach( $results as $data )
{
	$no=rq_baca("pok","top='".$data['no']."'","no");
	if ($no>0) {
	$co+=rq_bidang_sp2d($data['no'],$m,$s);
	}
	else {
	$co+=rq_bidang_sp2d_sum($data['no'],$m,$s);
	}
	}
	return $co;
}

function rq_bidang_sp2d_sum($no,$m,$s) {
$db = new database();
$db->connect(rq_db());
$bid=$_POST['bidang'];
	if ($bid=="") {$wh="";} else {$wh="and cost.bidang='".$bid."'";}
$query = "SELECT harga FROM cost join spm ON spm.id_spm=cost.id_spm WHERE cost.no='".$no."' AND spm.tgl_sp2d>='".$m."' AND spm.tgl_sp2d<='".$s."' ".$wh."";
//$query = "SELECT harga FROM cost  WHERE no='".$no."' AND tgl>='".$m."' AND tgl<='".$s."'";
$results = $db->get_results( $query );
foreach( $results as $data )
{
	$co+=$data['harga'];
	}
	return $co;
}


function proporsi2($no) {
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM proporsi WHERE no='".$no."' LIMIT 0,1";
$results = $db->get_results( $query );
foreach( $results as $data )
{
//if ($data['kh']==50) {rq_update("cost","no='".$no."' and input_oleh='315'","bidang='kh'");}
}
$dt.="<td>".$data['um']."</td><td>".$data['kt']."</td><td>".$data['kh']."</td><td>".$data['ws']."</td>";
return $dt;
}
