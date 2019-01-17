<?php
require('fpdf/mc_table.php');
include "../class/class.php";

function va($v) {
if ($v=="checked") {$r="V";} else {$r="  ";}
return $r;
}
function vb($v) {
if ($v!="checked") {$r="V";} else {$r="  ";}
return $r;
}
function k1($v) {
if ($v=="1") {$r="V";} else {$r="  ";}
return $r;
}
function k2($v) {
if ($v=="2") {$r="V";} else {$r="  ";}
return $r;
}

$pdf=new PDF_MC_Table('P','mm','A4');
$pdf->SetMargins(20,65,20);
$pdf->AddPage();
$pdf->Image('terima_kop.png',10,10,190);
$id=$_GET['id'];
$db = new database();
$uji = new uji();
$sup = new sup();
$db->connect(app_db());
$query = "SELECT * from uji where id='$id' limit 0,1";
$results = $db->get_results( $query );
foreach( $results as $data )
{

$pdf->SetFont('Arial','',11);



$pdf->SetWidths(array(40,5,45,40,5,45));

$pdf->Row(array("Nomor Seri",":",$data['kode'],"Tanggal Pengambilan",":",tgl_p($data['ambil_tgl'])));
$pdf->Row(array("Tanggal Terima ",":",tgl_p($data['terima_tgl']),"Petugas",":",$data['ambil_petugas']));
$pdf->Row(array("Jenis Media Pembawa",":",$data['komoditi'],"Nomor Berita Acara",":",$data['kirim_nomor'].$sup->no_srt_kirim($data['id'],$data['ll'])));
$pdf->SetWidths(array(40,5,120));
$pdf->Row(array("Identitas Pemilik	",":",$data['kirim_jab']));
$pdf->Row(array("Alamat",":",$data['alamat']));
$pdf->Row(array("Target OPTK/HPH(K)",":",$uji->uji_target_print($id)));
$ver=" YA  TIDAK
( ".va($data['v1'])." )   ( ".vb($data['v1'])." )   Ketersediaan Metode Uji
( ".va($data['v2'])." )   ( ".vb($data['v2'])." )   Kemampuan Peralatan
( ".va($data['v3'])." )   ( ".vb($data['v3'])." )   Ketersediaan Reagen
( ".va($data['v4'])." )   ( ".vb($data['v4'])." )   Keterampilan Analis
( ".va($data['v5'])." )   ( ".vb($data['v5'])." )   Kecukupan Jumlah Contoh uji
( ".va($data['v6'])." )   ( ".vb($data['v6'])." )   Kenormalan Kondisi Contoh uji
( ".va($data['v7'])." )   ( ".vb($data['v7'])." )   Kemampuan laboratorium Sub Kontrak";

$pdf->Row(array("Verifikasi",":",$ver));
$pdf->Row(array("Catatan",":",$data['catatan']));
$pdf->Row(array("Kesimpulan",":","( ".k1($data['kesimpulan'])." ) Dapat dilakukan pengujian
( ".k2($data['kesimpulan'])." ) Tidak dapat dilakukan pengujian"));
$pdf->SetWidths(array(70,70,40));
$pdf->Row(array("","","
"));
$pdf->Row(array("Diserahkan oleh,","Diterima oleh,","Dikaji oleh,



"));
$pdf->Row(array(db_baca("user_login","karyawan","id='".$data['serahkan_oleh']."'","nama"),db_baca("user_login","karyawan","id='".$data['terima_oleh']."'","nama"),db_baca("user_login","karyawan","id='".$data['kaji_oleh']."'","nama")));
$pdf->Row(array("Penguna Jasa","Staf Administrasi","Penyelia/Analis"));

$pdf->MultiCell(0,5,"
Beri tanda thick (V) pada kolom yang sesuai.");

$pdf->SetDrawColor(111, 111, 111);
$pdf->Line(0,260,210,260);
$pdf->Code128(145,263,$data['kode'],40,20);
$pdf->SetFont('Arial','',12);
$pdf->Text(150,288,$data['kode']);
}


$pdf->Output();
?>
