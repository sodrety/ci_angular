<?php
require('fpdf/mc_table.php');

$pdf=new PDF_MC_Table('P','mm','A4');
$pdf->AddPage();
$pdf->SetMargins(25,25,20);
$pdf->SetFont('Arial','',14);
$pdf->Cell(0,5,'KEMENTERIAN PERTANIAN',0,1,'C');
$pdf->SetFont('Arial','',13);
$pdf->Cell(0,5,'BADAN KARANTINA PERTANIAN PERTANIAN',0,1,'C');
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,5,'BALAI UJI TERAP TEKNIK DAN METODE KARANTINA PERTANIAN',0,1,'C');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,15,'LAPORAN HASIL PERJALANAN DINAS',0,1,'C');
$pdf->SetFont('Arial','',12);
$pdf->SetWidths(array(7,157));
$pdf->Row(array("A.","Pegawai yang melakukan perjalanan"));
$pdf->SetWidths(array(7,7,45,105));
$pdf->Row(array("","1.","Nama / NIP","Abdul Mubaraq Irfan, SP/ 198408112011011014"));
$pdf->Row(array("","","Pangkat / Golongan","Penata Muda Tk. 1/3B"));
$pdf->Row(array("","","Jabatan","Medik Veteriner Pertama"));
$pdf->Row(array("","2.","Nama / NIP","Abdul Mubaraq Irfan, SP/ 198408112011011014"));
$pdf->Row(array("","","Pangkat / Golongan","Penata Muda Tk. 1/3B"));
$pdf->Row(array("","","Jabatan","Medik Veteriner Pertama"));
$pdf->Row(array("","3.","Nama / NIP","Abdul Mubaraq Irfan, SP/ 198408112011011014"));
$pdf->Row(array("","","Pangkat / Golongan","Penata Muda Tk. 1/3B"));
$pdf->Row(array("","","Jabatan","Medik Veteriner Pertama"));
$pdf->SetWidths(array(7,52,105));
$pdf->Row(array("B.","Dasar Perjalanan (Nomor dan Tanggal Surat Tugas)","0 tanggal 08 April 2018"));
$pdf->Row(array("C.","Lama dan Tanggal Perjalanan", "1 (satu) hari, tanggal 08 April 2018"));
$pdf->Row(array("D.","Lokasi", "dgdgdgd, Kab. Garut"));
$pdf->Row(array("E.","Maksud dan Tujuan", "Maksud dan TujuanMaksud dan TujuanMaksud dan Tujuan"));
$pdf->SetWidths(array(7,157));
$pdf->Row(array("F.","Hasil Perjalanan Dinas:"));
$pdf->Row(array("","aghj jadsja sdjajkdh jkahdjhadjahjdh ajdhajhd kjahkjdhkahdkjahdjkhajkdh jkah djkahdjhajkdh jahkdjhajkdh jkadhkjahdjhajkdhkahdjkahdjajdhajk\naghj jadsja sdjajkdh jkahdjhadjahjdh ajdhajhd kjahkjdhkahdkjahdjkhajkdh jkah djkahdjhajkdh jahkdjhajkdh jkadhkjahdjhajkdhkahdjkahdjajdhajk\naghj jadsja sdjajkdh jkahdjhadjahjdh ajdhajhd kjahkjdhkahdkjahdjkhajkdh jkah djkahdjhajkdh jahkdjhajkdh jkadhkjahdjhajkdhkahdjkahdjajdhajk\naghj jadsja sdjajkdh jkahdjhadjahjdh ajdhajhd kjahkjdhkahdkjahdjkhajkdh jkah djkahdjhajkdh jahkdjhajkdh jkadhkjahdjhajkdhkahdjkahdjajdhajk\naghj jadsja sdjajkdh jkahdjhadjahjdh ajdhajhd kjahkjdhkahdkjahdjkhajkdh jkah djkahdjhajkdh jahkdjhajkdh jkadhkjahdjhajkdhkahdjkahdjajdhajk\naghj jadsja sdjajkdh jkahdjhadjahjdh ajdhajhd kjahkjdhkahdkjahdjkhajkdh jkah djkahdjhajkdh jahkdjhajkdh jkadhkjahdjhajkdhkahdjkah jkahdjhadjahjdh ajdhajhd kjahkjdhkahdkjahdjkhajkdh jkah djkahdjhajkdh jahkdjhajkdh jkadhkjahdjhajkdhkahdjkah jkahdjhadjahjdh ajdhajhd kjahkjdhkahdkjahdjkhajkdh jkah djkahdjhajkdh jahkdjhajkdh jkadhkjahdjhaj kdhkahdjkah jkahdjhadjahjdh ajdhajhd kjahkjdhkahdk jahdjkhajkdh jkah djkahdjhajkdh jahkdjhajkdh jkadhkjahdjha jkdhkahdjkah jkahdjhadjahjdh ajdhajhd kjahkjdhkahdk jahdjkhajkdh jkah djkahdjhajkdh jahkdjhajkdh jkadhkjahdjh ajkdhkahdjkah jkahdjhadjahjdh ajdhajhd kjahkjdhkah dkjahdjkhajkdh jkah djkahdjhajkdh jahkdjhajkdh jkadhkjahdj hajkdhkahdjkah jkahdjhadjahjdh ajdhajhd kjahkjdhkah dkjahdjkhajkdh jkah djkahdjhajkdh jahkdjhajkdh jkadhkjahdjha jkdhkahdjkah jkahdjhadjahjdh ajdhajhd kjahkjdhkah dkjahdjkhajkdh jkah djkahdjhajkdh jahkdjhajkdh jkadhkjah djhajkdhkahdjkah jkahdjhadjahjdh ajdhajhd kjahkjdhka hdkjahdjkhajkdh jkah djkahdjhajkdh jahkdjhajkdh jkadhkjahdjh ajkdhkahdjkah jkahdjhadjahjdh ajdhajhd kjahkjdhk ahdkjahdjkhajkdh jkah djkahdjhajkdh jahkdjhajkdh jkadhkjahdjha jkdhkahdjkah jkahdjhadjahjdh ajdhajhd kjahkjdhkahdkj ahdjkhajkdh jkah djkahdjhajkdh jahkdjhajkdh jkadhkjahdjhajkdh kahdjkahdjajdhajk\n"),"J");
$pdf->Cell(0,5,'',0,1,'');
$pdf->SetWidths(array(74,90));
$pdf->SetAligns(array('C','L'));
$pdf->SetBorderColor(255,255,255);
$pdf->Row(array("\nMengetahui,\nKepala\n\n\n\nDrh Mira Hartati, M.Si\nNIP. 196201041989022001","Bekasi, 12 April 2018\nYang melakukan perjalanan dinas\n
1.	Abdul Mubaraq Irfan, SP
    198408112011011014	          .......................\n
2.	Bambang Urip Suwitorahardjo
    198408112011011014	          .......................\n
3.	Retno Umiarsih, SP
    198408112011011014	          ......................."));

$pdf->Output();
?>