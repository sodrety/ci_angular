<?php
require_once( '../class/class.php' );

$n=$_GET['n'];
$h=array(0,1,2,3,4,5,6,7,8,9,"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");	

foreach( $h as $a )
{
$n+=36;
$n0=($n-36)+1;
echo $n0." ".$n." ".$a."<br>";
app_update("m_kode","id_kode>='".$n0."' AND id_kode<='".$n."' ", "b='".$a."'");
}
if ($n>=1679616) {exit;}
echo "<meta http-equiv=\"refresh\" content=\"0; URL=?n=".$n."\">";
