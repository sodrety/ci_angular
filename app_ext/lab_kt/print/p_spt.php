<?php
require('fpdf/mc_table.php');
include "../class/class.php";
$id=$_GET['id'];

function pukul($p){
if ($p!="") {
return " Pukul ".$p; }
}
$tgl=app_baca("spt","id='$id'","tgl");
$no_spt=app_baca("spt","id='$id'","no_spt")."/".app_baca("spt_global","name='nomor'","value")."/".substr($tgl,5,2)."/".substr($tgl,0,4);
$p1=app_baca("spt","id='$id'","p1");
$tujuan=app_baca("spt","id='$id'","tujuan");
$waktu_mulai=app_baca("spt","id='$id'","waktu_mulai");
$waktu_selesai=app_baca("spt","id='$id'","waktu_selesai");
$lokasi=app_baca("spt","id='$id'","lokasi");
$tahun=app_baca("spt","id='$id'","tahun");
$mak=app_baca("spt","id='$id'","mak");
if ($tahun>="2018") {$mak=db_baca("b_realisasi_".$tahun,"pok","no='".$mak."'","mak");}

$kep_jab=app_baca("spt","id='$id'","kep_jab");
$kep_nama=app_baca("spt","id='$id'","kep_nama");
$kep_nip=app_baca("spt","id='$id'","kep_nip");
$unik=app_baca("spt","id='$id'","unik");
$kota=app_baca("spt","id='$id'","kota");
$tembusan=app_baca("spt","id='$id'","tembusan");
$dip=app_baca("spt","id='$id'","dipa");

$pukul=app_baca("spt","id='$id'","pukul");
if ($tahun!="") {$th=" Tahun Anggaran ".$tahun;}
if ($dip=="" or $dip=="-") {$dipa="-";} else {$dipa=$dip." ".$th;}
if ($mak!="") {
$makk=", Mata Anggaran Kegiatan $mak";
} else {$makk="."; }
$org="Balai Uji Terap Teknik dan Metode Karantina Pertanian";
$pdf=new PDF_MC_Table('P','mm','A4');
$pdf->SetMargins(25,60,20);
$pdf->AddPage();
$pdf->SetFont('Arial','BU',12);
$pdf->Cell(0,5,'S U R A T   T U G A S',0,1,'C');
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,5,"No: ".str_replace("  ", "&nbsp; ",$no_spt)."",0,1,'C');
$pdf->Cell(0,5,'',0,1,'C');
$pdf->SetFont('Arial','',11);
$pdf->SetWidths(array(18,6,140));
$pdf->Row(array("Dasar   :","1.",$p1));
$pdf->Row(array("","2.","Daftar Isian Pelaksanaan Anggaran (DIPA) ".$org." Tahun Anggaran $tahun"));
$pdf->Cell(0,8,'Memberi Tugas',0,1,'C');

$db = new database();
$db->connect(app_db());

if (app_jml("spt_petugas","id_spt='".$id."'","nip")>3) {
$pdf->SetWidths(array(18,146));
$pdf->SetAligns(array('L','L'));
$pdf->Row(array("Kepada:","Terlampir"));
 } else {
$pdf->SetWidths(array(18,6,40,100));
$pdf->SetAligns(array('L','L','L','L'));
$no=1;
$query = "SELECT * from spt_petugas where id_spt='$id' order by no";
$results = $db->get_results( $query );
foreach( $results as $data )
{
if ($no=="1") {$kep="Kepada:";} else {$kep="";}
$pdf->Row(array($kep,$no.".","Nama / NIP","".$data['nama']."/ ".$data['nip'].""));
$pdf->Row(array("","","Pangkat / Golongan","".pangkat($data['gol'])."/".$data['gol'].""));
$pdf->Row(array("","","Jabatan","".$data['jab'].""));
$no++;
} 
}
$pdf->Cell(0,3,'',0,1,'C');
$pdf->SetWidths(array(18,6,140));
$pdf->SetAligns(array('L','L','J'));
$pdf->Row(array("Untuk   :","1.","$tujuan di $lokasi, $kota pada hari ".waktu($waktu_mulai,$waktu_selesai).pukul($pukul)."."));
$pdf->Row(array("","2.","Biaya perjalanan dinas ini dibebankan pada ".$dipa."".$makk.""));
$pdf->Row(array("","3.","Segera membuat laporan tertulis hasil pelaksanaan kegiatan kepada Kepala ".$org."."));

$pdf->Cell(0,5,'',0,1,'C');
$pdf->SetWidths(array(95,70));
$pdf->SetAligns(array('C','C'));
$pdf->Row(array("","Bekasi, ".tgl_p($tgl)."\n".$kep_jab."\n\n\n\n"));
$pdf->SetFontStyle(array("","BU"));
$pdf->Row(array("","".db_baca(real_db(),"karyawan","id='".$kep_nama."'","nama").""));
$pdf->SetFontStyle(array("",""));
$pdf->Row(array("","NIP. ".db_baca(real_db(),"karyawan","id='".$kep_nama."'","nip").""));
if ($tembusan=="") { } else {
$xx=explode("\n",$tembusan);
$pdf->Cell(0,5,'Tembusan:',0,1,'L');
$pdf->SetWidths(array(7,158));
$pdf->SetAligns(array('L','J'));
foreach ($xx as $x) {
$n+=1;
$pdf->Row(array($n.". ",str_replace("\n","",$x)));
}
}
$code="B-office *".$unik."*";
$pdf->SetDrawColor(111, 111, 111);
$pdf->Line(0,273,210,273);
$pdf->Code128(130,275,$unik,60,8);
$pdf->SetFont('Arial','',6);
$pdf->Text(140,286,$code);
$pdf->Output();
?>
