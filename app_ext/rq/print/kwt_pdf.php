<?php
require_once( '../class/class.php' );
$id=$_GET['id'];
$rp=rq_baca("cost","id='".$id."'","harga");
$no=rq_baca("cost","id='".$id."'","no");
$ttd=rq_baca("cost","id='".$id."'","ttd");
if ($ttd=="Yang Membayarkan : Bendahara Pengeluran") {$td="
Yang Membayarkan
Bendahara Pengeluaran,





".rq_baca("global","kolom='bendahara_nama'","isi")."
NIP. ".rq_baca("global","kolom='bendahara_nip'","isi")."";} else {$td="






".$ttd."";}
$ttdd=rq_baca("global","kolom='tempat'","isi").", ".tgl_p(rq_baca("cost","id='".$id."'","tgl")).$td;
$ppk="Pejabat Pembuat Komitmen ".rq_baca("global","kolom='nama_unit'","isi");
$terbilang=terbilang($rp)." Rupiah";



require('../class/fpdf.php');
$pdf = new FPDF('L','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',17);
$pdf -> SetXY(110,60); 
$pdf->MultiCell(0,6,$id,0); 

$pdf->SetFont('Arial','',10);
$pdf -> SetXY(145,70);
$pdf->MultiCell(0,4,$ppk,0); 
$pdf -> SetXY(145,81);
$pdf->MultiCell(0,4,$terbilang,0);
$pdf -> SetXY(100,90);
$pdf->MultiCell(0,4,"                                 ".rq_baca("cost","id='".$id."'","untuk")." an ".rq_baca("cost","id='".$id."'","kepada").". Akun ".rq_baca("pok","no='".$no."'","mak")." (".rq_baca("pok","no='".$no."'","dana").") pada ".rq_baca("global","kolom='nama_unit'","isi"),0);
$pdf -> SetXY(205,110);
$pdf->MultiCell(0,4,$ttdd,0,'C');
$pdf->SetFont('Arial','B',15);
$pdf -> SetXY(115,128);
$pdf->MultiCell(0,4,rp($rp),0);

$pdf->Output();
?>