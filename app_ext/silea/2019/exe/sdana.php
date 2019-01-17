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
rq_insert("pok","'".$_POST['no']."', '".$_POST['top']."', '".$_POST['kode']."', '".$_POST['uraian']."', '".$_POST['vol']."', '".$_POST['sat']."', '".$_POST['hargasat']."', '".$_POST['jumlah']."', '".$_POST['sdana']."'");
} elseif ($_POST['do']=="del") {
rq_delete("pok","no='".$_POST['no']."'");
}
echo "OK<br>";
}




$db = new database();
$db->connect(rq_db());
$top=$_GET['top'];
$query = "SELECT * FROM pok WHERE sdana='A' or sdana='D' order by kode";
$results = $db->get_results( $query );
$no=1;

echo "<table width=100%>
<tr><th>NO</th><th>ID</th><th>TOP</th><th>AKUN (MAK)</th><th></th><th>KODE</th><th>URAIAN</th><th>VOL</th><th>SAT</th><th>HARGASAT</th><th>JUMLAH</th><th>SDANA</th><th>VIEW</th><th>EXE</th></tr>
";

foreach( $results as $data )
{
if ($data['sdana']=="A") {$it="RM";} elseif ($data['sdana']=="D") {$it="PNBP";}
rq_update("pok","mak LIKE '".$data['mak']."%'","dana='".$it."'");
echo "<tr><td>".$n."</td><td>".$data['no']."</td><td>".$data['top']."</td><td>".$data['mak']."</td><td>$ex</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td align=right>".rp($data['vol'])."</td><td align=center>".$data['sat']."</td><td align=right>".rp($data['hargasat'])."</td><td align=right>".rp($data['jumlah'])."</td><td>".$data['sdana']."</td><td></td><td>".$it."".$pilih." </td></tr>";
$no+=1;
}
echo "
</table>";
?>
</body>
</html>
