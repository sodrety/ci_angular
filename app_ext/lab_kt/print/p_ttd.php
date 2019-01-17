<?php
require('fpdf/mc_table.php');
include "../class/class.php";
$id=$_GET['id'];
$id_spt=$_GET['id_spt'];

$org="Balai Uji Terap Teknik dan Metode Karantina Pertanian";
$pdf=new PDF_MC_Table('P','mm','A4');
$pdf->SetMargins(0,0,0);
$pdf->AddPage();
$pdf->SetFont('Arial','',11);
$pdf->SetXY(47,71);
$pdf->MultiCell(0,5,"".db_baca(ofc_db(),"spt_spd_ttd","id_spt='$id_spt' and baris='1'","jabatan")."",0,"L");
$pdf->SetXY(30,88);
$pdf->MultiCell(70,5,"".db_baca(ofc_db(),"spt_spd_ttd","id_spt='$id_spt' and baris='1'","nama")."
".db_baca(ofc_db(),"spt_spd_ttd","id_spt='$id_spt' and baris='1'","nip")."",0,"C");
$pdf->SetXY(110,88);
$pdf->MultiCell(80,5,"".db_baca(ofc_db(),"spt_spd_ttd","id_spt='$id_spt' and baris='1'","nama")."
".db_baca(ofc_db(),"spt_spd_ttd","id_spt='$id_spt' and baris='1'","nip")."",0,"C");
$pdf->Output();
?>
