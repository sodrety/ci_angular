<?php
require('fpdf/mc_table.php');
include "../class/class.php";
$pdf=new PDF_MC_Table('P','mm','A4');
$pdf->SetMargins(20,65,20);
$pdf->AddPage();
$pdf->Image('distribusi_kop.png',10,10,190);
$id=$_GET['id'];
$db = new database();
$uji = new uji();
$db->connect(app_db());
$query = "SELECT * from uji where id='$id' limit 0,1";
$results = $db->get_results( $query );
foreach( $results as $data )
{

$pdf->SetFont('Arial','BU',12);
$pdf->Cell(0,4,'DISTRIBUSI CONTOH UJI',0,1,'C');
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,4,"NO SERI: ".$data['kode']."/LabKT/".bln_thn_no($data['distribusi_tgl']),0,1,'C');
$pdf->Cell(0,4,"",0,1,'C');
$pdf->SetWidths(array(50,5,115));
$pdf->Row(array("Jenis Contoh Uji",":",$data['komoditi']));
$pdf->Row(array("Kondisi Contoh Uji",":",$data['distribusi_kondisi']));
$pdf->Row(array("Jumlah Contoh Uji",":",app_jml("uji_lot","id_uji='".$data['id']."'","id")." lot/sampel"));
$pdf->Row(array("Tanggal Terima Contoh Uji",":",$data['terima_tgl']));
$query0 = "SELECT * from uji_target join m_optk ON uji_target.id_target=m_optk.id where id_uji='".$id."' order by jenis,nama_latin";
$results0 = $db->get_results( $query0 );

foreach( $results0 as $data0 )
{
$n0+=1;
if ($n0==1) {$an="Analis Pengujji";$bn=":";} else {$an="";$bn="";}
$pdf->Row(array($an,$bn,$n0.". ".db_baca("user_login","karyawan","id='".$data0['penguji']."'","nama")));	
}

$pdf->Row(array("Jenis Pengujian",":","

"));

$pdf->SetWidths(array(10,80,40,40));
$pdf->SetAligns(array("C","C","C","C"));
$pdf->SetBorderColor("#000000","#000000","#000000","#000000");
$pdf->SetFont('Arial','B',11);
$pdf->Row(array("No","Target OPTK/HPH(K)","Metode Pengujian yang Digunakan","Keterangan"));
$pdf->SetFont('Arial','',11);
$pdf->SetAligns(array("C","L","C","L"));
foreach( $results0 as $data0 )
{
$n1+=1;
$pdf->Row(array($n1,$data0['nama_latin'],app_baca("m_metode","id='".$data0['id_metode']."'","metode"),$data0['ket']));	
}
$pdf->Cell(0,3,'',0,1,'C');
$pdf->SetWidths(array(110,60));
$pdf->SetBorderColor("","","");
$pdf->Row(array("
","",""));
$pdf->Row(array("","Dibuat Oleh,



"));
$pdf->SetFont('Arial','U',11);
$pdf->Row(array("",db_baca("user_login","karyawan","id='".$data['distribusi_oleh']."'","nama").""));
$pdf->SetFont('Arial','',11);
$pdf->Row(array("","Administrasi/Penyelia Lab"));

$pdf->SetDrawColor(111, 111, 111);
$pdf->Line(0,260,210,260);
$pdf->Code128(145,263,$data['kode'],40,20);
$pdf->SetFont('Arial','',12);
$pdf->Text(150,288,$data['kode']);
}


$pdf->Output();
?>
