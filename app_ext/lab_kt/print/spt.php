<?php
require('fpdf/mc_table.php');
include "../class/class.php";
$id=$_GET['id'];
$id_spt=$_GET['id_spt'];

$org="Balai Uji Terap Teknik dan Metode Karantina Pertanian";
$pdf=new PDF_MC_Table('P','mm','A4');
$pdf->SetMargins(25,30,20);
$pdf->AddPage();
$pdf->Image('garuda.jpg',97,10,20);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(0,4,'MENTERI KEUANGAN
REPUBLIK INDONESIA',0,'C');

if (app_baca("spt_petugas","id='$id'","no_spd")<=0) {$spdnya="    ";} else {
	$spdnya=app_baca("spt_petugas","id='$id'","no_spd").app_baca("spt_petugas","id='$id'","no_spd_alp");
}
$pdf->SetFont('Arial','',10);
$pdf->SetXY(25,40);
$pdf->MultiCell(110,3,'Kementerian Negara/Lembaga:
Kementerian Pertanian
Badan Karantina Pertanian
Balai Uji Terap Teknik dan Metode Karantina Pertanian',0,'L');

$pdf->SetFont('Arial','',11);
$pdf->SetXY(135,40);
$pdf->MultiCell(70,4,"Lembar Ke : 1
Kode No     : 
Nomor        : ".$spdnya."/".str_replace(" "," ",app_baca("spt_petugas","id='$id'","spd"))."".substr (tgl(app_baca("spt","id='$id_spt'","tgl")), 3, 7)."",0,"L");
$pdf->Cell(0,5,"",0,1,"C");
$mak=app_baca("spt","id='$id_spt'","mak");
$tahun=app_baca("spt","id='$id_spt'","tahun");
if ($tahun>="2018") {$mak=db_baca(real_db()."_".$tahun,"pok","no='".$mak."'","mak");}
$ppkn=db_baca(real_db(),"karyawan","id='".app_baca("spt","id='$id_spt'","ppk_nama")."'","nama");
$ppknip=db_baca(real_db(),"karyawan","id='".app_baca("spt","id='$id_spt'","ppk_nama")."'","nip");

$tgl=app_baca("spt","id='$id_spt'","tgl");

$lama=lama(app_baca("spt","id='$id_spt'","waktu_mulai"),app_baca("spt","id='$id_spt'","waktu_selesai"));

$pdf->SetFont('Arial','',11);
$pdf->SetWidths(array(8,64,92));
$pdf->SetBorderColor(array(0,0,0)); 
$pdf->SetFontStyle(array("","",""));
$pdf->SetAligns(array('C','L','L'));
$pdf->Row(array("1","Pejabat Pembuat Komitmen ","Balai Uji Terap Teknik dan Metode Karantina Pertanian"));
$pdf->Row(array("2","Nama/NIP Pegawai yang melaksanakan perjalanan dinas","".app_baca("spt_petugas","id='$id'","nama")." / ".app_baca("spt_petugas","id='$id'","nip").""));
$pdf->Row(array("3","a. Pangkat dan Golongan\nb. Jabatan/Instansi\n\nc. Tingkat Biaya Perjalanan Dinas ","".pangkat(app_baca("spt_petugas","id='$id'","gol"))." (".app_baca("spt_petugas","id='$id'","gol").")\nBalai Uji Terap Teknik dan Metode Karantina Pertanian"));
$pdf->Row(array("4","Maksud Perjalanan Dinas ","".app_baca("spt","id='$id_spt'","tujuan")."
Berdasarkan Surat Tugas\nNo ".$no_spt=app_baca("spt","id='$id'","no_spt")."/".app_baca("spt_global","name='nomor'","value")."/".substr($tgl,5,2)."/".substr($tgl,0,4)." Tanggal ".tgl_p(app_baca("spt","id='$id_spt'","tgl")).""));
$pdf->Row(array("5","Alat angkutan yang dipergunakan","".app_baca("spt","id='$id_spt'","angkutan").""));
$pdf->Row(array("6","a. Tempat berangkat\nb. Tempat Tujuan","".app_baca("spt","id='$id_spt'","dari")."\n".app_baca("spt","id='$id_spt'","lokasi").", ".app_baca("spt","id='$id_spt'","kota").""));
$pdf->Row(array("7","a. Lamanya Perjalanan Dinas\nb. Tanggal berangkat\nc. Tanggal harus kembali/tiba di tempat baru *)","$lama (".terbilang($lama).") hari\n".tgl_p(app_baca("spt","id='$id_spt'","waktu_mulai"))."\n".tgl_p(app_baca("spt","id='$id_spt'","waktu_selesai")).""));

$pdf->SetWidths(array(8,64,46,46));
$pdf->SetBorderColor(array(0,0,0,0)); 
$pdf->Row(array("8","Pengikut : Nama\n1.\n2.\n3.","Tanggal Lahir","Keterangan"));

$pdf->SetWidths(array(8,64,92));
$pdf->Row(array("9","Pembebanan Anggaran\na. Instansi\n\nb. Akun","\nBalai Uji Terap Teknik dan Metode Karantina Pertanian\n"
.$mak.""));
$pdf->Row(array("10","Keterangan lain-lain ",""));
$pdf->Cell(0,5,"",0,1,"C");
$pdf->SetWidths(array(104,60));
$pdf->SetBorderColor(array(255,255)); 
$pdf->SetFontStyle(array("",""));
$pdf->SetAligns(array('L','L'));
$pdf->Row(array("","Dikeluarkan di Bekasi,\nTanggal ".tgl_p(app_baca("spt","id='$id_spt'","tgl"))."\nPejabat Pembuat Komitmen\n\n\n\n".$ppkn."\nNIP. ".$ppknip.""));

$unik=app_baca("spt","id='$id_spt'","unik");
$code="B-office *".$unik."*";
$pdf->SetDrawColor(111, 111, 111);
$pdf->Line(0,273,210,273);
$pdf->Code128(130,275,$code,60,8);
$pdf->SetFont('Arial','',6);
$pdf->Text(140,286,$code);

$pdf->Output();
?>
