<?php
require('fpdf/mc_table.php');
include "../class/class.php";

$pdf=new PDF_MC_Table('P','mm','A4');
$pdf->SetMargins(20,57,20);
$pdf->AddPage();
$pdf->Image("uji_kop.png",10,10,190);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,4,'FM. 49c/T.04/Rev.00',0,1,'R');
$pdf->Cell(0,4,'',0,1,'R');
$id=$_GET['id'];
$idt=$_GET['idt'];
$db = new database();
$uji = new uji();
$db->connect(app_db());
$query = "SELECT * from uji JOIN uji_target ON uji.id=uji_target.id_uji where idt='$idt' limit 0,1";
$results = $db->get_results( $query );
foreach( $results as $data )
{
$pdf->SetFont('Arial','BU',12);

$pdf->Cell(0,4,'LAMPIRAN HASIL PEMERIKSAAN CENDAWAN',0,1,'C');
$pdf->Cell(0,4,'METODE BLOTTER TEST',0,1,'C');
$pdf->SetFont('Arial','',11);

$pdf->Cell(0,4,"",0,1,'C');
$pdf->SetWidths(array(55,5,110));
$pdf->Row(array("No. Contoh Uji",":",$data['kode']));
$pdf->Row(array("No. Distribusi  Contoh Uji",":",$data['target_kode']));
$pdf->Row(array("Media Pembawa ",":",$data['komoditi']));
$optk=app_baca("uji_target JOIN m_optk ON uji_target.id_target=m_optk.id","idt='".$idt."'","nama_latin");
$pdf->Row(array("Target Pest",":",$optk));
$pdf->Row(array("Metode Pengujian",":","Blotter Test"));
$pdf->Row(array("Tanggal Penerimaan di Lab. ",":",tgl($data['terima_tgl'])));

$s=app_baca("uji_hasil", "id LIKE '".$idt."%' order by selesai_tgl desc", "selesai_tgl");
$pdf->Row(array("Tanggal Pengujian",":",tgl($data['distribusi_tgl'])." - ".tgl($s)));
$pdf->Cell(0,4,'',0,1,'C');
$pdf->Cell(0,4,'DATA HASIL PEMERIKSAAN',0,1,'C');
$query0 = "SELECT * from uji_lot where id_uji='".$id."' order by no";
$results0 = $db->get_results( $query0 );

$pdf->SetFont('Arial','',10);
$pdf->SetWidths(array(10,120,40));
$pdf->SetAligns(array("C","C","C","C","C","C"));
$pdf->SetBorderColor("#000000","#000000","#000000");

$pdf->Row(array("No","Jenis cendawan yang ditemukan","Keterangan"));

$pdf->SetAligns(array("C","J","C"));
foreach( $results0 as $data0 )
{
$n1+=1;
$idh=$idt."_".$data0['lot_kode'];
$pdf->Row(array($n1,"Lot ".substr($data0['lot_kode'],-2).":
".$uji->uji_temuan_print($idh),app_baca("uji_hasil","id='".$idh."'","hasil")));	
}


$pdf->Cell(0,3,'',0,1,'C');
$pdf->SetWidths(array(10,100,60));
$pdf->SetBorderColor("","","","");
$pdf->SetAligns(array("L","L","L"));
$pdf->Row(array("","
Mengetahui,
Penyelia,","Jakarta, ".tgl_p($s)."
Analis,



"));
$pdf->SetFont('Arial','U',11);
$pdf->Row(array("",db_baca("user_login","karyawan","id='".$data['penyelia']."'","nama"),db_baca("user_login","karyawan","id='".$data['penguji']."'","nama")));

$pdf->SetDrawColor(111, 111, 111);
$pdf->Line(0,260,210,260);
$pdf->Code128(145,263,$data['target_kode'],40,20);
$pdf->SetFont('Arial','',12);
$pdf->Text(150,288,$data['target_kode']);
}


$pdf->Output();
?>
