<?php
require('fpdf/mc_table_pg.php');
include "../class/class.php";

$query="SELECT * FROM spt WHERE tgl>='".$_GET['m']."' and tgl<='".$_GET['s']."'";
$pdf=new PDF_MC_Table('L','mm','A4');
$pdf->AliasNbPages();
$pdf->SetMargins(25,20,20);
$pdf->AddPage();
$pdf->SetFont('Arial','B',13);
$pdf->Cell(0,5,'REKAPITULASI SURAT TUGAS',0,1,'C');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,5,'Balai Uji Terap Teknik dan Metode Karantina Pertanian',0,1,'C');
$per="Periode ".tgl_p($_GET['m'])." s.d ".tgl_p($_GET['s'])."";
$pdf->Cell(0,5,$per,0,1,'C');
$pdf->SetFont('Arial','',11);
$pdf->SetWidths(array(25,5,135));

$pdf->Cell(0,5,'',0,1,'L');

function st_petugas($id) {
$db = new database();
$db->connect("b_office");	
$query="SELECT * FROM spt_petugas  WHERE id_spt='".$id."' order by no";	
$results = $db->get_results( $query );	
foreach( $results as $data )
{
	$no++;
$dt.=$no.". ".$data['nama']."\n";
}
return $dt;
}

$db = new database();
$db->connect("b_office");
$no=1;
$results = $db->get_results( $query );

$pdf->SetWidths(array(8,30,25,50,58,25,53));
$pdf->SetBorderColor(array(0,0,0,0,0,0,0));
$pdf->SetFontStyle(array("B","B","B","B","B","B","B"));
$pdf->SetAligns(array('C','C','C','C','C','C','C'));
$pdf->Row(array("NO","TGL SPT","TGL TUGAS","NO SURAT","TUGAS","KOTA","PENERIMA TUGAS"));
$pdf->SetFontStyle(array("","","","","","",""));
$pdf->SetAligns(array('C','L','L','L','L','L','L'));
$no=1;
$nomor=app_baca("spt_global","name='nomor'","value");
foreach( $results as $data )
{
	$tgl=$data['tgl'];
$no_spt=$data['no_spt']."/".$nomor."/".substr($tgl,5,2)."/".substr($tgl,0,4);
$pdf->Row(array($no.".",tgl_p($data['tgl']),tgl($data['waktu_mulai'])." - ".tgl($data['waktu_selesai']),"".$no_spt."","".$data['tujuan']."",$data['kota'],st_petugas($data['id'])));
$no++;
}
$pdf->Output();
?>
