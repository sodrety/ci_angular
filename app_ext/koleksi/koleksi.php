<?php
session_start();
include "../../class/class.php";
$_SESSION['user_id'] =str_replace(md5(date("Ymd")),"",$_GET['usr']);
$_SESSION['start'] = time();
$_SESSION['expire'] = $_SESSION['start'] + (12 * 30 * 60);
?>
<h2><a href='optk.php'>OPTK</a>&nbsp;&nbsp;&nbsp;<a href='hphk.php'>HPHK</a></h2>
