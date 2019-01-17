<?php
session_start();
require_once( 'class/class.php' );
require_once( 'class/func_app1_admin.php');
$id=$_GET['id'];

echo "<form method=post><select name=kode><option value='E'>Ekspor</option><option value='I'>BC-23</option></select> NO KT-2<input type=number name='no_permohonan' value='' style='width:60px;'> Jml Ptgs:<input type=number name=jumlah value='2' style='width:50px;'> Kota:<select name=kota><option></option>".kota_opt()."</select> <input type=submit name=tambah value='Tambah'><input type=hidden name=kode_doc value='I'><input type=hidden name=id value='".$id."'></form>";
     $db = new database();
$db->connect(app_db());
$query ="SELECT * FROM alokasi WHERE group_id='".$id."' order by no_permohonan";
$results = $db->get_results( $query );
echo "<table class='table'>";
foreach( $results as $data )
{
$n++;
echo "<tr><td>".$n."</td><td>".$data['no_permohonan']."</td><td>".$data['perusahaan']."</td><td>".$data['kota']."</td><td>".$data['jml_petugas']."</td></tr>";
}
echo "</table>";
