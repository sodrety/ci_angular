<style>
* {font-family:arial;font-size:12px;overflow: hidden}
</style>
<?php
require_once( '../class/class.php' );
app_replace("sla_f_ttd","'".$_GET['tgl']."_".$_GET['id_lokasi']."','".$_POST['jab']."','".$_POST['id_popt']."'");
echo "OK";
