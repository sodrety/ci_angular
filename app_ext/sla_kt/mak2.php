<?php
require_once( 'class/class.php' );
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok WHERE top='".$_GET['top']."' order by kode,no";
$results = $db->get_results( $query );
$no=0;
foreach( $results as $data )
{
if ($data['kode']=='') {
echo "<p>
<table width=100% class='table'><tr><td width=50%>".$data['uraian']."</td><td width=10%>".$data['vol']."</td><td width=10%>".$data['sat']."</td><td width=10% align=right>".rp($data['hargasat'])."</td><td width=10% align=right>".rp($data['jumlah'])."</td></tr></table>
</p>
"; 
} else {
echo "<p><a onClick=\"javascript:requestContent('mak2.php?top=".$data['no']."&no=".$_GET['no'].$no."','a".$_GET['no'].$no."');\">".$data['kode']." ".$data['uraian']."</a>  &nbsp; <a href='exe/item.php?top=".$data['no']."' target='_blank'><img src='css/edit.png'></a>

</p>
<div id='a".$_GET['no'].$no."'></div>
"; }
$no+=1;
}
