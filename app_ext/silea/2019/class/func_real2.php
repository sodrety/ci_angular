<?php
function rq_pok_tree() {
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok WHERE top='1' order by kode,no";
$results = $db->get_results( $query );
if ($_POST['mulai']=="") {$m=date("Y-m-")."01";} else {$m=$_POST['mulai'];}
if ($_POST['selesai']=="") {$s=date("Y-m-d");} else {$s=$_POST['selesai'];}
echo "<form method=post>
Periode : <input type=date name=mulai value='".$m."'> s.d <input type=date name=selesai value='".$s."'> <input type=submit value='Lihat'></form>
<table class='table' width=100%><thead>
<tr><th>KODE</th><th>URAIAN</th><th>VOL</th><th>SAT</th><th>HARGASAT</th><th>JUMLAH</th><th>SDANA</th><th>DANA</th><th>SERAPAN SP2D</th><th>PERSENTASE</th></tr></thead><tbody>
";
foreach( $results as $data )
{
	$co=monitoring_sp2d_mak($data['mak'],$m,$s);
$jml=pok_sum($data['no']);
$print.="<tr><td>".$data['kode']."</td><td>".$data['uraian']."</td><td align=right>".rp($data['vol'])."</td><td align=center>".$data['sat']."</td><td align=right>".rp($data['hargasat'])."</td><td align=right>".rp($jml)."</td><td>".$data['sdana']."</td><td>".$data['dana']."</td><td align=right>".rp($co)."</td><td align=right>".des(($co/$jml)*100)."</td></tr>";
rq_pok_tree2($data['no'],$m,$s);
$jm+=$jml;
$rl+=$co;
}

echo "<tr><td $wt>".rq_baca("global","kolom='kode'","isi")."</td><td $wt>".rq_baca("global","kolom='nama_unit'","isi")."</td><td></td><td></td><td></td><td align=right $wt>".rp($jm)."</td><td></td><td></td><td align=right $wt>".rp($rl)."</td><td align=right $wt>".des(($rl/$jm)*100)."</td></tr>";

echo $print."</tbody></table>";
}
function rq_pok_tree2($top,$m,$s) {
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok WHERE top='".$top."' order by kode,no";
$results = $db->get_results( $query );
foreach( $results as $data )
{
	$no=rq_baca("pok","top='".$data['no']."'","no");
	if ($no<=0) {$co=monitoring_sp2d($data['no'],$m,$s);$jml=$data['jumlah'];}
	else {$co=monitoring_sp2d_mak($data['mak'],$m,$s);$jml=rq_jml($data['mak']);}

echo "<tr><td>".$data['kode']."</td><td>".$data['uraian']."</td><td align=right>".rp($data['vol'])."</td><td align=center>".$data['sat']."</td><td align=right>".rp($data['hargasat'])."</td><td align=right>".rp($jml)."</td><td>".$data['sdana']."</td><td>".$data['dana']."</td><td align=right>".rp($co)."</td><td align=right>".des(($co/$jml)*100)."</td></tr>";

if ($no>0) {rq_pok_tree2($data['no'],$m,$s);} else {echo "";}

	}
}

function monitoring_sp2d($no,$m,$s) {
$db = new database();
$db->connect(rq_db());
$query = "SELECT harga FROM cost join spm ON spm.id_spm=cost.id_spm WHERE cost.no='".$no."' AND spm.tgl_sp2d>='".$m."' AND spm.tgl_sp2d<='".$s."'";
$results = $db->get_results( $query );
foreach( $results as $data )
{
	$co+=$data['harga'];
	}
	return $co;
}

function monitoring_sp2d_mak($mak,$m,$s) {
$db = new database();
$db->connect(rq_db());
$query = "SELECT no FROM pok WHERE mak LIKE '".$mak."%' and sat!='' order by mak";
$results = $db->get_results( $query );
foreach( $results as $data )
{
$jml+=monitoring_sp2d($data['no'],$m,$s);
}
return $jml;
}

