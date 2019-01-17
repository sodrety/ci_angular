<html>
<head>
<style>
<?php include "../css/css.css"; ?>
</style>
</head>
<body>
<?php
require_once( '../class/class.php' );
$db = new database();
$db->connect(rq_db());
if ($_GET['no']!="") {$wh="and cost.no='".$_GET['no']."'";}
$query = "SELECT * FROM cost join pok ON cost.no=pok.no WHERE pok.mak LIKE '".$_GET['mak']."%' $wh order by cost.no,cost.tgl desc";
$results = $db->get_results( $query );
echo "
<table width=100%>
<tr><th>NOMOR</th><th>TGL USULAN</th><th>AKUN</th><th>DESKRIPSI AKUN</th><th>URAIAN USULAN</th><th>NOMINAL</th><th>SPTB</th><th>SPM</th><th>INPUT BY</th><th>EDIT BY</th></tr>
";

foreach( $results as $data )
{

$n++;
if ($data['id_sptb']>0) {$edit="";} else {$edit="<a href='?t=POK%20All&do=Usulan&id=".$data['id']."'>Edit</a>";}

echo "<tr><td align=center>".$data['id']."</td><td>".$data['tgl']."</td><td>".rq_baca("pok","no='".$data['no']."'","mak")."</td><td>".rq_baca("pok","no='".$data['no']."'","uraian")."</td><td>".$data['untuk']."</td><td align=right><b>".rp($data['harga'])."</b></td><td>".rq_baca("sptb","id_sptb='".$data['id_sptb']."'","nomor")."".rq_baca("sptb","id_sptb='".$data['id_sptb']."'","cara")."</td><td>".$data['id_spm']."</td><td>".$data['input_oleh']."</td><td>".$data['update_oleh']."</td></tr>";
$rp+=$data['harga'];
}
echo "<tr><td align=center colspan=5>TOTAL<td align=right><b>".rp($rp)."</b></td><td colspan=4></td></tr>";
echo "</table>";
?>
</body>
</html>
