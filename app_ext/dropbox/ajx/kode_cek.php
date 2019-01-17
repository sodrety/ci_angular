<?php
require_once( '../class/class.php' );
$db = new database();
$db->connect(app_db());
$query = "SELECT * from barcode where kode is NULL order by id limit ".$_GET['l'].",1";
$results = $db->get_results( $query );
$n=0;
$ll="I";
foreach( $results as $data )
{
echo $data['id']."<br>".$data['kode']."<br>".kode($data['id'])."<br>";

echo " ".kode($data['id']-1)." ".kode($data['id'])." ".kode($data['id']+1)."<br>";
echo " ".kode(1296)." ".kode(46656+1)." ".kode(1679616+1)."<br>";

//echo "<meta http-equiv=\"refresh\" content=\"0; URL=?l=".($_GET['l']+1)."\">";

}


