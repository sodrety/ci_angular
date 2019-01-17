<?php
include "../class/class.php";
$db = new database7();
$db->connect("barantan");
$query = "SELECT no_aju,jenis_permohonan,nama_pengirim,nama_penerima,created_at,updated_at FROM ppk WHERE updated_at>='2018-08-29 06:28:23'  order  by updated_at limit ".$_GET['l'].",100";
$results = $db->get_results( $query );
$n=$_GET['l'];

foreach( $results as $data) {
$na=explode("-",$data['no_aju']);
$ak=substr($na[1],0,7);
$ll=substr($data['jenis_permohonan'],0,1);
if ($data['jenis_permohonan']=="IMPOR" or $data['jenis_permohonan']=="DOMAS") {$pt=$data['nama_penerima']; } else {$pt=$data['nama_pengirim']; }
echo "".$data['updated_at']." ".$ak." ".$pt." <br>";

$idb=app_baca("akun_pj","akun='".$ak."'","akun");
if ($idb=="") {
app_query("INSERT INTO akun_pj (`akun`,`perusahaan`,`waktu`) VALUES ('".$ak."', '".$pt."', '".$data['updated_at']."')");
} else {
app_update("akun_pj","akun='".$ak."'","akun='".$ak."', perusahaan='".$pt."', waktu='".$data['updated_at']."'");
}
$n++;
echo "<meta http-equiv=\"refresh\" content=\"2; URL=?l=".$n."\">";
}
