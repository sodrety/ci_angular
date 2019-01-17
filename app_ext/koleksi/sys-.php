<?php
error_reporting(E_ALL & ~E_NOTICE);
//error_reporting(0);
include "class/class.php";
?>
<!DOCTYPE html>
<html xml:lang="en" lang="en">
<head>
    <link rel="stylesheet" type="text/css" media="screen" href="inc/css.css" />
<style>
table {border-top:1px solid #333;border-left:1px solid #333;}
table tr td, table tr th {border-bottom:1px solid #333;border-right:1px solid #333;padding:2px 5px;}
</style>
 	    <title>Koleksi</title>
		<?php ui_head(); ?>
</head>
<body>
<h2>KOLEKSI MEDIA PEMBAWA, <?php echo $n ?></h2><hr>
<a href='form.php?tab=new&b=<?php echo $b ?>'>Tambah</a><hr><br>
<table cellpadding=0 cellspacing=0>
<tr><th>NO</th><th>TGL KOLEKSI</th><th>NO REGISTRASI</th><th>INANG</th><th>SUMBER</th><th>LOKASI</th><th>KOLEKTOR</th><th>JENIS</th><th></th><th></th></tr>
<?php
$db=new database();
$db->koleksi_konek();
$daftar=$db->tampilDataWhere("koleksi","id>0 and bidang='".$b."' order by tgl_koleksi desc,id desc limit 0,5000");
foreach((array)$daftar as $data){
$nrk1="000000".$data['nrk'];
$m=strlen($nrk1)-6;
$nrkp=substr ($nrk1, $m, 6);
$no++;
echo "<tr><td>".$no."</td><td>".$data['tgl_koleksi']."</td><td>".$data['kd'].$nrkp.substr($data['jenis_kel'], 0, 2).".".$data['bidang']."</td><td>".$data['inang']."</td><td>".$data['sumber']."</td><td>".$data['lokasi']."</td><td>".$data['kolektor']."</td><td>".$data['jenis_ordo']." - ".$data['jenis_fam']." - ".$data['jenis_spes']."<br></td><td><a target='_blank' href='form.php?tab=edit&id=".$data['id']."'>Edit</a></td><td><a target='_blank' href='print/print.php?id=".$data['id']."'>Print</a></td></tr>";
}

?>
</table>
</body>
<?php ui_foot(); ?>
</html>

