<?php
require('fpdf/mc_table.php');
include "../class/class.php";

$kode=$_GET['k'];
$pdf=new PDF_MC_Table('P','mm',array(40,45));
$pdf->SetMargins(5,0,5);
$pdf->AddPage();
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,5,'Lot Code',0,1,'C');
$pdf->Cell(0,5,$kode,0,1,'C');
$pdf->Code128(5,10,$kode,30,20);
$pdf->Output();
?>
