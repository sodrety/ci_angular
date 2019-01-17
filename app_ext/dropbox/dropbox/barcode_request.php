<?php
require_once( '../class/class.php' );
function st0() {
echo "<form method=post action='?s=1'>No Aju: <input type=text name=no_aju size=70> <input type=submit value=Next></form>";
}


function st1() {
if (strstr($_POST['no_aju'],"0300-")) {
$no_aju=str_replace(" ","",$_POST['no_aju']);
$no_aju=str_replace("	","",$no_aju);
$idc=app_baca("barcode","no_aju='".$no_aju."'","id");
if ($idc=="") {app_query("INSERT INTO barcode (`no_aju`,`input_time`,`update_time`) VALUES ('".$no_aju."', '".now()."', '".now()."')");
$idc=app_baca("barcode","no_aju='".$no_aju."'","id");

} else {app_update("barcode","no_aju='".$no_aju."'","update_time='".now()."'"); }
app_update("barcode","id='".$idc."'","kode='".kode($idc)."'");
$akun=substr ($no_aju,5,7);
echo "<form method=post action='?s=2'><input type=hidden name=id value='".$idc."'>
<table><tr><td>No Aju: </td><td>".$no_aju." (".$akun.")</td></tr>
<tr><td>No HP: </td><td><input type=number name=hp value='".$hp."'></td></tr>
<tr><td>Email: </td><td><input type=text name=email value='".$email."'></td></tr>
<tr><td></td><td><input type=submit value=Next></td></tr></table></form>";
} else {echo now()." Gagal: No Aju tidak Valid"; st0();}

}

function st2() {
if (strlen($_POST['hp'])>"10" and strstr($_POST['email'],"@")) {
$id=$_POST['id'];
app_update("barcode","id='".$id."'","hp='".$_POST['hp']."',email='".$_POST['email']."'");
echo " Request Berhasil<meta http-equiv=\"refresh\" content=\"0; URL=barcode.php?x=".md5("t")."&e=".md5("g")."&d=".$id."&u=".md5("h")."\">";
} else {echo now()." Gagal: Data tidak disi / tidak Valid"; st0();}
}

echo "<h2>Request Kode Dropbox</h2><h3>Balai Besar Karantina Pertanian Tanjung Priok</h3>";
if ($_GET['s']=="") {st0();} elseif ($_GET['s']=="1") {st1();} elseif ($_GET['s']=="2") {st2();} 
