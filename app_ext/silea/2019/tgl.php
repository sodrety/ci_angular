<?php
require_once( 'class/class.php' );
$t=$_GET['t'];
echo $t."<br>";
db_replace("user_login","app_antrian","'".$t."', '0', '0', '0'");
if ($t=="2018-12-31") {exit;}
  echo " <meta http-equiv=\"refresh\" content=\"0; URL=?t=".next_date($t)."\">";
