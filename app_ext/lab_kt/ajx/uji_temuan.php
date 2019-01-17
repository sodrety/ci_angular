<?php
require_once( '../class/class.php' );
$uji = new uji();
while ($i<3000000) {
$i++;
}
echo $uji->uji_temuan($_GET['idh']);
