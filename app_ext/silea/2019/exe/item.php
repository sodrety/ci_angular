<html>
<head>

<style>
* {font-family:arial;font-size:13px;}
h2 {font-size:17px;}
* input {width:100%;}
.p1 {width:100%;}
.p4 {width:40px;}
.p9 {width:70px;}
table {border-left:1px solid #ccc; border-top:1px solid #ccc; border-spacing: 0px; border-collapse: separate;}

table tr td,table tr th {border-right:1px solid #ccc; border-bottom:1px solid #ccc; }
</style>
</head>
<body>
<?php
require_once( '../class/class.php' );

function pro_td($no,$sat) {
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM proporsi WHERE no='".$no."' limit 0,1";
$results = $db->get_results( $query );	
foreach( $results as $data )
{
$um=$data['um'];
$kt=$data['kt'];
$kh=$data['kh'];
$ws=$data['ws'];
$n++;
}	
return "<td><input name=um value='".$um."' class=p4></td><td><input name=kt value='".$kt."' class=p4></td><td><input name=kh value='".$kh."' class=p4></td><td><input name=ws value='".$ws."' class=p4></td>";
}



if ($_POST) {
if ($_POST['do']=="edit") {
rq_update("pok","no='".$_POST['no']."'","top='".$_POST['top']."',kode='".$_POST['kode']."',uraian='".$_POST['uraian']."',vol='".$_POST['vol']."',sat='".$_POST['sat']."',hargasat='".$_POST['hargasat']."',jumlah='".$_POST['jumlah']."',dana='".$_POST['dana']."'");
rq_replace("proporsi","'".$_POST['no']."','".$_POST['jumlah']."','".$_POST['um']."','".$_POST['kt']."','".$_POST['kh']."','".$_POST['ws']."'");
//rq_update("pok","no='".$_POST['no']."'","top='".$_POST['top']."',kode='".$_POST['kode']."',uraian='".$_POST['uraian']."',vol='".$_POST['vol']."',sat='".$_POST['sat']."',hargasat='".$_POST['hargasat']."',jumlah='".$_POST['jumlah']."',sdana='".$_POST['sdana']."'");
} elseif ($_POST['do']=="tambah") {
rq_insert("pok","'', '".$_POST['top']."', '".$_POST['kode']."', '".$_POST['uraian']."', '".$_POST['vol']."', '".$_POST['sat']."', '".$_POST['hargasat']."', '".$_POST['jumlah']."', NULL, '".$_POST['sdana']."', NULL, NULL, NULL, NULL");
echo "OK<br>";
} elseif ($_POST['do']=="del") {
if (rq_baca("pok","top='".$_POST['no']."'","no")>0) {echo "Gagal Hapus Masih ada Sub Item";} elseif (pok_sum($_POST['no'])>0) {echo "Gagal Hapus Sudah ada Pengeluaran";} else {rq_delete("pok","no='".$_POST['no']."'");
rq_delete("proporsi","no='".$_POST['no']."'");
}

}

}




$db = new database();
$db->connect(rq_db());
$top=$_GET['top'];
$query = "SELECT * FROM pok WHERE top='".$top."' order by kode";
$results = $db->get_results( $query );
$no=1;

echo "<h2>". pok_kodenya($top)." ".rq_baca("pok","no='".$top."'","uraian")." (".$top.")</h2><table width=100%>
<tr><tr><th></th><th></th><th>TOP</th><th>KODE</th><th  class=p1>URAIAN</th><th>VOL</th><th>SAT</th><th>HARGA</th><th>JUMLAH</th><th>DANA</th><th>UM</th><th>KT</th><th>KH</th><th>WS</th><th></th></tr>
";

foreach( $results as $data )
{
rq_update("pok","no='".$data['no']."'","mak='".pok_kodenya($data['no'])."'");

if ($data['sat']=="") {$jml=pok_sum($data['no']);} else {$jml=$data['jumlah'];}
echo "
<tr><form method=post class=form><input type=hidden name=no value='".$data['no']."'><input type=hidden name=do value='del'><td><input type=submit name=submit value='x'></td></form><form method=post class=form><input type=hidden name=no value='".$data['no']."'><input type=hidden name=do value='edit'>

<td width=5%>".$data['no']."</td>
<td><input type=text name=top value='".$data['top']."'></td>
<td><input type=text name=kode value='".$data['kode']."' class=p9></td>
<td><input type=text name=uraian value='".$data['uraian']."'></td>
<td><input type=text name=vol value='".$data['vol']."' class=p9></td>
<td><input type=text name=sat value='".$data['sat']."' class=p4></td>
<td align=right><input type=text name=hargasat value='".$data['hargasat']."' class=p9></td>
<td align=right><input type=text name=jumlah value='".$jml."' style='text-align:right;' class=p9></td>
<td align=right>
<select name='dana'><option>".$data['dana']."</option><option>PNBP</option><option>RM</option></select>
</td>".pro_td($data['no'],$data['sat'])."<td width=5% align=right><input type=submit name=submit value='Simpan'></td></tr></form>";
$no+=1;
}
echo "
<tr><td></td><td></td><td colspan=13>Tambah Item</td></tr>
<form method=post class=form><input type=hidden name=no value=''><input type=hidden name=top value='".$top."'><input type=hidden name=do value='tambah'>
<tr><td></td><td></td><td></td>
<td><input type=text name=kode value=''></td>
<td><input type=text name=uraian value='' style='width:100%;'></td>
<td><input type=text name=vol value=''></td>
<td><input type=text name=sat value=''></td>
<td align=right><input type=text name=hargasat value=''></td>
<td align=right><input type=text name=jumlah value=''></td>
<td align=right>
<select name='dana'><option>PNBP</option><option>RM</option></select>
</td>
<td></td><td></td><td></td><td></td>
<td width=5% align=right><input type=submit name=submit value='Simpan'></td></tr></form>";
echo "</table>";
?>
</body>
</html>
