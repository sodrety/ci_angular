<?php
require_once( '../class/class.php' );
$uji = new uji();
sleep(1);
echo $uji->uji_target($_GET['id']);
