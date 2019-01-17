<style>
* {font-family:arial;font-size:12px;overflow: hidden; color:red; font-weight:700;}
</style>
<?php
require_once( '../class/class.php' );
app_delete("sla_fisik","no_reg='".$_GET['no_reg']."'");
echo "Del";