function rq_pok_tree_jml($no) {
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok WHERE top='".$no."' order by kode,no";
$results = $db->get_results( $query );
foreach( $results as $data )
{
//$dt.=$data['no']."";
$dt.=rq_pok_tree2_jml($data['no']);
//$j=rq_pok_tree2_jml($data['no']);
//$jm+=$j;
}

return $dt;
}


function pok_sum($no) {
$explode_arr = explode("|||", rq_pok_tree2_jml($no));
$sum = 0;
foreach($explode_arr as $value) {
    $sum +=$value;
}
return $sum;
}



function rq_pok_tree2_jml($top) {
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok WHERE top='".$top."' order by kode,no";
$results = $db->get_results( $query );
foreach( $results as $data )
{
	$no=rq_baca("pok","top='".$data['no']."'","no");
	if ($no>0) {//$dt.=$data['no']."<br>";
	$dt.=rq_pok_tree2_jml($data['no']);
	}
	else {
	$jumlah=rq_baca("pok","no='".$data['no']."' AND sat!=''","jumlah");
	$dt.="".$jumlah."|||";	}
	}
	return $dt;
}

function rq_pok_td($top) {
$db = new database();
$db->connect(rq_db());
if ($_POST['mulai']=="") {$m=date("Y-m-")."01";} else {$m=$_POST['mulai'];}
if ($_POST['selesai']=="") {$s=date("Y-m-d");} else {$s=$_POST['selesai'];}
$query = "SELECT * FROM pok WHERE top='".$top."' order by kode,no";
$results = $db->get_results( $query );
foreach( $results as $data )
{
	$no=rq_baca("pok","top='".$data['no']."'","no");
	if ($no>0) {//$dt.=$data['no']."<br>";
	$pok_sum=pok_sum($data['no']);
	$dt.="<tr><td></td><td>".$data['no']."</td><td>".$data['top']."</td><td>".$data['mak']."</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td align=right>".rp($data['vol'])."</td><td align=center>".$data['sat']."</td><td align=right>".rp($data['hargasat'])."</td><td align=right><b>".rp($pok_sum)."</b></td><td align=right><b></b></td><td align=right><b></b></td><td>".$data['sdana']."</td><td>".$data['dana']."</td><td align=center></td><td align=center><a href='exe/item.php?top=".$data['no']."' target='_blank'>Ed</a></td><td></td><td></td><td></td><td></td></tr>";
	//rq_update("proporsi","no='".$data['no']."'","jumlah='".$pok_sum."'");
	rq_replace("proporsi","'".$data['no']."','".$pok_sum."','','','',''");
	$dt.=rq_pok_td($data['no']);
	}
	else {
	//$jumlah=rq_baca("pok","no='".$data['no']."' AND sat!=''","jumlah");
	$co=monitoring_sp2d($data['no'],$m,$s);
	$dt.="<tr><td></td><td>".$data['no']."</td><td>".$data['top']."</td><td>".$data['mak']."</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td align=right>".rp($data['vol'])."</td><td align=center>".$data['sat']."</td><td align=right>".rp($data['hargasat'])."</td><td align=right>".rp($data['jumlah'])."</td><td align=right>".rp($co)."</td><td align=right>".des(($co/$data['jumlah'])*100)."</td><td>".$data['sdana']."</td><td>".$data['dana']."</td><td align=center><a href='?no=".$data['no']."'>Vw</a></td><td align=center></td>".proporsi($data['no'])."</tr>";
	rq_update("proporsi","no='".$data['no']."'","jumlah='".$data['jumlah']."'");
	//if (strstr($data['uraian'],"PSAT") and strstr($data['uraian'],"PSAH")) { rq_replace("proporsi","'".$data['no']."','','50','50',''");} elseif (strstr($data['uraian'],"PSAT")) { rq_replace("proporsi","'".$data['no']."','','100','',''");}  elseif (strstr($data['uraian'],"PSAH")) { rq_replace("proporsi","'".$data['no']."','','','100',''");}
	//if (strstr($data['mak'],"1823.101.002.313.B")) {rq_replace("proporsi","'".$data['no']."','','100','',''");} //kt
	//if (strstr($data['mak'],"1823.101.001.311")) {rq_replace("proporsi","'".$data['no']."','','','100',''");} //kh
	//if (strstr($data['mak'],"1823.951")) {rq_replace("proporsi","'".$data['no']."','100','','',''");} //um
	
	//if (strstr($data['mak'],"1823.101.002.511")) {rq_replace("proporsi","'".$data['no']."','','','','100'");} //ws
	//rq_update("pok","no='".$data['no']."'","mak='".pok_kodenya($data['no'])."'");
	}
	}
	return $dt;
}

