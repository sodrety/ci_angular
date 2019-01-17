<?php
require_once( '../class/class.php' );
$ex=explode("_",$_GET['id']);
$jd=app_baca("jadwal","id_jadwal='".$_GET['id']."'","id_popt");
if ($jd>0) {app_delete("jadwal","id_jadwal='".$_GET['id']."'");$x="dihapus";} 
else {app_replace("jadwal","'".$_GET['id']."','".$ex[1]."','".$ex[0]."'");$x="diupdate";}

echo $_GET['id']." ".$x;
