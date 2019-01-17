<?php
require('fpdf/mc_table_pg.php');
include "../class/class.php";
$id=$_GET['id'];
/*
$mak=$_GET['mak'];
$kol=$_GET['kol'];
$h=$_GET['h'];
$ht=$_GET['ht'];
 $mulai=$_GET['m'];
 $akhir=$_GET['a'];
$hal=10;
$h1=($h-1)*$hal;
$h2=$h1+$hal;
*/
function jumlah_real($id) {
$db = new database();
$db->connect("tugasdb");
$query = "SELECT total from realisasi where id_petugas='$id'";
$results = $db->get_results( $query );
foreach( $results as $data )
{	
$rp+=$data['total'];
}
return $rp;
}

$nom_id=$_GET['nom_id'];
$db = new database();
$db->connect("tugasdb");
$query = "SELECT * from spt where nom_id='$nom_id' order by waktu_mulai,waktu_selesai";
$results = $db->get_results( $query );
foreach( $results as $data )
{$nn++;
if ($nn==1) {$mulai=$data['waktu_mulai'];}
$akhir=$data['waktu_selesai'];
}
$pdf=new PDF_MC_Table('L','mm',array(210,330));
$pdf->SetMargins(25,20,20);
$pdf->AddPage();
$pdf->SetFont('Arial','B',11);
//$mak=db_baca(ofc_db(),"spt","id='$id'","mak");
//$tahun=db_baca(ofc_db(),"spt","id='$id'","tahun");
//if ($tahun>="2018") {$mak=db_baca("b_realisasi_".$tahun,"pok","no='".$mak."'","mak");}
$mak=rq_baca("pok","no='".$_GET['mak']."'","mak");
$ur=rq_baca("pok","no='".$_GET['mak']."'","uraian");
$pdf->MultiCell(0,5,"DAFTAR NOMINATIF PERJALANAN DINAS DALAM RANGKA
".str_replace("- ","",strtoupper($ur))."
PERIODE  : ".strtoupper(tgl_p($mulai))." S.D ".strtoupper(tgl_p($akhir))."
BALAI BESAR KARANTINA PERTANIAN TANJUNG PRIOK
AKUN: ".$mak."",0,'C');
$no=1;


$pdf->SetWidths(array(10,60,50,40,40,20,30,30));
$pdf->SetBorderColor(array(0,0,0,0,0,0,0,0));
$pdf->SetFontStyle(array("B","B","B","B","B","B","B","B"));
$pdf->SetAligns(array('C','C','C','C','C','C','C','C'));
$pdf->Row(array("NO","NAMA/NIP","PANGKAT/GOLONGAN","TUJUAN","TANGGAL","LAMA","JUMLAH","TANDA TERIMA"));
//$pdf->Row(array("NO","NAMA","NIP","PANGKAT/GOLONGAN","TUJUAN (PP)","TANGGAL BERANGKAT","LAMA PERJALANAN","TRANSPORT","UANG HARIAN","PENGINAPAN","REPRESENTATIF","BIAYA"));
$pdf->SetFontStyle(array("","","","","","","",""));
$pdf->SetAligns(array('C','L','L','L','C','C','R','C'));
$hari=nama_hari_id($tgl);
$tglp=tgl_p($tgl);
//$m=db_baca(ofc_db(),"spt","id='$id'","waktu_mulai");
//$s=db_baca(ofc_db(),"spt","id='$id'","waktu_selesai");
$nn=0;

$query1 = "SELECT * from spt_petugas join spt ON spt_petugas.id_spt=spt.id where nom_id='$nom_id'";
$results1 = $db->get_results( $query1 );
foreach( $results1 as $data1 )
{
$nn++;	
}

foreach( $results as $data )
{
if ($no=="1") {$kep="Kepada:";} else {$kep="";}
//$jm=jumlah_real($data2['id']);
$lama=lama($data['waktu_mulai'],$data['waktu_selesai']);
if ($data['waktu_mulai']==$data['waktu_selesai']) {$tgl=tgl_p($data['waktu_mulai']);} else {$tgl=tgl_p($data['waktu_mulai'])." - ".tgl_p($data['waktu_selesai']);}

$query2 = "SELECT * from spt_petugas where id_spt='".$data['id']."' order by no,id";
$results2 = $db->get_results( $query2 );
foreach( $results2 as $data2 )
{
$jm=db_sum("tugasdb","realisasi","id_petugas='".$data2['id']."'","total");
$pdf->Row(array($no.".","".$data2['nama']."\n".$data2['nip']."",db_baca("user_login","gol","gol='".$data2['gol']."'","pangkat")."/".strtoupper($data2['gol'])."",$data['kota'],$tgl,$lama." hari",rp($jm),""));
$tot+=$jm;
if ($nn==$no) { } else {
if ($no==10 or $no==20 or $no==30 or $no==40 or $no==50 or $no==60 or $no==70 or $no==80 or $no==90 or $no==100 or $no==110 or $no==120 or $no==130 or $no==140 or $no==150 or $no==160 or $no==170 or $no==180 or $no==190 or $no==200 or $no==210 or $no==220 or $no==230 or $no==240 or $no==250 or $no==260 or $no==270 or $no==280 or $no==290 or $no==300 or $no==310 or $no==320 or $no==330 or $no==340 or $no==350 or $no==360 or $no==370 or $no==380 or $no==390 or $no==400 or $no==410 or $no==420 or $no==430 or $no==440 or $no==450 or $no==460 or $no==470 or $no==480 or $no==490 or $no==500 or $no==510 or $no==520 or $no==530 or $no==540) {
$pdf->SetFontStyle(array("B","B","B","B","B","B","B","B"));
$pdf->Row(array("","JUMLAH DIPINDAHKAN","","","","",rp($tot),""));
$pdf->AddPage();
$pdf->SetAligns(array('C','C','C','C','C','C','C','C'));
$pdf->Row(array("NO","NAMA/NIP","PANGKAT/GOLONGAN","TUJUAN","TANGGAL","LAMA","JUMLAH","TANDA TERIMA"));
$pdf->SetAligns(array('C','L','L','L','C','C','R','C'));
$pdf->Row(array("","JUMLAH PINDAHAN","","","","",rp($tot),""));
$pdf->SetFontStyle(array("","","","","","","",""));

}
}
$no+=1;

}

}

$pdf->SetFontStyle(array("B","B","B","B","B","B","B","B"));
$pdf->Row(array("","JUMLAH KESELURUHAN","","","","",rp($tot),""));
//$ppk_nama=db_baca(ofc_db(),"spt","id='$id'","ppk_nama");
$pdf->Cell(0,5,'',0,1,'C');
$pdf->SetWidths(array(210,70));
$pdf->SetBorderColor(array(255,255));
$pdf->SetAligns(array('C','C'));
$pdf->SetFontStyle(array("",""));
$pdf->Row(array("","Jakarta, ".tgl_p(tgl_aju($akhir))."\nPejabat Pembuat Komitmen\n\n\n\n"));
$pdf->SetFontStyle(array("","BU"));
$pdf->Row(array("","".rq_baca("pok","no='".$_GET['mak']."'","ppk_nama").""));
$pdf->SetFontStyle(array("",""));
$pdf->Row(array("","NIP. ".rq_baca("pok","no='".$_GET['mak']."'","ppk_nip").""));

$pdf->Output();
?>
