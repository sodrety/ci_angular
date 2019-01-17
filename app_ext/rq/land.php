<?php
session_start();
include "../../class/class.php";
$_SESSION['user_id'] =str_replace(md5(date("Ymd")),"",$_GET['usr']);
header ('location:index.php')
?>

