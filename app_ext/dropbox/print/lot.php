<?php
require('fpdf/mc_table.php');
include "../class/class.php";

$kode=$_GET['k'];
$pdf=new PDF_MC_Table('L','mm',array(70,50));
$pdf->SetMargins(10,10,10);
$pdf->AddPage();
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,5,'Lot Code',0,1,'C');
$pdf->Cell(0,5,$kode,0,1,'C');
$pdf->Code128(15,20,$kode,40,20);
$pdf->Output();
?>
