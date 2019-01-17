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
$org="Balai Uji Terap Teknik dan Metode Karantina Pertanian";
$pdf=new PDF_MC_Table('L','mm',array(210,330));
$pdf->SetMargins(20,15,15);
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


$pdf->SetWidths(array(10,50,27,7,35,140,20));
$pdf->SetBorderColor(array(0,0,0,0,0,0,0,0));
$pdf->SetFontStyle(array("B","B","B","B","B","B","B","B"));
$pdf->SetAligns(array('C','C','C','C','C','C','C','C'));
$pdf->Row(array("NO","NAMA/NIP","TANGGAL","L","KOTA","TUGAS","NOMINAL"));
//$pdf->Row(array("NO","NAMA","NIP","PANGKAT/GOLONGAN","TUJUAN (PP)","TANGGAL BERANGKAT","LAMA PERJALANAN","TRANSPORT","UANG HARIAN","PENGINAPAN","REPRESENTATIF","BIAYA"));
$pdf->SetFontStyle(array("","","","","","","",""));
$pdf->SetAligns(array('C','L','C','C','C','L','R'));
$hari=nama_hari_id($tgl);
$tglp=tgl_p($tgl);
//$m=db_baca(ofc_db(),"spt","id='$id'","waktu_mulai");
//$s=db_baca(ofc_db(),"spt","id='$id'","waktu_selesai");
$query = "SELECT spt.waktu_mulai,spt.waktu_selesai,spt.kota,spt.tujuan,spt_petugas.id,spt_petugas.nama,spt_petugas.nip,spt_petugas.gol from spt_petugas join spt ON spt_petugas.id_spt=spt.id where nom_id='".$nom_id."' order by nama,waktu_selesai";
$results = $db->get_results( $query );
foreach( $results as $data )
{
if ($no=="1") {$kep="Kepada:";} else {$kep="";}
//$jm=jumlah_real($data2['id']);
$lama=lama($data['waktu_mulai'],$data['waktu_selesai']);
if ($data['waktu_mulai']==$data['waktu_selesai']) {$tgl=tgl_p($data['waktu_mulai']);} else {$tgl=tgl_p($data['waktu_mulai'])." - ".tgl_p($data['waktu_selesai']);}	
	
$tj=$data['tujuan'];
$tj=str_replace("Milik/Perusahaan","",$tj);
$tj=str_replace("Melakukan pemeriksaan fisik/kesehatan media pembawa","!@#",$tj);
$tj=str_replace("!@# ","",$tj);
$tj=str_replace("!@#","",$tj);
$tj=str_replace("\r"," ",$tj);
$jm=db_sum("tugasdb","realisasi","id_petugas='".$data['id']."'","total");
$pdf->Row(array($no.".","".$data['nama']."",$tgl,$lama,$data['kota'],$tj,rp($jm)));
$tot+=$jm;
$no+=1;

}



$pdf->SetFontStyle(array("B","B","B","B","B","B","B","B"));
$pdf->Row(array("","JUMLAH KESELURUHAN","","","","",rp($tot)));

$pdf->Output();
?>
