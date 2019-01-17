<?php
require('fpdf/mc_table.php');
include "../class/class.php";

function hasil_print($idt) {
$db = new database();
$db->connect(app_db());
$query1 = "SELECT * from uji_hasil where id LIKE '".$idt."%' order by id";
$results1 = $db->get_results( $query1 );
foreach( $results1 as $data1 )
{
if ($data1['hasil']=="Positif") {$p++;
$hasil.="Lot ".substr($data1['id'],-2).": ".$data1['hasil']." 
"; } else {$n++;}
}
if ($p<=0 and $n<=0) {$hasil="Tidak diketahui";} elseif ($p<=0) {$hasil="Negatif";}
return $hasil;
}




$pdf=new PDF_MC_Table('P','mm','A4');
$pdf->SetMargins(20,65,20);
$pdf->AddPage();

$id=$_GET['id'];
$db = new database();
$uji = new uji();
$db->connect(app_db());
$query = "SELECT * from uji where id='$id' limit 0,1";
$results = $db->get_results( $query );
foreach( $results as $data )
{
if ($data['iso']=="ISO") {$iso="_iso";} else {$iso="";}
$pdf->Image("hasil_kop".$iso.".png",10,10,190);
$pdf->SetFont('Arial','BU',12);
$pdf->Cell(0,4,'LAPORAN HASIL PENGUJIAN LABORATORIUM',0,1,'C');
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,4,"NO SERI: ".$data['kode']."/LH/LabKT/".bln_thn_no($data['hasil_tgl']),0,1,'C');
$pdf->Cell(0,4,"",0,1,'C');
$pdf->SetWidths(array(50,5,115));

$pdf->Row(array("JENIS MEDIA PEMBAWA",":",$data['komoditi']));
$pdf->Row(array("NO. SURAT TUGAS",":",$data['kode']."/ST/LabKT/".bln_thn_no($data['hasil_tgl'])));
$pdf->Row(array("NEGARA ASAL/TRANSIT",":",$data['asal']));
$pdf->Row(array("NAMA DAN ALAMAT PEMILIK",":",$data['kirim_jab'].", ".$data['alamat']));
$pdf->Row(array("JUMLAH CONTOH UJI",":",app_jml("uji_lot","id_uji='".$data['id']."'","id")." lot/sampel"));
$pdf->Row(array("NO. CONTOH UJI",":",$data['kode']));
$pdf->Row(array("TANGGAL TERIMA CONTOH UJI",":",tgl($data['terima_tgl'])));
$s=app_baca("uji_hasil", "id_uji='".$data['id']."' order by selesai_tgl desc", "selesai_tgl");
$pdf->Row(array("TANGGAL PENGUJIAN",":",tgl($data['distribusi_tgl'])." - ".tgl($s)));
$pdf->Row(array("HASIL PENGUJIAN",":",""));

$query0 = "SELECT * from uji_target join m_optk ON uji_target.id_target=m_optk.id where id_uji='".$id."' order by jenis,nama_latin";
$results0 = $db->get_results( $query0 );

$pdf->SetFont('Arial','',10);
$pdf->SetWidths(array(10,50,30,32,28,20));
$pdf->SetAligns(array("C","C","C","C","C","C"));
$pdf->SetBorderColor("#000000","#000000","#000000","#000000","#000000","#000000");

$pdf->Row(array("NO","TARGET OPTK / 
HAMA PENYAKIT/ IDENTIFIKASI","METODE","LABORATORIUM PENGUJI","HASIL UJI","SATUAN"));

$pdf->SetAligns(array("C","L","C","C","C","C"));
foreach( $results0 as $data0 )
{
$n1+=1;



$pdf->Row(array($n1,$data0['nama_latin'],app_baca("m_metode","id='".$data0['id_metode']."'","metode"),"KARANTINA TUMBUHAN",hasil_print($data0['idt']),""));	
}
$pdf->SetWidths(array(170));
$pdf->SetAligns(array("L"));
$pdf->Row(array("Catatan:"));	

$pdf->Cell(0,3,'',0,1,'C');
$pdf->SetWidths(array(10,100,60));
$pdf->SetAligns(array("L","L","L"));
$pdf->SetBorderColor("","","","");
$pdf->Row(array("","
Mengetahui,
Manajer Teknis","Jakarta, ".tgl($data['hasil_tgl'])."
Penyelia Laboratorium,



"));
$pdf->SetFont('Arial','U',11);
$pdf->Row(array("",db_baca("user_login","karyawan","id='".$data['mt']."'","nama"),db_baca("user_login","karyawan","id='".$data['hasil_oleh']."'","nama")));

$pdf->SetDrawColor(111, 111, 111);
$pdf->Line(0,260,210,260);
$pdf->Code128(145,263,$data['kode'],40,20);
$pdf->SetFont('Arial','',12);
$pdf->Text(150,288,$data['kode']);
}


$pdf->Output();
?>
