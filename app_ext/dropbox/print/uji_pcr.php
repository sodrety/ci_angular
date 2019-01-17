<?php
require('fpdf/mc_table.php');
include "../class/class.php";

$pdf=new PDF_MC_Table('P','mm',array(210,330));
$pdf->SetMargins(20,20,20);
$pdf->AddPage();
$pdf->Image("uji_kop.png",10,10,190);
$pdf->SetFont('Arial','B',12);
$pdf->Ln(37);
$id=$_GET['id'];
$idt=$_GET['idt'];
$db = new database();
$uji = new uji();
$db->connect(app_db());
$query = "SELECT * from uji JOIN uji_target ON uji.id=uji_target.id_uji where idt='$idt' limit 0,1";
$results = $db->get_results( $query );
foreach( $results as $data )
{

$jenis=app_baca("m_optk", "id='".$data['id_target']."'", "jenis");

$pdf->Cell(0,4,'FM. 49i/T.04/Rev.00',0,1,'R');
$pdf->Cell(0,4,'',0,1,'R');
$pdf->SetFont('Arial','BU',12);
$pdf->Cell(0,4,'LAPORAN HASIL PENGUJIAN LABORATORIUM',0,1,'C');
$pdf->SetFont('Arial','',11);

$pdf->Cell(0,4,"",0,1,'C');
$pdf->SetWidths(array(55,5,110));
$pdf->Row(array("No. Contoh Uji",":",$data['kode']));
$pdf->Row(array("No. Distribusi  Contoh Uji",":",$data['target_kode']));
$pdf->Row(array("Media Pembawa ",":",$data['komoditi']));
$optk=app_baca("uji_target JOIN m_optk ON uji_target.id_target=m_optk.id","idt='".$idt."'","nama_latin");
$pdf->Row(array("Target Pest",":",$optk));
$pdf->Row(array("Metode Pengujian",":","PCR"));
$pdf->Row(array("Tanggal Penerimaan di Lab. ",":",tgl($data['terima_tgl'])));
$s=app_baca("uji_hasil", "id LIKE '".$idt."%' order by selesai_tgl desc", "selesai_tgl");
$pdf->Row(array("Tanggal Pengujian",":",tgl($data['distribusi_tgl'])." - ".tgl($s)));
$pdf->Cell(0,4,'',0,1,'C');
$pdf->SetFont('Arial','',10);
$pdf->SetWidths(array(6,45,3,116));
$pdf->SetAligns(array("C","L","L"));
$query1 = "SELECT * from uji_pcr where idt='".$idt."'";
$results1 = $db->get_results( $query1 );
foreach( $results1 as $data1 )
{
$pdf->Row(array("1.","Komposisi Mix PCR",":",$data1['mix']));
$pdf->Row(array("2.","Running produk PCR",":",$data1['produk']));
$pdf->Row(array("3.","Agarose",":",$data1['agar']));
$pdf->Row(array("4.","Elektroforesis",":",$data1['elektro']));
$pdf->Row(array("5.","Panjang Basa Primer  OPTK Target",":",$data1['panjang']));
}
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,4,'',0,1,'C');
$pdf->Cell(0,4,'FOTO HASIL ELEKTROFORESIS',0,1,'C');
$y=$pdf->GetY();
$img="pcr.png";

list($width, $height) = getimagesize($img);
$w=($width*(75/$height))/2;
$l=(105-$w);
$pdf->Image($img,$l,$y,0,75);
$pdf->Ln(80);
$pdf->Cell(0,4,'Kesimpulan : ',0,2,'L');
$pdf->SetFont('Arial','',10);

$query0 = "SELECT * from uji_lot where id_uji='".$id."' order by no";
$results0 = $db->get_results( $query0 );
foreach( $results0 as $data0 )
{
$idh=$idt."_".$data0['lot_kode'];
$has.="Lot ".$data0['lot_kode']." : ".app_baca("uji_hasil","id='".$idh."'","hasil")."; ";

}
$pdf->MultiCell(0,4,'Sampel '.$data['komoditi'].' No. '.$data['kode'].' dari Hasil sequencing dan blast di ncbi - Google http://blast.ncbi.nlm.nih.gov '.$has.' terhadap '.$jenis.' '.$optk.'',0,'J');

$pdf->SetFont('Arial','',11);
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
$pdf->Line(0,307,210,307);
$pdf->Code128(145,308,$data['target_kode'],40,10);
$pdf->SetFont('Arial','',12);
$pdf->Text(150,323,$data['target_kode']);
}


$pdf->Output();
?>
