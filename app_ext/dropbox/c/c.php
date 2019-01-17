<?php
class dbn {

}



class tk {
	
function luar0() {
$db = new database56();
$db->connect(tugasdb());
$query = "SELECT distinct(pt) FROM tk_luar order by pt";
$results = $db->get_results( $query );

foreach( $results as $data) {
	$no++;
		
$dt.="<tr><td>".$no."</td><td>".$data['pt']."</td><td>".db56_baca(tugasdb(),"tk_luar","pt='".$data['pt']."'","ke")."</td><td>".db56_jml(tugasdb(),"tk_luar","pt='".$data['pt']."'","pt")."</td></tr>";
}
echo "<table class=table>".$dt."</table>";
}

function luar() {
$db = new database56();
$db->connect(tugasdb());
$query = "SELECT id,no,dari,kota,tujuan,waktu_selesai FROM spt WHERE waktu_selesai LIKE '2018%' and no LIKE '%D01%' and ((dari='Jakarta' and kota NOT LIKE '%Jakarta%') or (dari='Bogor' and kota NOT LIKE '%Bogor%') or (dari='Bekasi' and kota NOT LIKE '%Bekasi%')) ";
$results = $db->get_results( $query );

foreach( $results as $data) {
	$no++;
	$ex=explode("Milik/Perusahaan",$data['tujuan']);
	$x2=explode("(",$ex[1]);
	$pt=str_replace(": ","",$x2[0]);
	$pt=str_replace("."," ",$pt);	
	$pt=str_replace("  "," ",$pt);
	$pt=str_replace("  "," ",$pt);
db56_replace(tugasdb(),"tk_luar","'".$no."','".$data['id']."','".$data['waktu_selesai']."','".$data['no']."','".$data['tujuan']."','".$pt."','".$data['dari']."','".$data['kota']."'")	
$dt.="<tr><td>".$no."</td><td>".$data['id']."</td><td>".$data['waktu_selesai']."</td><td>".$data['no']."</td><td>".$data['tujuan']."</td><td>".$pt."</td><td>".$data['dari']."</td><td>".$data['kota']."</td><td></td></tr>";
}
echo "<table class=table>".$dt."</table>";
}	
	
}