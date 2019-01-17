<?php
require('fpdf/mc_table.php');
include "../class/class.php";
$id=$_GET['id'];
$id_spt=$_GET['id_spt'];

$org="Balai Uji Terap Teknik dan Metode Karantina Pertanian";
$pdf=new PDF_MC_Table('P','mm','A4');
$pdf->SetMargins(25,25,20);
$pdf->AddPage();
$pdf->Image('garuda.jpg',97,5,20);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(0,5,'MENTERI KEUANGAN
REPUBLIK INDONESIA',0,'C');

if (app_baca("spt_petugas","id='$id'","no_spd")<=0) {$spdnya="    ";} else {
	$spdnya=app_baca("spt_petugas","id='$id'","no_spd").app_baca("spt_petugas","id='$id'","no_spd_alp");
}
$pdf->SetFont('Arial','',11);
$pdf->SetWidths(array(82,82));
$pdf->SetBorderColor(array(0,0)); 
$pdf->SetFontStyle(array("",""));
$pdf->SetAligns(array('L','L'));
$pdf->Row(array("","I. Berangkat dari : ".app_baca("spt","id='$id_spt'","dari")."
   (Tempat Kedudukan)	
   Ke                     : ".app_baca("spt","id='$id_spt'","kota")."
   Pada Tanggal	  : ".tgl_p(app_baca("spt","id='$id_spt'","waktu_mulai"))."
                              ".app_baca("spt","id='$id_spt'","kep_jab")."\n\n\n
                      ".db_baca(real_db(),"karyawan","id='".app_baca("spt","id='$id_spt'","kep_nama")."'","nama")."
                 NIP. ".db_baca(real_db(),"karyawan","id='".app_baca("spt","id='$id_spt'","kep_nama")."'","nip").""));

$pdf->Row(array("II. Tiba di            : ".app_baca("spt","id='$id_spt'","kota")."
    Pada Tanggal : ".tgl_p(app_baca("spt","id='$id_spt'","waktu_mulai"))."
    Kepala  :\n\n\n\n\n","   Berangkat dari : ".app_baca("spt","id='$id_spt'","kota")."
   Ke                    : ".app_baca("spt","id='$id_spt'","dari")."
   Pada Tanggal  : ".tgl_p(app_baca("spt","id='$id_spt'","waktu_selesai")).""));

$pdf->Row(array("III. Tiba di            : 
    Pada Tanggal :
    Kepala  :\n\n\n\n\n","   Berangkat dari : 
   Ke                    : 
   Pada Tanggal  : "));
$pdf->Row(array("IV. Tiba di            : 
    Pada Tanggal :
    Kepala  :\n\n\n\n\n","   Berangkat dari : 
   Ke                    : 
   Pada Tanggal  : "));

$ppkn=db_baca(real_db(),"karyawan","id='".app_baca("spt","id='$id_spt'","ppk_nama")."'","nama");
$ppknip=db_baca(real_db(),"karyawan","id='".app_baca("spt","id='$id_spt'","ppk_nama")."'","nip");
$pdf->SetAligns(array('L','J'));
$pdf->Row(array("V. Tiba di            : ".app_baca("spt","id='$id_spt'","dari")."
    (Tempat Kedudukan)	
    Pada Tanggal : ".tgl_p(tgl_aju(app_baca("spt","id='$id_spt'","waktu_selesai")))."\n
              Pejabat Pembuat Komitmen
\n\n
                   ".$ppkn."
            NIP. ".$ppknip."","Telah diperiksa dengan keterangan bahwa perjalanan tersebut atas perintahnya dan semata-mata untuk kepentingan jabatan dalam waktu yang sesingkat- singkatnya.
              Pejabat Pembuat Komitmen
\n\n
                   ".$ppkn."
            NIP. ".$ppknip."
"));
$pdf->SetFont('Arial','',9);
$pdf->SetWidths(array(164));
$pdf->SetBorderColor(array(0)); 
$pdf->SetFontStyle(array(""));
$pdf->SetAligns(array('J'));
$pdf->Row(array("VI. Catatan Lain-Lain"));
$pdf->Row(array("VII. PERHATIAN :
PPK yang menerbitkan SPD, pegawai yang melakukan perjalanan dinas, para pejabat yang mengesahkan tanggal berangkat/tiba, serta bendahara pengeluaran bertanggung jawab berdasarkan peraturan- peraturan Keuangan Negara apabila negara menderita rugi akibat kesalahan, kelalaian, dan kealpaannya."));

$unik=app_baca("spt","id='$id_spt'","unik");
$code="B-office *".$unik."*";
$pdf->SetDrawColor(111, 111, 111);
$pdf->Line(0,273,210,273);
$pdf->Code128(130,275,$code,60,8);
$pdf->SetFont('Arial','',6);
$pdf->Text(140,286,$code);

$pdf->Output();
?>
