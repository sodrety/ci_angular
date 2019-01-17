<?php
require('fpdf/mc_table.php');
include "../class/class.php";
$id=$_GET['id'];

$org="Balai Uji Terap Teknik dan Metode Karantina Pertanian";
$pdf=new PDF_MC_Table('L','mm','A4');
$pdf->SetMargins(25,20,20);
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,5,'BUKTI KEHADIRAN PELAKSANAAN PERJALANAN DINAS JABATAN',0,1,'C');
$tgl=app_baca("spt","id='$id'","tgl");
$pdf->Cell(0,5,"NO SURAT TUGAS : ".app_baca("spt","id='$id'","no_spt")."/".app_baca("spt_global","name='nomor'","value")."/".substr($tgl,5,2)."/".substr($tgl,0,4)."",0,1,"C");
$pdf->Cell(0,5,'DALAM KOTA KURANG DARI 8 JAM',0,1,'C');
$pdf->SetFont('Arial','',11);
$pdf->SetWidths(array(25,5,135));

$pdf->Cell(0,5,'',0,1,'L');
$db = new database();
$db->connect("b_office");
$no=1;
$query = "SELECT * from spt_petugas where id_spt='$id' order by no";
$results = $db->get_results( $query );
$pdf->SetWidths(array(8,60,20,30,133));
$pdf->SetBorderColor(array(0,0,0,0,0));
$pdf->SetFontStyle(array("B","B","B","B","B"));
$pdf->SetAligns(array('C','C','C','C','C'));
$pdf->Row(array("NO","NAMA/NIP","HARI","TANGGAL","PEJABAT / PETUGAS YANG MENGESAHKAN"));
$pdf->SetFontStyle(array("","","",""));
$pdf->SetWidths(array(8,60,20,30,40,30,63));
$pdf->SetBorderColor(array(0,0,0,0,0,0,0,0));
$pdf->SetAligns(array('C','L','L','L','C','C','C'));
$pdf->Row(array("","","","","NAMA","JABATAN","TANDA TANGAN / STEMPEL"));
$tgl=app_baca("spt","id='$id'","waktu_selesai");
$hari=nama_hari_id($tgl);
$tglp=tgl_p($tgl);

foreach( $results as $data )
{
if ($no=="1") {$kep="Kepada:";} else {$kep="";}
$pdf->Row(array($no.".","".$data['nama']."\n".$data['nip']."","".$hari."","".$tglp."","","",""));
$no++;
}
$pdf->Cell(0,5,'',0,1,'R');
$pdf->Cell(0,5,'Bekasi, '.$tglp.'',0,1,'R');
$unik=app_baca("spt","id='$id'","unik");
$code="B-office *".$unik."*";
$pdf->SetDrawColor(111, 111, 111);
$pdf->Line(0,188,300,188);
$pdf->Code128(220,190,$unik,60,8);
$pdf->SetFont('Arial','',6);
$pdf->Text(230,201,$code);
$pdf->Output();
?>
