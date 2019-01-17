<?php
require_once( '../class/class.php' );
require_once( '../class/func_app1.php' );
$ex=explode("_",$_GET['id']);
//$jd=app_baca("jadwal","id_jadwal='".$_GET['id']."'","id_popt");
//if ($jd>0) {app_delete("jadwal","id_jadwal='".$_GET['id']."'");$x="dihapus";} 
app_replace("realisasi","'".$ex[0]."_".$ex[1]."_".$ex[2]."','".$ex[0]."','".$ex[1]."','".$ex[2]."','".$ex[3]."'");$x="diupdate";
$j=realisasi_jml($ex[1],$_GET['th']);
echo $j;
