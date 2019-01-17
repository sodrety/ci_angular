<?php
require('../print/fpdf/mc_table.php');
include "../class/class.php";

$id=$_GET['d'];
$db = new database();
$db->connect(app_db());
$query = "SELECT * from barcode WHERE id='".$id."'";
$results = $db->get_results( $query );
foreach( $results as $data )
{}
$no_aju=$data['no_aju'];
$kode=$data['kode'];
$pdf=new PDF_MC_Table('L','mm',array(70,50));
$pdf->SetMargins(10,0,10);
$pdf->AddPage();
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,5,'Dropbox Karantina Priok',0,1,'C');
$pdf->Code128(3,5,substr($no_aju,5,50),64,15);
$pdf->Text(3,25,$no_aju);
$pdf->Code128(5,27,$kode,60,15);
$pdf->Text(5,45,"KD : ".$kode);


$pdf->Output();
?>
