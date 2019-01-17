<?php
require('fpdf/mc_table.php');
include "../class/class.php";


$pdf=new PDF_MC_Table('P','mm','A4');
$pdf->SetMargins(25,20,20);
$pdf->AddPage();

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
$pdf->MultiCell(0,5,"





");
$pdf->Cell(0,5,'Jakarta, '.tgl_p($data['kirim_tgl']),0,1,'R');
$pdf->SetWidths(array(22,5,130));
$pdf->Row(array("Nomor",":",$data['kirim_nomor'].$sup->no_srt_kirim($id,$data['ll'])));
$pdf->Row(array("Lampiran",":","1 lembar"));
$pdf->Row(array("Perihal",":","Pengiriman Sampel"));

$pdf->MultiCell(0,5,"
Kepada Yth,
Laboratorium BBKP Tanjung Priok
Di
     Padamarang, Jakarta     
     ");
     $pdf->MultiCell(0,5,"Bersama ini kami sampaikan Media Pembawa OPTK untuk dilakukan pengujian kesehatan tumbuhan, dengan identitas sampel sebagai berikut:");
     
$pdf->SetWidths(array(40,5,110));
$pdf->Row(array("Kode Sampel",":",$data['kode']));
$pdf->Row(array("Lokasi Pemohon",":",app_baca("m_lokasi","id_lokasi='".$data['lokasi']."'","lokasi")));
$pdf->Row(array("Nama Komoditi",":",$data['komoditi']));
if ($_GET['u']=="arsip") {
$nor=" (".$data['no_reg'].")";
}
$pdf->Row(array("Lalu Lintas",":",app_baca("m_ll","id='".$data['ll']."'","ll").$nor));
$pdf->Row(array("Asal/Tujuan",":",$data['asal']));

$jl=app_jml("uji_lot","id_uji='".$data['id']."' LIMIT 3,1","id_uji");
if ($jl>0) {$ll=$uji->uji_lot_print($data['id']);} else {$ll=":
".$uji->uji_lot_print($data['id']);}
$pdf->Row(array("Jumlah Lot/Sampel",":",app_jml("uji_lot","id_uji='".$data['id']."'","id")." lot/sampel".$ll));


$jt=app_jml("uji_target","id_uji='".$data['id']."' LIMIT 3,1","id_uji");
if ($jt>0) {$target="Terlampir";} else {$target=$uji->uji_target_print($data['id']);}
$pdf->Row(array("Target Pest",":",$target));
$pdf->Row(array("Keterangan",":",$data['kirim_ket']));

$pdf->MultiCell(0,5,"Demikian kami sampaikan, atas perhatian dan kerjasamanya diucapkan terima kasih.");

$pdf->SetWidths(array(50,60,50));
$pdf->SetAligns(array('C','C','C'));
$pdf->Row(array("
Penerima Sampel



","
Diserahkan oleh","
".$data['kirim_jab'].""));

$pdf->Row(array("(                                  )",db_baca("user_login","karyawan","id='".$data['serahkan_oleh']."'","nama"),db_baca("user_login","karyawan","id='".$data['kirim_nama']."'","nama")));
$pdf->Row(array("NIP.                         ",db_baca("user_login","karyawan","id='".$data['serahkan_oleh']."'","nip"),db_baca("user_login","karyawan","id='".$data['kirim_nama']."'","nip")));
 
$pdf->SetDrawColor(111, 111, 111);
$pdf->Line(0,260,210,260);
$pdf->Code128(145,263,$data['kode'],40,20);
$pdf->SetFont('Arial','',12);
$pdf->Text(150,288,$data['kode']);
}
if ($jt>0 or $jl>0) {

$pdf->AddPage();
$pdf->MultiCell(0,5,"LAMPIRAN
Kode Sampel: ".$data['kode']."

");
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(0,5,"Target Pengujian:
".$uji->uji_target_print($data['id']));
$pdf->MultiCell(0,5,"
Daftar Lot:
".$uji->uji_lot_print($data['id']));
}
$pdf->Output();

?>
