<html>
<head>

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

if ($_POST) {
if ($_POST['do']=="edit") {
rq_update("pok","no='".$_POST['no']."'","top='".$_POST['top']."',kode='".$_POST['kode']."',uraian='".$_POST['uraian']."',vol='".$_POST['vol']."',sat='".$_POST['sat']."',hargasat='".$_POST['hargasat']."',jumlah='".$_POST['jumlah']."',sdana='".$_POST['sdana']."'");
//rq_update("pok","no='".$_POST['no']."'","top='".$_POST['top']."',kode='".$_POST['kode']."',uraian='".$_POST['uraian']."',vol='".$_POST['vol']."',sat='".$_POST['sat']."',hargasat='".$_POST['hargasat']."',jumlah='".$_POST['jumlah']."',sdana='".$_POST['sdana']."'");
} elseif ($_POST['do']=="tambah") {
rq_insert("pok","'', '".$_POST['top']."', '".$_POST['kode']."', '".$_POST['uraian']."', '".$_POST['vol']."', '".$_POST['sat']."', '".$_POST['hargasat']."', '".$_POST['jumlah']."', NULL, '".$_POST['sdana']."', NULL, NULL, NULL, NULL");
echo "OK<br>";
} elseif ($_POST['do']=="del") {
rq_delete("pok","no='".$_POST['no']."'");
}

}




$db = new database();
$db->connect(rq_db());
$top=$_GET['top'];
$query = "SELECT * FROM pok WHERE top='".$top."' order by kode";
$results = $db->get_results( $query );
$no=1;

echo "<h2>". pok_kodenya($top)." ".rq_baca("pok","no='".$top."'","uraian")." (".$top.")</h2><table width=100%>
<tr><tr><th></th><th></th><th>TOP</th><th>KODE</th><th>URAIAN</th><th>VOL</th><th>SAT</th><th>HARGASAT</th><th>JUMLAH</th><th>SDANA</th><th></th></tr>
";

foreach( $results as $data )
{
rq_update("pok","no='".$data['no']."'","mak='".pok_kodenya($data['no'])."'");
echo "
<tr><form method=post class=form><input type=hidden name=no value='".$data['no']."'><input type=hidden name=do value='del'><td><input type=submit name=submit value='x'></td></form><form method=post class=form><input type=hidden name=no value='".$data['no']."'><input type=hidden name=do value='edit'>

<td width=5%>".$data['no']."</td><td width=5%><input type=text name=top value='".$data['top']."'></td><td width=10%><input type=text name=kode value='".$data['kode']."'></td><td width=50%><input type=text name=uraian value='".$data['uraian']."' style='width:100%;'></td><td width=10%><input type=text name=vol value='".$data['vol']."'></td><td width=10%><input type=text name=sat value='".$data['sat']."'></td><td width=10% align=right><input type=text name=hargasat value='".$data['hargasat']."'></td><td width=10% align=right><input type=text name=jumlah value='".$data['jumlah']."'></td><td width=5% align=right><input type=text name=sdana value='".$data['sdana']."'></td><td width=5% align=right><input type=submit name=submit value='Simpan'></td></tr></form>";
$no+=1;
}
echo "
<tr><td></td><td></td><td colspan=9>Tambah Item</td></tr>
<form method=post class=form><input type=hidden name=no value=''><input type=hidden name=top value='".$top."'><input type=hidden name=do value='tambah'>
<tr><td></td><td></td><td></td><td width=10%><input type=text name=kode value=''></td><td width=50%><input type=text name=uraian value='' style='width:100%;'></td><td width=10%><input type=text name=vol value=''></td><td width=10%><input type=text name=sat value=''></td><td width=10% align=right><input type=text name=hargasat value=''></td><td width=10% align=right><input type=text name=jumlah value=''></td><td width=5% align=right><input type=text name=sdana value='".$data['sdana']."'></td><td width=5% align=right><input type=submit name=submit value='Simpan'></td></tr></form>";
echo "</table>";
?>
</body>
</html>
