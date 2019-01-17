<?php
require_once( '../class/class.php' );
$db = new database();
$db->connect("movedb");
$query = "SELECT * from tblPerusahaan where StatMe='1' and Ket LIKE '% %' order by NmPerusahaan";
$results = $db->get_results( $query );
echo "<table border=1>";
foreach( $results as $data )
{
$n++;
echo "<tr><td>".$n."</td><td>".$data['NmPerusahaan']."</td><td>".$data['Ket']."</td></tr>";


}




