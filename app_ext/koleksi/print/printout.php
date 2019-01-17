<?php
include "../class/class.php";
$id=$_GET['id'];
$v=$_GET['v'];
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM koleksi WHERE id='".$id."'";
$results = $db->get_results( $query );
foreach( $results as $data) {
$id=$data['id'];
$tahun=$data['tahun'];
$bidang=$data['bidang'];
$nrk=$data['nrk'];
$inang=$data['inang'];
$lokasi=$data['lokasi'];
$gps_ns_a=$data['gps_ns_a'];
$gps_ns_b=$data['gps_ns_b'];
$gps_ns_c=$data['gps_ns_c'];
$gps_ns=$data['gps_ns'];
$gps_we_a=$data['gps_we_a'];
$gps_we_b=$data['gps_we_b'];
$gps_we_c=$data['gps_we_c'];
$gps_we=$data['gps_we'];
$sumber=$data['sumber'];
$tgl_koleksi=$data['tgl_koleksi'];
$kolektor=$data['kolektor'];
$jenis_kel=$data['jenis_kel'];
$jenis_subs=$data['jenis_subs'];
$jenis_spes=$data['jenis_spes'];
$jenis_fam=$data['jenis_fam'];
$jenis_ordo=$data['jenis_ordo'];
$gender=$data['gender'];
$stadia=$data['stadia'];
$mounting=$data['mounting'];
$jumlah_spesimen=$data['jumlah_spesimen'];
$tgl_ident=$data['tgl_ident'];
$ident_oleh=$data['ident_oleh'];
$foto=$data['foto'];
$lokasi_simpan=$data['lokasi_simpan'];
$ket=$data['ket'];
$kode_pemilik=$data['kode_pemilik'];
$entri_oleh=$data['entri_oleh'];
$entri_tgl=$data['entri_tgl'];
$update_oleh=$data['update_oleh'];
$update_tgl=$data['update_tgl'];
}
$nrk1="000000".$nrk;
$m=strlen($nrk1)-6;
$nrkp=substr ($nrk1, $m, 6);

if ($v=="oh") {
echo "
<style>
* {font-family:arial;font-size:12px;}
html,body,table {margin:0px;padding:0px}
</style><html><body>
<table cellspacing='1px'><tr><td>NRK</td><td width='1px'>:</td><td>".substr ($jenis_ordo, 0, 5).$nrkp."$jenis_kel.$tahun.$bidang</td></tr>
<tr><td>Spesies/Famili/Ordo</td><td>:</td><td>$jenis_spes/$jenis_fam/$jenis_ordo</td></tr>
<tr><td>Tanggal Identifikasi</td><td>:</td><td>".tgl($tgl_ident)."</td></tr>
<tr><td>Identifikasi Oleh</td><td>:</td><td>$ident_oleh</td></tr>
<tr><td>Stadia</td><td>:</td><td>$stadia</td></tr>
<tr><td>Mounting/Metode</td><td>:</td><td>$mounting</td></tr>
<tr><td>Inang/MP/Habitat/Attractan</td><td>:</td><td>$inang</td></tr>
<tr><td>Lokasi</td><td>:</td><td>$lokasi</td></tr>
<tr><td>Sumber</td><td>:</td><td>$sumber</td></tr>
<tr><td>Tanggal Koleksi</td><td>:</td><td>".tgl($tgl_koleksi)."</td></tr>
<tr><td>Kolektor</td><td>:</td><td>$kolektor</td></tr>
<tr><td>Kode Pemilik</td><td>:</td><td></td></tr>
</table></body></html>";
} 
elseif ($v=="mp") {
echo "
<style>
* {font-family:arial;font-size:12px;}
html,body,table {margin:0px;padding:0px}
</style><html><body>
<table cellspacing='1px'><tr><td>NRK</td><td width='1px'>:</td><td>".substr ($jenis_ordo, 0, 5).$nrkp."$jenis_kel.$tahun.$bidang</td></tr>
<tr><td>Media Pembawa</td><td>:</td><td>$inang</td></tr>
<tr><td>Asal/Tujuan</td><td>:</td><td></td></tr>
<tr><td>Lokasi</td><td>:</td><td>$lokasi</td></tr>
<tr><td>Sumber</td><td>:</td><td>$sumber</td></tr>
<tr><td>Tanggal Koleksi</td><td>:</td><td>".tgl($tgl_koleksi)."</td></tr>
<tr><td>Kolektor</td><td>:</td><td>$kolektor</td></tr>
<tr><td>Kode Kepemilikan</td><td>:</td><td></td></tr>
</table></body></html>";
}

?>
