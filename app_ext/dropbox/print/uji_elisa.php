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
$db = new database();
$uji = new uji();
$db->connect(app_db());
$query = "SELECT * from uji JOIN uji_target ON uji.id=uji_target.id_uji where idt='$idt' limit 0,1";
$results = $db->get_results( $query );
foreach( $results as $data )
{

$jenis=app_baca("m_optk", "id='".$data['id_target']."'", "jenis");
if ($jenis=="Bakteri") {$d="h";} else {$d="d"; }
$pdf->Cell(0,4,'FM. 49'.$d.'/T.04/Rev.00',0,1,'R');
$pdf->Cell(0,4,'',0,1,'R');
$pdf->SetFont('Arial','BU',12);
$pdf->Cell(0,4,'HASIL PEMERIKSAAN '.strtoupper($jenis),0,1,'C');
$pdf->SetFont('Arial','',11);

$pdf->Cell(0,4,"",0,1,'C');
$pdf->SetWidths(array(55,5,110));
$pdf->Row(array("No. Contoh Uji",":",$data['kode']));
$pdf->Row(array("No. Distribusi  Contoh Uji",":",$data['target_kode']));
$pdf->Row(array("Media Pembawa ",":",$data['komoditi']));
$optk=app_baca("uji_target JOIN m_optk ON uji_target.id_target=m_optk.id","idt='".$idt."'","nama_latin");
$pdf->Row(array("Target Pest",":",$optk));
$pdf->Row(array("Metode Pengujian",":","DAS-Elisa"));
$pdf->Row(array("Tanggal Penerimaan di Lab. ",":",tgl($data['terima_tgl'])));

$s=app_baca("uji_hasil", "id LIKE '".$idt."%' order by selesai_tgl desc", "selesai_tgl");
$pdf->Row(array("Tanggal Pengujian",":",tgl($data['distribusi_tgl'])." - ".tgl($s)));
$pdf->Cell(0,4,'',0,1,'C');
$pdf->SetFont('Arial','',10);
$pdf->SetWidths(array(20,30,12,30,12,30,12,30));
$query1 = "SELECT * from uji_elisa WHERE idt='".$idt."'";
$results1 = $db->get_results( $query1 );
foreach( $results1 as $data1 )
{ }

$pdf->Row(array("Antibodi",":".$data1['antibodi_v'],"Kons",":".$data1['antibodi_k'],"Waktu",":".$data1['antibodi_w'],"Temp",":".$data1['antibodi_t']));
$pdf->Row(array("Antigen",":".$data1['antigen_v'],"Kons",":".$data1['antigen_k'],"Waktu",":".$data1['antigen_w'],"Temp",":".$data1['antigen_t']));
$pdf->Row(array("Blocking",":".$data1['blocking_v'],"Kons",":".$data1['blocking_k'],"Waktu",":".$data1['blocking_w'],"Temp",":".$data1['blocking_t']));
$pdf->Row(array("Probe antibodi",":".$data1['probe_v'],"Kons",":".$data1['probe_k'],"Waktu",":".$data1['probe_w'],"Temp",":".$data1['probe_t']));
$pdf->Row(array("Conjugate",":".$data1['conjugate_v'],"Kons",":".$data1['conjugate_k'],"Waktu",":".$data1['conjugate_w'],"Temp",":".$data1['conjugate_t']));
$pdf->Row(array("Substrat",":".$data1['substrat_v'],"Kons",":".$data1['substrat_k'],"Waktu",":".$data1['substrat_w'],"Temp",":".$data1['substrat_t']));
$pdf->Cell(0,4,'',0,1,'C');
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,4,'Data Hasil Pengujian ',0,1,'C');


$pdf->SetFont('Arial','',10);
$pdf->SetWidths(array(30,15,15,20,20,20,20,30));
$pdf->SetAligns(array("C","C","C","C","C","C","C"));
$pdf->SetBorderColor(array("#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000"));
$pdf->Row(array("Sampel","Nilai Absorbansi 1","Nilai Absorbansi 2","Rata-rata","Perubahan Warna 1","Perubahan Warna 2","Kesimpulan Hasil","Keterangan"));
$pdf->SetAligns(array("C","J","C","C","C","C","C","C"));

$pdf->Row(array("Kontrol +",$data1['kontrol_p_abs_1'],$data1['kontrol_p_abs_2'],des4(($data1['kontrol_p_abs_1']+$data1['kontrol_p_abs_2'])/2),$data1['kontrol_p_warna_1'],$data1['kontrol_p_warna_2'],$data1['kontrol_p_kesimpulan'],""));
$pdf->Row(array("Kontrol -",$data1['kontrol_n_abs_1'],$data1['kontrol_n_abs_2'],des4(($data1['kontrol_n_abs_1']+$data1['kontrol_n_abs_2'])/2),$data1['kontrol_n_warna_1'],$data1['kontrol_n_warna_2'],$data1['kontrol_n_kesimpulan'],""));
$pdf->Row(array("Buffer",$data1['kontrol_b_abs_1'],$data1['kontrol_b_abs_2'],des4(($data1['kontrol_b_abs_1']+$data1['kontrol_b_abs_2'])/2),$data1['kontrol_b_warna_1'],$data1['kontrol_b_warna_2'],$data1['kontrol_b_kesimpulan'],""));

$query0 = "SELECT * from uji_lot where id_uji='".$id."' order by no";
$results0 = $db->get_results( $query0 );


foreach( $results0 as $data0 )
{
$n1+=1;
$idh=$idt."_".$data0['lot_kode'];
$abs1=app_baca("uji_hasil","id='".$idh."'","abs_1");
$abs2=app_baca("uji_hasil","id='".$idh."'","abs_2");

$pdf->Row(array($data0['lot_kode'],$abs1,$abs2,des4(($abs1+$abs2)/2),app_baca("uji_hasil","id='".$idh."'","warna_1"),app_baca("uji_hasil","id='".$idh."'","warna_2"),app_baca("uji_hasil","id='".$idh."'","hasil"),""));

	
}

$pdf->SetFont('Arial','',8);
$pdf->Cell(0,3,'Keterangan :',0,1,'L');
$pdf->Cell(0,3,'+ Tidak terjadi perubahan warna',0,1,'L');
$pdf->Cell(0,3,'+ Terjadi perubahan warna',0,1,'L');
$pdf->MultiCell(0,3,'Sampel dinyatakan positif bila nilai absorbansi rata-rata lebih besar dari 
dua kali nilai  absorbansi rata-rata kontrol negatif',0,'L');
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
$pdf->Line(0,260,210,260);
$pdf->Code128(145,263,$data['target_kode'],40,20);
$pdf->SetFont('Arial','',12);
$pdf->Text(150,288,$data['target_kode']);
}


$pdf->Output();
?>
