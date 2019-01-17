<?php
header ( "Content-type: application/vnd.ms-excel" );
header ( "Content-Disposition: attachment; filename=surat_keluar.xls" );
include "../class/class.php";
$db = new database();
$db->connect("b_office");
$no=1;
$query="SELECT * FROM sm WHERE tgl>='".$_GET['m']."' and tgl<='".$_GET['s']."'";
$results = $db->get_results( $query );
echo "<table><tr><th>NO</th><th>TGL SURAT</th><th>NO SURAT</th><th>HAL</th><th>PENERIMA</th></tr>";
foreach( $results as $data )
{
	$n++;
echo "<tr valign='top'><td align=center>$n</td><td>".$data['tgl_surat']."</td><td>".$data['no_surat']."</td><td>".$data['hal']."</td><td>".$data['penerima']."</td></tr>";
$no++;
}
echo "</table>";