function proporsi($no) {
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM proporsi WHERE no='".$no."' LIMIT 0,1";
$results = $db->get_results( $query );
foreach( $results as $data )
{
$dt.="<td>".$data['um']."</td><td>".$data['kt']."</td><td>".$data['kh']."</td><td>".$data['ws']."</td>";
}
return $dt;
}
function rq_pok_table() {
if ($_POST['mulai']=="") {$m=date("Y-m-")."01";} else {$m=$_POST['mulai'];}
if ($_POST['selesai']=="") {$s=date("Y-m-d");} else {$s=$_POST['selesai'];}
$jml=pok_sum('1');
$co=rq_cost_sum(1);
echo "<form method=post>
Periode : <input type=date name=mulai value='".$m."'> s.d <input type=date name=selesai value='".$s."'> <input type=submit value='Lihat'></form>
<table class='table' width=100%><thead>
<tr><th>NO</th><th>ID</th><th>TOP</th><th>AKUN (MAK)</th><th>KODE</th><th>URAIAN</th><th>VOL</th><th>SAT</th><th>HARGASAT</th><th>JUMLAH</th><th>REALISASI</th><th>PERSENTASE</th><th>SDANA</th><th>DANA</th><th>VIEW</th><th>EXE</th><th>UM</th><th>KT</th><th>KH</th><th>WS</th></tr>

</thead>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td align=right><b>".rp($jml)."</b></td><td align=right><b>".rp($co)."</b></td><td align=right><b>".des(($co/$jml)*100)."</b></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tbody>
";
echo rq_pok_td(1);
echo "</tbody></table>";
}

function rq_pok_allPrint() {
if ($_POST['mulai']=="") {$m=date("Y-m-")."01";} else {$m=$_POST['mulai'];}
if ($_POST['selesai']=="") {$s=date("Y-m-d");} else {$s=$_POST['selesai'];}
$jml=pok_sum('1');
$co=rq_cost_sum(1);
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Periodik.xlm");
header("Pragma: no-cache");
header("Expires: 0");
echo "
<table class='table' width=100% ><thead>
<tr><th>NO</th><th>ID</th><th>TOP</th><th>AKUN (MAK)</th><th>KODE</th><th>URAIAN</th><th>VOL</th><th>SAT</th><th>HARGASAT</th><th>JUMLAH</th><th>REALISASI</th><th>PERSENTASE</th><th>SDANA</th><th>DANA</th><th>VIEW</th><th>EXE</th><th>UM</th><th>KT</th><th>KH</th><th>WS</th></tr></thead>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td align=right><b>".rp($jml)."</b></td><td align=right><b>".rp($co)."</b></td><td align=right><b>".des(($co/$jml)*100)."</b></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tbody>
";
echo rq_pok_td(1);
echo "</tbody></table>";
}


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

function r_cost_all_sum($top) {
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
	$co+=r_cost_all_sum($data['no']);
	}
	else {
	//$jumlah=rq_baca("pok","no='".$data['no']."' AND sat!=''","jumlah");
	$co+=r_cost_all($data['no']);
	}
	}
	return $co;
}

function r_cost_all($no) {
$db = new database();
$db->connect(rq_db());
$query = "SELECT harga FROM cost WHERE no='".$no."'";
$results = $db->get_results( $query );
foreach( $results as $data )
{
	$co+=$data['harga'];
	}
	return $co;
}
