<?php
require('fpdf/mc_table.php');
include "../class/class.php";

$pdf=new PDF_MC_Table('P','mm','A4');
$pdf->SetMargins(20,57,20);
$pdf->AddPage();
$pdf->Image("uji_kop.png",10,10,190);
$pdf->SetFont('Arial','B',12);

$id=$_GET['id'];
$idt=$_GET['idt'];
$jenis=app_baca("uji JOIN uji_target ON uji.id=uji_target.id_uji JOIN m_optk ON m_optk.id=uji_target.id_target","idt='".$idt."'","jenis");
$db = new database();
$uji = new uji();
$db->connect(app_db());
$query = "SELECT * from uji JOIN uji_target ON uji.id=uji_target.id_uji JOIN m_optk ON m_optk.id=uji_target.id_target where uji.id='$id'  AND m_optk.jenis='".$jenis."' ";
$results = $db->get_results( $query );
$no=0;
foreach( $results as $data )
{
$no++;
$optk.=$no.". ".$data['nama_latin']."\n";
}
$jenis=app_baca("m_optk", "id='".$data['id_target']."'", "jenis");
if ($jenis=="Tungau") {$d="e";} else {$d="d"; }
$pdf->Cell(0,4,'FM. 49'.$d.'/T.04/Rev.00',0,1,'R');
$pdf->Cell(0,4,'',0,1,'R');
$pdf->SetFont('Arial','BU',12);
$pdf->Cell(0,4,'HASIL PEMERIKSAAN '.strtoupper($jenis),0,1,'C');
$pdf->Cell(0,4,'METODE MIKROSKOPIS',0,1,'C');
$pdf->SetFont('Arial','',11);

$pdf->Cell(0,4,"",0,1,'C');
$pdf->SetWidths(array(55,5,110));
$pdf->Row(array("No. Contoh Uji",":",$data['kode']));
$pdf->Row(array("No. Distribusi  Contoh Uji",":",$data['target_kode']));
$pdf->Row(array("Media Pembawa ",":",$data['komoditi']));
$pdf->Row(array("Target Pest",":",$optk));
$pdf->Row(array("Metode Pengujian",":","Mikroskopis"));
$pdf->Row(array("Tanggal Penerimaan di Lab. ",":",tgl($data['terima_tgl'])));

$s=app_baca("uji_hasil", "id LIKE '".$idt."%' order by selesai_tgl desc", "selesai_tgl");
$pdf->Row(array("Tanggal Pengujian",":",tgl($data['distribusi_tgl'])." - ".tgl($s)));
$pdf->Cell(0,4,'',0,1,'C');
$pdf->Cell(0,4,'DATA HASIL PEMERIKSAAN',0,1,'C');

$pdf->SetFont('Arial','',10);
$pdf->SetAligns(array("C","C","C","C","C","C","C"));
$pdf->SetBorderColor("#000000","#000000","#000000");
if ($jenis=="Tungau") {
$pdf->SetWidths(array(10,75,15,15,15,40));
$pdf->Row(array("No","Jenis ".$jenis." yang ditemukan 
(Ordo/Genus/Spesies)","Stadia Telur","Stadia Nimpa","Stadia Imago","Keterangan")); } else {
$pdf->SetWidths(array(10,60,15,15,15,15,40));
$pdf->Row(array("No","Jenis ".$jenis." yang ditemukan 
(Ordo/Genus/Spesies)","Stadia Telur","Stadia Larva/Nimpa*","Stadia Pupa","Stadia Imago","Keterangan"));
}

$pdf->SetAligns(array("C","J","C","C","C","C","C"));

$query0 = "SELECT * from uji_lot where id_uji='".$id."' order by no";
$results0 = $db->get_results( $query0 );
foreach( $results0 as $data0 )
{
$n1+=1;
$no=0;
foreach( $results as $data )
{
$idh=$data['idt']."_".$data0['lot_kode'];
$hasil=app_baca("uji_hasil","id='".$idh."'","hasil");
$no++;
$has.="no ".$no." ".$hasil."; ";
}
if ($jenis=="Tungau") {
$pdf->Row(array($n1,"Lot ".substr($data0['lot_kode'],-2).":
","","","",$has));} else {
$pdf->Row(array($n1,"Lot ".substr($data0['lot_kode'],-2).":
","","","","",$has));
}

foreach( $results as $data )
{	
$idh=$data['idt']."_".$data0['lot_kode'];
$query1 = "SELECT * from uji_temuan join m_optk ON uji_temuan.temuan=m_optk.id where idh='".$idh."' order by nama_latin";
$results1 = $db->get_results( $query1 );
foreach( $results1 as $data1 )
{
if ($jenis=="Tungau") {
$pdf->Row(array("",$data1['nama_latin'],$data1['s1'],$data1['s2'],$data1['s4'],""));} else {

$pdf->Row(array("",$data1['nama_latin'],$data1['s1'],$data1['s2'],$data1['s3'],$data1['s4'],""));
}
}
}
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



$pdf->Output();
?>
