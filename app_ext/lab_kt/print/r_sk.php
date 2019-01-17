<?php
require('fpdf/mc_table_pg.php');
include "../class/class.php";

$query="SELECT * FROM sk WHERE tgl_surat>='".$_GET['m']."' and tgl_surat<='".$_GET['s']."'";
$pdf=new PDF_MC_Table('L','mm','A4');
$pdf->SetMargins(25,20,20);
$pdf->AddPage();
$pdf->SetFont('Arial','B',13);
$pdf->Cell(0,5,'REKAPITULASI SURAT KELUAR',0,1,'C');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,5,'Balai Uji Terap Teknik dan Metode Karantina Pertanian',0,1,'C');
$per="Periode ".tgl_p($_GET['m'])." s.d ".tgl_p($_GET['s'])."";
$pdf->Cell(0,5,$per,0,1,'C');
$pdf->SetFont('Arial','',11);
$pdf->SetWidths(array(25,5,135));

$pdf->Cell(0,5,'',0,1,'L');
$db = new database();
$db->connect("b_office");
$no=1;
$results = $db->get_results( $query );

$pdf->SetWidths(array(8,30,60,78,73));
$pdf->SetBorderColor(array(0,0,0,0,0));
$pdf->SetFontStyle(array("B","B","B","B","B"));
$pdf->SetAligns(array('C','C','C','C','C'));
$pdf->Row(array("NO","TGL SURAT","NO SURAT","HAL","PENERIMA"));
$pdf->SetFontStyle(array("","","",""));
$pdf->SetAligns(array('C','L','L','L','L'));
$no=1;
foreach( $results as $data )
{
$pdf->Row(array($no.".","".tgl_p($data['tgl_surat'])."","".$data['no_surat']."","".$data['hal']."",""));
$no++;
}
$code="B-office *";
$pdf->SetDrawColor(111, 111, 111);
$pdf->Line(0,188,300,188);
$pdf->Code128(220,190,$code,60,8);
$pdf->SetFont('Arial','',6);
$pdf->Text(230,201,$code);
$pdf->Output();
?>
