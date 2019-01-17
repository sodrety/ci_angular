<?php
session_start();
require_once( 'class/class.php' );
setcookie("rq_db", "rq_2018_but", time()+(3600*24*30*12));
//if (user_id()=='') { exit;}
include "sys.php";
?>