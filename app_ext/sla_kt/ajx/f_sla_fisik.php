<?php
require_once( '../class/class.php' );
$tgl=$_GET['tgl'];
$tglm=$_GET['tglm'];
$lokasi=$_GET['lokasi'];
$no_reg=$_GET['no_reg'];
//$jd=app_baca("jadwal","id_jadwal='".$_GET['id']."'","id_popt");
//if ($jd>0) {app_delete("jadwal","id_jadwal='".$_GET['id']."'");$x="dihapus";} 
//else {app_replace("jadwal","'".$_GET['id']."','".$ex[1]."','".$ex[0]."'");$x="diupdate";}

//echo $_GET['id']." ".$x;
if ($no_reg=="") {
$no_reg=date("Y").".2.0300.0.S01.I.";
$dp1 =$tgl;
$dp1t=$tglt=date("H:i").":00";
$status="LR";
} else {
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM sla_fisik no_reg='".$no_reg."' limit 0,1";
$results = $db->get_results( $query );
foreach( $results as $data )
{

}
}


echo "<form method=post>
<table class='table' width=100%>

<thead>
<tr><th>NO</th><th>LOKASI</th><th>NO DOKUMEN</th><th>SAMPLING</th><th>TOTAL</th><th>STATUS</th><th>WAKTU AWAL (DP-1)</th><th>WAKTU NSW (KT-9)</th><th>NO SERI</th><th></th></tr>
</thead>

<tbody>
<tr align=center><td>NO</td><td>$lokasi<input type=hidden name=lokasi value='$lokasi'></td><td><input type=text size=25 name=no_reg value='$no_reg'></td><td><input type=text size=10 name=sampling value='1'></td><td><input type=text size=10 name=total value='1'><select name=feet><option>40</option><option>20</option></select>feet</td><td><select name=status><option>$status</option><option>LR</option><option>MR</option><option>HR</option></select></td><td><input type=date size=10 name=dp1 value='$dp1'> <input type=time size=10 name=dp1t value='$dp1t'></td><td><input type=date size=10 name=tgl value='$tgl'> <input type=hidden  name=tglm value='$tglm'>  <input type=time size=10 name=tglt value='$tglt'></td><td><input type=number size=7 name=seri value='$seri'></td><td><input type=submit name=simpan value='Simpan'></td></tr>
</tbody>
</table></form>";
