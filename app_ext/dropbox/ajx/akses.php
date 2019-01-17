<?php
require_once( '../class/class.php' );
$jm=date("H");
$jum=app_jml("klik_log_view","waktu LIKE '".today()."%' and waktu LIKE '% ".$jm.":%'","waktu");
app_replace("klik_log_view_today","'".($jm*1)."','".$jum."'");
echo $jum;
?> 
