<?php
require('fpdf/mc_table.php');
include "../class/class.php";
$id=$_GET['id'];

$org="Balai Uji Terap Teknik dan Metode Karantina Pertanian";
$pdf=new PDF_MC_Table('P','mm','A4');
$pdf->SetMargins(28,20,20);
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,5,'L a m p i r a n',0,1,'L');
$pdf->SetFont('Arial','',11);
$pdf->SetWidths(array(25,5,135));
$tgl=app_baca("spt","id='$id'","tgl");
$pdf->Row(array("Surat Tugas",":","".app_baca("spt","id='$id'","no_spt")."/".app_baca("spt_global","name='nomor'","value")."/".substr($tgl,5,2)."/".substr($tgl,0,4).""));
$pdf->Row(array("Tanggal",":",tgl_p($tgl)));

$pdf->Cell(0,5,'',0,1,'L');
$db = new database();
$db->connect("b_office");
$no=1;
$query = "SELECT * from spt_petugas where id_spt='$id' order by no";
$results = $db->get_results( $query );
$pdf->SetWidths(array(8,60,40,50));
$pdf->SetBorderColor(array(0,0,0,0));
$pdf->SetFontStyle(array("B","B","B","B"));
$pdf->SetAligns(array('C','C','C','C'));
$pdf->Row(array("No","Nama / NIP","Pangkat / Golongan","Jabatan"));
$pdf->SetFontStyle(array("","","",""));
$pdf->SetAligns(array('C','L','L','L'));
foreach( $results as $data )
{
if ($no=="1") {$kep="Kepada:";} else {$kep="";}
$pdf->Row(array($no.".","".$data['nama']."/ ".$data['nip']."","".pangkat($data['gol'])."/".$data['gol']."","".$data['jab'].""));
$no++;
}
$unik=app_baca("spt","id='$id'","unik");
$code="B-office *".$unik."*";
$pdf->SetDrawColor(111, 111, 111);
$pdf->Line(0,273,210,273);
$pdf->Code128(130,275,$unik,60,8);
$pdf->SetFont('Arial','',6);
$pdf->Text(140,286,$code);
$pdf->Output();
?>
