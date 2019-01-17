<?php
include "../class/class.php";

function phyto_r($no,$id) {
$db = new database();
$db->connect("phyto");
$query = "SELECT * FROM pc_e WHERE no_permohonan='".$no."' order by last_update desc limit 0,1";
$results = $db->get_results( $query );
foreach( $results as $data) {
app_query("REPLACE INTO pc_e VALUES ('".$id."', '".$data['tgl_tercetak']."', '".$data['to_quarantine']."' ,'".$data['nama_pengirim']."' ,'".$data['alamat_pengirim']."' ,'".$data['nama_penerima']."' ,'".$data['alamat_penerima']."' ,'".$data['jml_packing']."' ,'".$data['tanda_pembungkus']."' ,'".$data['asal_komoditi']."' ,'".$data['jenis_nama_aa']."' ,'".$data['pelabuhan_tujuan']."' ,'".$data['nama_jml_komoditas']."' ,'".$data['komoditas_ilm']."' ,'".$data['add_declaration']."' ,'".$data['tgl_perlakuan']."' ,'".$data['treatment']."' ,'".$data['chemical']."' ,'".$data['durasi']."' ,'".$data['temperatur']."' ,'".$data['konsentrasi']."' ,'".$data['add_information']."' ,'".$data['terbit_di']."','".$data['nama_ttd']."' , 'User' , '".$data['last_update']."', '0', '-')");
}
//return "a";
}

$db = new database();
$db->connect(app_db());
$ll="E";
$query = "SELECT no_reg,id FROM barcode  WHERE no_reg LIKE '%E%' order by input_time limit ".$_GET['l'].",100";
$results = $db->get_results( $query );
$n=$_GET['l'];
foreach( $results as $data) {
echo $data['no_reg']." ".$data['id']."<br>";
echo phyto_r($data['no_reg'],$data['id']);
$n++;


echo "<meta http-equiv=\"refresh\" content=\"0; URL=?l=".$n."\">";

}
