<?php
require_once( 'class/class.php' );
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok order by no desc limit 0,10";
$results = $db->get_results( $query );
echo "<table border=1>";
foreach( $results as $data )
{
//$sno=rq_baca("nonya","nos='".$data['no']."'","no");
//$stop=rq_baca("nonya","nos='".$data['top']."'","no");
//rq_update("pok","no='".$data['no']."'","sno='".$sno."'");
//rq_update("pok","top='".$data['top']."'","stop='".$stop."'");
//if ($data['sat']=="") {rq_update("pok","no='".$data['no']."'","jumlah=''");}
rq_update("pok","no='".$data['no']."'","mak='".pok_kodenya($data['no'])."'");
echo "<tr><td>".$sno."</td><td>".$stop."</td><td>".$data['no']."</td><td>".$data['top']."</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td>".$data['vol']."</td><td>".$data['sat']."</td><td>".$data['hargasat']."</td><td>".$data['jumlah']."</td><td>".$data['sdana']."</td><td>".$data['mak']."</td><td></td></tr>";
}
echo "</table>";
